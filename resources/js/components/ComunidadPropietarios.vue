<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div id="crear" class="d-flex flex-wrap justify-content-between align-items-center my-2">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modificar" v-on:click="prepareCreate()">Nuevo Propietario</button>
            </div>

            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="d-none d-sm-table-cell">Email</th>
                        <th scope="col" class="d-none d-md-table-cell">Teléfono</th>
                        <th scope="col" class="d-none d-lg-table-cell">DNI</th>
                        <th scope="col" class="d-none d-lg-table-cell">IBAN</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="propietario in elementosMostrados" v-bind:key="propietario.id">
                        <td>{{ propietario.nombre }}</td>
                        <td class="d-none d-sm-table-cell">{{ propietario.email }}</td>
                        <td class="d-none d-md-table-cell">{{ propietario.telefono }}</td>
                        <td class="d-none d-lg-table-cell">{{ propietario.nif }}</td>
                        <td class="d-none d-lg-table-cell">{{ propietario.iban }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modificar" v-on:click="prepareUpdate(propietario)"><i class="far fa-edit"></i></button>
                            <button type="button" class="btn btn-danger btn-sm d-none d-lg-inline-block" v-on:click="deleteItem(propietario.id)"><i class="far fa-trash-alt"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--Paginador-->
            <nav aria-label="Paginador propietarios">
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
                            <h5 class="modal-title" id="modificarModal" v-if="modalForm == 'create'">Nuevo Propietario</h5>
                            <h5 class="modal-title" id="modificarModal" v-else>Modificar Propietario</h5>
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
                                <label for="email" class="align-self-center">Email</label>
                                <input id="email" v-model="modalEmail" type="email"/>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="telefono" class="align-self-center">Teléfono</label>
                                <input id="telefono" v-model="modalTelf" type="tel" maxlength="15"/>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="dni" class="align-self-center">DNI</label>
                                <input id="dni" v-model="modalDNI" type="text" maxlength="9" pattern="[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]|[XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE]" title="Formato: 12345678A o X1234567A"/>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="iban" class="align-self-center">IBAN</label>
                                <input id="iban" v-model="modalIBAN" type="text" maxlength="43" pattern="^([A-Z]{2}[ \-]?[0-9]{2})(?=(?:[ \-]?[A-Z0-9]){9,30}$)((?:[ \-]?[A-Z0-9]{3,5}){2,7})([ \-]?[A-Z0-9]{1,3})?$"/>
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
    import {eventBus} from "../app.js";
    export default {
        props: ['comunidad_id'],
        data: function () {
            return{
                bearer: 'Bearer ' + $cookies.get("api_token"),
                propietarios: [],
                tipos: [],
                pagina: 1,
                porPagina: 10,
                paginas: [],
                modalForm: '',
                modalId: null,
                modalNombre: '',
                modalEmail: '',
                modalTelf: '',
                modalDNI: '',
                modalIBAN: ''
            };
        },
        created() {
            this.getPropietarios().then(data => (this.propietarios = data));
            console.log('Component created');
        },
        mounted() {
            console.log('Component mounted');
        },
        computed: {
            elementosMostrados: function () {
                return this.paginar(this.propietarios);
            }
        },
        watch: {
            propietarios: function () {
                this.setPaginador(this.propietarios);
            }
        },
        methods: {
            getPropietarios: function () {
                return axios.get('/api/comunidad/' + this.comunidad_id + '/propietarios',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            return response.data;
                        });
            },
            prepareUpdate: function (propietario) {
                this.modalForm = 'update';
                this.modalId = propietario.id;
                this.modalNombre = propietario.nombre;
                this.modalEmail = propietario.email;
                this.modalTelf = propietario.telefono;
                this.modalDNI = propietario.nif;
                this.modalIBAN = propietario.iban;
            },
            updateItem: function () {
                axios.put('/api/comunidad/' + this.comunidad_id + '/propietarios/' + this.modalId,
                        {//datos
                            nombre: this.modalNombre,
                            email: this.modalEmail,
                            telefono: this.modalTelf,
                            nif: this.modalDNI,
                            iban: this.modalIBAN
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Propitario modificado");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible modificar propietario");
                            window.location.reload();
                            console.log(error.response);
                        });
            },
            deleteItem: function (id) {
                if (confirm('¿Eliminar propietario?')) {
                    axios.delete('/api/comunidad/' + this.comunidad_id + '/propietarios/' + id,
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                }
                            })
                            .then(response => {
                                alert("Propietario eliminado");
                                window.location.reload();
                            })
                            .catch(error => {
                                alert("No ha sido posible eliminar al propietario");
                                console.log(error.response);
                            });
                }
            },
            prepareCreate: function () {
                this.modalForm = 'create';
                this.modalId = null;
                this.modalNombre = '';
                this.modalEmail = '';
                this.modalTelf = '';
                this.modalDNI = '';
                this.modalIBAN = '';
            },
            createItem: function () {
                axios.post('/api/comunidad/' + this.comunidad_id + '/propietarios',
                        {//datos
                            nombre: this.modalNombre,
                            email: this.modalEmail,
                            telefono: this.modalTelf,
                            dni: this.modalDNI,
                            iban: this.modalIBAN
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Propietario creado");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible insertar propietario");
                            window.location.reload();
                            console.log(error.response);
                        });
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
        font-size: 0.85em;
        text-align: center;
    }
    td {
        vertical-align: middle;
    }
    label{
        width: 70px;
        margin: 0;
    }

</style>
