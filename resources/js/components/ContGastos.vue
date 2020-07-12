<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col mb-2">
                <div class="d-flex justify-content-end m-2">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" v-on:click="prepareCreate()">Nuevo Gasto</button>
                </div>
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Concepto</th>
                            <th scope="col">Importe</th>
                            <th scope="col">Cuenta</th>
                            <th scope="col">Referencia</th>
                            <th scope="col">Tipo de gasto</th>
                            <th scope="col">F. de pago</th>
                            <th scope="col">Fondo</th>
                            <th scope="col">Propiedad</th>
                            <th scope="col">Pagado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="gasto in gastos" v-bind:key="gasto.id">
                            <td><a data-toggle="modal" data-target="#modal" v-on:click="prepareUpdate(gasto)">{{ gasto.fecha_factura }}</a></td>
                            <td>{{ gasto.proveedor }}</td>
                            <td>{{ gasto.concepto }}</td>
                            <td>{{ gasto.importe }}</td>
                            <td>{{ gasto.banco }}</td>
                            <td>{{ gasto.referencia }}</td>
                            <td>{{ gasto.tipo_gasto }}</td>
                            <td>{{ gasto.forma_pago }}</td>
                            <td>{{ gasto.fondo }}</td>
                            <td>{{ gasto.propiedad }}</td>
                            <td>{{ gasto.fecha_pago }}</td>
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
                            <h5 class="modal-title" id="modificarModal" v-if="modalForm == 'create'">Nuevo Gasto</h5>
                            <h5 class="modal-title" id="modificarModal" v-else>Modificar Gasto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-row mb-2">
                                <label for="proveedor" class="align-self-center">Proveedor</label>
                                <select id="proveedor" v-model="modalProveedor">
                                    <option v-for="proveedor in proveedores" v-bind:value="proveedor.id"> {{proveedor.nombre}}</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="concepto" class="align-self-center">Concepto</label>
                                <input id="concepto" v-model="modalConcepto" type="text"/>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="fecFactura" class="align-self-center">Fecha Factura</label>
                                <input id="fecFactura" v-model="modalFecFactura" type="date" required/>
                            </div>
                            <div class="d-flex flex-row mb-2 align-items-center">
                                <label for="importe">Importe</label>
                                <input id="importe" style="text-align:right;" v-model="modalImporte" type="number" min="0" step="0.01" required/>
                                <span>€</span>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="fpago" class="align-self-center">Forma de Pago</label>
                                <select id="fpago" v-model="modalForPago" required>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="tgasto" class="align-self-center">Tipo de gasto</label>
                                <select id="tgasto" v-model="modalTipoGasto" required>
                                    <option value="ordinario">Ordinario</option>
                                    <option value="extraordinario">Extraordinario</option>
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
                                <label for="propiedad" class="align-self-center">Propiedad</label>
                                <select id="propiedad" v-model="modalPropiedad">
                                    <option v-for="propiedad in propiedades" v-bind:value="propiedad.id"> {{propiedad.descripcion}}</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row mb-2">
                                <label for="fecPago" class="align-self-center">Fecha de Pago</label>
                                <input id="fecPago" v-model="modalFecPago" type="date"/>
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
                gastos: [],
                proveedores: [],
                cuentas: [],
                fondos: [],
                propiedades: [],
                modalForm: '',
                modalId: null,
                modalProveedor: '',
                modalConcepto: '',
                modalFecFactura: '',
                modalImporte: 0,
                modalForPago: '',
                modalTipoGasto: '',
                modalRef: '',
                modalCuenta: '',
                modalFondo: '',
                modalPropiedad: '',
                modalFecPago: ''

            };
        },
        created() {
            this.getFondos();
            this.getCuentas();
            this.getProveedores();
            this.getPropiedades();
            this.getGastos();
            console.log('Component created');
        },
        mounted() {
            console.log('Component mounted');
        },
        computed: {},
        watch: {},
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
            getProveedores: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/proveedores',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => (this.proveedores = response.data));
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
            getGastos: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/gastos',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => (this.gastos = response.data));
            },
            prepareCreate: function () {
                this.modalForm = 'create';
                this.modalId = null;
                this.modalProveedor = '';
                this.modalConcepto = '';
                this.modalFecFactura = null;
                this.modalImporte = 0;
                this.modalForPago = 'Efectivo';
                this.modalTipoGasto = 'ordinario';
                this.modalRef = '';
                this.modalCuenta = '';
                this.modalFondo = '';
                this.modalPropiedad = '';
                this.modalFecPago = null;
            },
            prepareUpdate: function (gasto) {
                this.modalForm = 'update';
                this.modalId = gasto.id;
                this.modalProveedor = gasto.id_proveedor;
                this.modalConcepto = gasto.concepto;
                this.modalFecFactura = gasto.fecha_factura;
                this.modalImporte = gasto.importe;
                this.modalForPago = gasto.forma_pago;
                this.modalTipoGasto = gasto.tipo_gasto;
                this.modalRef = gasto.refencia;
                this.modalCuenta = gasto.id_cuenta;
                this.modalFondo = gasto.id_fondo;
                this.modalPropiedad = gasto.id_propiedad;
                this.modalFecPago = gasto.fecha_pago;
            },
            createItem: function () {
                axios.post('/api/comunidad/' + this.comunidad_id + '/gastos',
                        {//datos
                            id_proveedor: this.modalProveedor,
                            concepto: this.modalConcepto,
                            fecha_factura: this.modalFecFactura,
                            importe: this.modalImporte,
                            forma_pago: this.modalForPago,
                            tipo_gasto: this.modalTipoGasto,
                            referencia: this.modalRef,
                            id_cuenta: this.modalCuenta,
                            id_fondo: this.modalFondo,
                            id_propiedad: this.modalPropiedad,
                            fecha_pago: this.modalFecPago
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Gasto creado");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible crear gasto");
                            console.log(error.response);
                        });
            },
            updateItem: function () {
                axios.put('/api/comunidad/' + this.comunidad_id + '/gastos/' + this.modalId,
                        {//datos
                            id_proveedor: this.modalProveedor,
                            concepto: this.modalConcepto,
                            fecha_factura: this.modalFecFactura,
                            importe: this.modalImporte,
                            forma_pago: this.modalForPago,
                            tipo_gasto: this.modalTipoGasto,
                            referencia: this.modalRef,
                            id_cuenta: this.modalCuenta,
                            id_fondo: this.modalFondo,
                            id_propiedad: this.modalPropiedad,
                            fecha_pago: this.modalFecPago
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Gasto modificado");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible modificar Gasto");
                            console.log(error.response);
                        });
            },
            deleteItem: function (id) {
                if (confirm('¿Eliminar gasto?')) {
                    axios.delete('/api/comunidad/' + this.comunidad_id + '/gastos/' + id,
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                }
                            })
                            .then(response => {
                                alert("Gasto eliminado");
                                window.location.reload();
                            })
                            .catch(error => {
                                alert("No ha sido posible eliminar el gasto");
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
