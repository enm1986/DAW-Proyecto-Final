<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div>
                <span>Coeficiente Total: </span>
                <span v-bind:class="{'coefmax': isCoefMax(), 'text-danger': !isCoefMax()}">{{ coefTotal }} %</span>       
            </div>

            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Coeficiente</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="propiedad in propiedades" v-bind:key="propiedad.id">
                        <td>{{ propiedad.tipo }}</td>
                        <td>{{ propiedad.descripcion }}</td>
                        <td>{{ propiedad.coeficiente }} %</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modificar" v-on:click="prepareUpdate(propiedad)">Modificar</button>
                            <button type="button" class="btn btn-danger btn-sm" v-on:click="deletePropiedad(propiedad.id)">Borrar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Modal para modificar-->
        <div class="modal fade" id="modificar" tabindex="-1" role="dialog" aria-labelledby="modificarModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modificarModal">Modificar Propiedad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-row align-content-center mb-2">
                            <label for="tipo" class="align-self-center">Tipo</label>
                            <select id="tipo" v-model="modalTipo">
                                <option disabled value="">Tipo</option>
                                <option v-for="tipo in tipos" v-bind:value="tipo.id"> {{tipo.tipo}}</option>
                            </select>
                        </div>
                        <div class="d-flex flex-row mb-2">
                            <label for="descripcion" class="align-self-center">Descripcion</label>
                            <input id="descripcion" v-model="modalDesc" type="text"/>
                        </div>
                        <div class="d-flex flex-row mb-2">
                            <label for="coeficiente" class="align-self-center">Coeficiente</label>
                            <input id="coeficiente" v-model="modalCoef" type="number" step="0.01"/> %
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" v-on:click="updatePropiedad">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['comunidad_id'],
        data: function () {
            return{
                bearer: 'Bearer ' + $cookies.get("api_token"),
                propiedades: [],
                tipos: [],
                modalId: null,
                modalTipo: "",
                modalDesc: "",
                modalCoef: 0,
                modalCoefAnt: 0
            };
        },
        mounted() {
            this.getTipos();
            this.getPropiedades();
            console.log('Component mounted.');
        },
        computed: {
            coefTotal: function () {
                let total = 0;
                this.propiedades.forEach(function (propiedad) {
                    total += Number.parseFloat(propiedad.coeficiente);
                });
                return total;
            }
        },
        methods: {
            isCoefMax: function () {
                return this.coefTotal === 100;
            },
            getTipos: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/propiedades/tipos', {
                    headers: {
                        'Authorization': this.bearer
                    }
                }).then(response => (this.tipos = response.data));
            },
            getPropiedades: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/propiedades',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => (this.propiedades = response.data));
            },
            prepareUpdate: function (propiedad) {
                this.modalId = propiedad.id;
                this.modalTipo = propiedad.id_tipo;
                this.modalDesc = propiedad.descripcion;
                this.modalCoef = Number.parseFloat(propiedad.coeficiente);
                this.modalCoefAnt = Number.parseFloat(propiedad.coeficiente);
            },
            updatePropiedad: function () {
                if ((this.coefTotal - this.modalCoefAnt + Number.parseFloat(this.modalCoef)) <= 100) {
                    axios.put('/api/comunidad/' + this.comunidad_id + '/propiedades/' + this.modalId,
                            {//datos
                                tipo: this.modalTipo,
                                descripcion: this.modalDesc,
                                coeficiente: this.modalCoef
                            },
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                }
                            })
                            .then(response => {
                                alert("Propiedad modificada");
                            })
                            .catch(error => {
                                alert("Imposible modificar la propiedad");
                                window.location.reload();
                                console.log(error.response);
                            });
                    window.location.reload();
                } else {
                    alert('No se debe superar el 100% de Coeficiente Total');
                }
            },
            deletePropiedad: function (id) {
                axios.delete('/api/comunidad/' + this.comunidad_id + '/propiedades/' + id,
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Propiedad eliminada");
                            window.location.reload();
                            //console.log(response);
                        })
                        .catch(error => {
                            alert("No ha sido posible eliminar la propiedad");
                            console.log(error.response);
                        });
            }
        }
    }
</script>
<style scoped>
    label{
        width: 80px;
        margin: 0;
    }
    .coefmax{
        color: green !important;
    }
</style>
