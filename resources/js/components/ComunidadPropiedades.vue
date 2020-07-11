<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div id="crear" class="d-flex flex-wrap justify-content-between align-items-center my-2">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modificar" v-on:click="prepareCreate()">Nueva Propiedad</button>
                <div>
                    <span>Coeficiente Total: </span>
                    <span v-bind:class="{'text-success': isCoefMax(), 'text-danger': !isCoefMax()}">{{ coefTotal }} %</span>       
                </div>
            </div>

            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="d-none d-md-table-cell">Tipo</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Coeficiente</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="propiedad in elementosMostrados" v-bind:key="propiedad.id">
                        <td class="d-none d-md-table-cell">{{ propiedad.tipo }}</td>
                        <td>{{ propiedad.descripcion }}</td>
                        <td>{{ propiedad.coeficiente }} %</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modificar" v-on:click="prepareUpdate(propiedad)"><i class="far fa-edit"></i></button>
                            <button type="button" class="btn btn-danger btn-sm" v-on:click="deleteItem(propiedad.id)"><i class="far fa-trash-alt"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--Paginador-->
            <nav aria-label="Paginador propiedades">
                <ul class="pagination">
                    <li class="page-item">
                        <button type="button" class="page-link" v-if="pagina != 1" @click="pagina--">&laquo;</button>
                    </li>
                    <li class="page-item">
                        <button type="button" class="page-link" v-bind:class="{'bg-info text-light': pagina==npagina}" v-for="npagina in paginas.slice(pagina-2 > 0 ? pagina-3 : 0, pagina+2)" @click="pagina=npagina">{{npagina}}</button>
                    </li>
                    <li class="page-item">
                        <button type="button" class="page-link" v-if="pagina < paginas.length" @click="pagina++">&raquo;</button>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- Modal para modificar/crear-->
        <div class="modal fade" id="modificar" tabindex="-1" role="dialog" aria-labelledby="modificarModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form autocomplete="off" v-on:submit.prevent="modalForm == 'create' ? createItem() : updateItem()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modificarModal" v-if="modalForm == 'create'">Nueva Propiedad</h5>
                            <h5 class="modal-title" id="modificarModal" v-else>Modificar Propiedad</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-row align-content-center mb-2">
                                <label for="tipo" class="align-self-center">Tipo</label>
                                <select id="tipo" v-model="modalTipo" required>
                                    <option disabled value="">Tipo</option>
                                    <option v-for="tipo in tipos" v-bind:value="tipo.id"> {{tipo.tipo}}</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="descripcion" class="align-self-center">Descripcion</label>
                                <input id="descripcion" v-model="modalDesc" type="text" required/>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="coeficiente" class="align-self-center">Coeficiente</label>
                                <input id="coeficiente" v-model="modalCoef" type="number" min="0" max="100" step="0.01" required/> %
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" v-if="modalForm == 'create'">Insertar</button>
                            <div v-else>
                                <button type="button" class="btn btn-danger" v-on:click="deleteItem(modalId)">Eliminar</button>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
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
                pagina: 1,
                porPagina: 10,
                paginas: [],
                modalForm: '',
                modalId: null,
                modalTipo: '',
                modalDesc: '',
                modalCoef: 0,
                modalCoefAnt: 0
            };
        },
        created() {
            this.getTipos();
            this.getPropiedades().then(data => (this.propiedades = data));
            console.log('Component created');
        },
        mounted() {
            console.log('Component mounted');
        },
        computed: {
            coefTotal: function () {
                let total = 0;
                this.propiedades.forEach(function (propiedad) {
                    total += Number.parseFloat(propiedad.coeficiente);
                });
                return total;
            },
            elementosMostrados: function () {
                return this.paginar(this.propiedades);
            }
        },
        watch: {
            propiedades: function () {
                this.setPaginador(this.propiedades);
            }
        },
        methods: {
            getTipos: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/propiedades/tipos', {
                    headers: {
                        'Authorization': this.bearer
                    }
                }).then(response => (this.tipos = response.data));
            },
            getPropiedades: function () {
                return axios.get('/api/comunidad/' + this.comunidad_id + '/propiedades',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {return response.data;});
                        //.then(response => (this.propiedades = response.data));
            },
            prepareUpdate: function (propiedad) {
                this.modalForm = 'update';
                this.modalId = propiedad.id;
                this.modalTipo = propiedad.id_tipo;
                this.modalDesc = propiedad.descripcion;
                this.modalCoef = this.modalCoefAnt = Number.parseFloat(propiedad.coeficiente);
            },
            updateItem: function () {
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
            deleteItem: function (id) {
                if (confirm('¿Eliminar propiedad?')) {
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
            },
            prepareCreate: function () {
                this.modalForm = 'create';
                this.modalId = null;
                this.modalTipo = '';
                this.modalDesc = '';
                this.modalCoef = this.modalCoefAnt = 0;
            },
            createItem: function () {
                if ((this.coefTotal + Number.parseFloat(this.modalCoef)) <= 100) {
                    axios.post('/api/comunidad/' + this.comunidad_id + '/propiedades',
                            {//datos
                                id_tipo: this.modalTipo,
                                descripcion: this.modalDesc,
                                coeficiente: this.modalCoef
                            },
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                }
                            })
                            .then(response => {
                                alert("Propiedad creada");
                                window.location.reload();
                            })
                            .catch(error => {
                                alert("Imposible insertar la propiedad");
                                window.location.reload();
                                console.log(error.response);
                            });
                } else {
                    alert('No se debe superar el 100% de Coeficiente Total');
                }
            },
            isCoefMax: function () {
                return this.coefTotal === 100;
            },
            setPaginador: function (items) {
                let npaginas = Math.ceil(items.length / this.porPagina);
                for (let i = 1; i <= npaginas; i++) {
                    this.paginas.push(i);
                }
            },
            paginar: function (items) {
                let desde = (this.pagina * this.porPagina) - this.porPagina;
                let hasta = (this.pagina * this.porPagina);
                return items.slice(desde, hasta);
            }
        }
    }
</script>
<style scoped>
    #crear{
        width: 100%;
    }
    button.page-link{
        display: inline-block;
    }
    table{
        font-size: 0.9em;
        text-align: center;
    }
    td {
        vertical-align: middle;
    }
    label{
        width: 80px;
        margin: 0;
    }

</style>
