<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col mb-2">
                <div class="d-flex justify-content-end m-2">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" v-on:click="prepareCreate()">Nuevo Ingreso</button>
                </div>
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Concepto</th>
                            <th scope="col">Importe</th>
                            <th scope="col">F. de pago</th>
                            <th scope="col" class="d-none d-lg-table-cell">Referencia</th>
                            <th scope="col" class="d-none d-md-table-cell">Cuenta</th>
                            <th scope="col" class="d-none d-lg-table-cell">Fondo</th>
                            <th scope="col">Tipo de ingreso</th>
                            <th scope="col" class="d-none d-md-table-cell">Propiedad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ingreso in elementosMostrados" v-bind:key="ingreso.id">
                            <td><a data-toggle="modal" data-target="#modal" v-on:click="prepareUpdate(ingreso)">{{ ingreso.fecha_ingreso }}</a></td>
                            <td>{{ ingreso.concepto }}</td>
                            <td>{{ ingreso.importe }}€</td>
                            <td class="d-none d-lg-table-cell">{{ ingreso.forma_pago }}</td>
                            <td class="d-none d-lg-table-cell">{{ ingreso.referencia }}</td>
                            <td class="d-none d-md-table-cell">{{ ingreso.banco }}</td>
                            <td class="d-none d-lg-table-cell">{{ ingreso.fondo }}</td>
                            <td>{{ ingreso.tipo_ingreso }}</td>
                            <td class="d-none d-md-table-cell">{{ ingreso.propiedad }}</td>
                        </tr>
                    </tbody>
                </table>
                <!--Paginador-->
                <div class="d-flex flex-row justify-content-center m-2">
                    <nav aria-label="Paginador">
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
            </div>
        </div>
        <!-- Modal para modificar-->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modificarModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form autocomplete="off" v-on:submit.prevent="modalForm == 'create' ? createItem() : updateItem()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modificarModal" v-if="modalForm == 'create'">Nuevo Ingreso</h5>
                            <h5 class="modal-title" id="modificarModal" v-else>Modificar Ingreso</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-row mb-2">
                                <label for="propiedad" class="align-self-center">Propiedad</label>
                                <select id="propiedad" v-model="modalPropiedad" v-bind:disabled="modalForm == 'update'"">
                                    <option value="">No</option>
                                    <option v-for="propiedad in propiedades" v-bind:value="propiedad.id"> {{propiedad.descripcion}}</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="concepto" class="align-self-center">Concepto</label>
                                <input id="concepto" v-model="modalConcepto" type="text" required/>
                            </div>
                            <div class="d-flex flex-row mb-2 align-items-center">
                                <label for="importe">Importe</label>
                                <input id="importe" style="text-align:right;" v-model="modalImporte" type="number" min="0" step="0.01" required/>
                                <span>€</span>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="fecIngreso" class="align-self-center">Fecha Ingreso</label>
                                <input id="fecIngreso" v-model="modalFecIngreso" type="date" required/>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="fpago" class="align-self-center">Forma de Pago</label>
                                <select id="fpago" v-model="modalForPago" required>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="referencia" class="align-self-center">Referencia</label>
                                <input id="referencia" v-model="modalRef" type="text"/>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="cuenta" class="align-self-center">Cuenta</label>
                                <select id="cuenta" v-model="modalCuenta" required>
                                    <option disabled value="">Selecciona una cuenta</option>
                                    <option v-for="cuenta in cuentas" v-bind:value="cuenta.id"> {{ cuenta.banco }}</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="fondo" class="align-self-center">Fondo</label>
                                <select id="fondo" v-model="modalFondo" required>
                                    <option disabled value="">Selecciona un fondo</option>
                                    <option v-for="fondo in fondos" v-bind:value="fondo.id"> {{fondo.nombre}}</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="tingreso" class="align-self-center">Tipo de ingreso</label>
                                <select id="tingreso" v-model="modalTipoIngreso" required>
                                    <option value="ordinario">Ordinario</option>
                                    <option value="extraordinario">Extraordinario</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" v-if="modalForm == 'create'">Crear Ingreso</button>
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
                pagina: 1,
                porPagina: 10,
                paginas: [],
                ingresos: [],
                cuentas: [],
                fondos: [],
                propiedades: [],
                modalForm: '',
                modalId: null,
                modalConcepto: '',
                modalFecIngreso: '',
                modalImporte: 0,
                modalForPago: '',
                modalTipoIngreso: '',
                modalRef: '',
                modalCuenta: '',
                modalFondo: '',
                modalPropiedad: '',
                fechaActual: new Date().toISOString().slice(0, 10)

            };
        },
        created() {
            this.getFondos();
            this.getCuentas();
            this.getPropiedades();
            this.getIngresos();
            console.log('Component created');
        },
        mounted() {
            console.log('Component mounted');
        },
        computed: {
            elementosMostrados: function () {
                return this.paginar(this.ingresos);
            }
        },
        watch: {
            ingresos: function () {
                this.setPaginador(this.ingresos);
            }
        },
        methods: {
            getFondos: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/fondos',
                        {
                            headers: {
                                'Authorization': this.bearer
                            }
                        }).then(response => (this.fondos = response.data));
            },
            getCuentas: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/cuentas',
                        {
                            headers: {
                                'Authorization': this.bearer
                            }
                        }).then(response => (this.cuentas = response.data))
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
            getIngresos: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/ingresos',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => (this.ingresos = response.data));
            },
            prepareCreate: function () {
                this.modalForm = 'create';
                this.modalId = null;
                this.modalConcepto = '';
                this.modalFecIngreso = this.fechaActual;
                this.modalImporte = 0;
                this.modalForPago = 'Efectivo';
                this.modalTipoIngreso = 'ordinario';
                this.modalRef = '';
                this.modalCuenta = '';
                this.modalFondo = '';
                this.modalPropiedad = '';
            },
            prepareUpdate: function (ingreso) {
                this.modalForm = 'update';
                this.modalId = ingreso.id;
                this.modalConcepto = ingreso.concepto;
                this.modalFecIngreso = ingreso.fecha_ingreso;
                this.modalImporte = ingreso.importe;
                this.modalForPago = ingreso.forma_pago;
                this.modalTipoIngreso = ingreso.tipo_ingreso;
                this.modalRef = ingreso.refencia;
                this.modalCuenta = ingreso.id_cuenta;
                this.modalFondo = ingreso.id_fondo;
            },
            createItem: function () {
                axios.post('/api/comunidad/' + this.comunidad_id + '/ingresos',
                        {//datos
                            concepto: this.modalConcepto,
                            fecha_ingreso: this.modalFecIngreso,
                            importe: this.modalImporte,
                            forma_pago: this.modalForPago,
                            tipo_ingreso: this.modalTipoIngreso,
                            referencia: this.modalRef,
                            id_cuenta: this.modalCuenta,
                            id_fondo: this.modalFondo,
                            id_propiedad: this.modalPropiedad
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("ingreso creado");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible crear ingreso");
                            console.log(error.response);
                        });
            },
            updateItem: function () {
                axios.put('/api/comunidad/' + this.comunidad_id + '/ingresos/' + this.modalId,
                        {//datos
                            concepto: this.modalConcepto,
                            fecha_ingreso: this.modalFecIngreso,
                            importe: this.modalImporte,
                            forma_pago: this.modalForPago,
                            tipo_ingreso: this.modalTipoIngreso,
                            referencia: this.modalRef,
                            id_cuenta: this.modalCuenta,
                            id_fondo: this.modalFondo
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Ingreso modificado");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible modificar Ingreso");
                            console.log(error.response);
                        });
            },
            deleteItem: function (id) {
                if (confirm('¿Eliminar ingreso?')) {
                    axios.delete('/api/comunidad/' + this.comunidad_id + '/ingresos/' + id,
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                }
                            })
                            .then(response => {
                                alert("Ingreso eliminado");
                                window.location.reload();
                            })
                            .catch(error => {
                                alert("No ha sido posible eliminar el ingreso");
                                console.log(error.response);
                            });
                }
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
        font-size: 0.7em;
        text-align: center;
    }
    td {
        vertical-align: middle;
    }
    td a {
        color: #007bff;
        text-decoration: underline;
    }
    label{
        width: 120px;
        margin: 0;
    }
    option {
        font-size: 0.8em;
    }

</style>
