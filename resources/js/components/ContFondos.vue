<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-2">
                <div class="d-flex justify-content-end m-2">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" v-on:click="prepareCreate()">Nuevo Fondo</button>
                </div>
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Fondo</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Saldo</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="fondo in fondos" v-bind:key="fondo.id">
                            <td>{{ fondo.nombre }}</td>
                            <td>{{ fondo.descripcion }}</td>
                            <td>{{ fondo.ingresos - fondo.gastos }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" v-on:click="prepareUpdate(fondo)"><i class="far fa-edit"></i></button>
                                <button type="button" class="btn btn-info btn-sm" v-on:click="estadoFondo(fondo)"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal para modificar/crear-->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modificarModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form autocomplete="off" v-on:submit.prevent="modalForm == 'create' ? createItem() : updateItem()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modificarModal" v-if="modalForm == 'create'">Nuevo Fondo</h5>
                            <h5 class="modal-title" id="modificarModal" v-else>Modificar Fondo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-row mb-2">
                                <label for="nombre" class="align-self-center">Nombre</label>
                                <input id="nombre" v-model="modalNombre" type="text" required/>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="email" class="align-self-center">Descripción</label>
                                <input id="email" v-model="modalDesc" type="text"/>
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
                fondos: [],
                modalForm: '',
                modalId: null,
                modalNombre: '',
                modalDesc: ''
            };
        },
        created() {
            this.getFondos();
            console.log('Component created');
        },
        mounted() {
            console.log('Component mounted');
        },
        computed: {},
        watch: {},
        methods: {
            getFondos: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/fondos', {
                    headers: {
                        'Authorization': this.bearer
                    }
                }).then(response => (this.fondos = response.data));
            },
            prepareCreate: function () {
                this.modalForm = 'create';
                this.modalId = null;
                this.modalNombre = '';
                this.modalDesc = '';
            },
            prepareUpdate: function (fondo) {
                this.modalForm = 'update';
                this.modalId = fondo.id;
                this.modalNombre = fondo.nombre;
                this.modalDesc = fondo.descripcion;
            },
            createItem: function () {
                axios.post('/api/comunidad/' + this.comunidad_id + '/fondos',
                        {//datos
                            nombre: this.modalNombre,
                            descripcion: this.modalDesc
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Fondo creado");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible crear fondo");
                            console.log(error.response);
                        });
            },
            updateItem: function () {
                axios.put('/api/comunidad/' + this.comunidad_id + '/fondos/' + this.modalId,
                        {//datos
                            nombre: this.modalNombre,
                            descripcion: this.modalDesc
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Fondo modificado");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible modificar Fondo");
                            console.log(error.response);
                        });
            },
            deleteItem: function (id) {
                if (confirm('¿Eliminar fondo?')) {
                    axios.delete('/api/comunidad/' + this.comunidad_id + '/fondo/' + id,
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                }
                            })
                            .then(response => {
                                alert("Fondo eliminado");
                                window.location.reload();
                            })
                            .catch(error => {
                                alert("No ha sido posible eliminar el fondo");
                                console.log(error.response);
                            });
                }
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
