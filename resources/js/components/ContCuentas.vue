<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-2">
                <div class="d-flex justify-content-end m-2">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" v-on:click="prepareCreate()">Nueva Cuenta</button>
                </div>
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Banco</th>
                            <th scope="col">IBAN</th>
                            <th scope="col">Saldo</th>
                            <th scope="col">Fondo</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cuenta in cuentas" v-bind:key="cuenta.id">
                            <td>{{ cuenta.banco }}</td>
                            <td>{{ cuenta.iban }}</td>
                            <td>{{ cuenta.ingresos - cuenta.gastos }}</td>
                            <td>{{ cuenta.nombre }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" v-on:click="prepareUpdate(cuenta)"><i class="far fa-edit"></i></button>
                                <button type="button" class="btn btn-info btn-sm" v-on:click="estadoCuenta(cuenta)"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Modal para modificar/crear-->
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modificarModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form autocomplete="off" v-on:submit.prevent="modalForm == 'create' ? createItem() : updateItem()">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modificarModal" v-if="modalForm == 'create'">Nueva Cuenta</h5>
                                <h5 class="modal-title" id="modificarModal" v-else>Modificar Cuenta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex flex-row mb-2">
                                    <label for="nombre" class="align-self-center">Banco</label>
                                    <input id="nombre" v-model="modalBanco" type="text" required/>
                                </div>
                                <div class="d-flex flex-row mb-2">
                                    <label for="iban" class="align-self-center">IBAN</label>
                                    <input id="iban" v-model="modalIBAN" type="text" maxlength="43" pattern="^([A-Z]{2}[ \-]?[0-9]{2})(?=(?:[ \-]?[A-Z0-9]){9,30}$)((?:[ \-]?[A-Z0-9]{3,5}){2,7})([ \-]?[A-Z0-9]{1,3})?$"/>
                                </div>
                                <div class="d-flex flex-row mb-2">
                                    <label for="fondo" class="align-self-center">Fondo</label>
                                    <select id="fondo" v-model="modalFondo" required>
                                        <option disabled value="">Selecciona un fondo</option>
                                        <option v-for="fondo in fondos" v-bind:value="fondo.id"> {{fondo.nombre}}</option>
                                    </select>
                                </div>
                                <div class="d-flex flex-row mb-2 align-items-center">
                                    <label for="saldo">Saldo inicial</label>
                                    <input id="saldo" style="text-align:right;" v-model="modalSaldo" type="number" min="0" step="0.01" required/>
                                    <span>€</span>
                                </div>
                                <div class="d-flex flex-row mb-2">
                                    <label for="fecha" class="align-self-center">Fecha saldo</label>
                                    <input id="fecha" v-model="modalFecha" type="date" required/>
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
    </div>
</template>

<script>
    export default {
        props: ['comunidad_id'],
        data: function () {
            return{
                bearer: 'Bearer ' + $cookies.get("api_token"),
                cuentas: [],
                fondos: [],
                modalForm: '',
                modalId: null,
                modalBanco: '',
                modalIBAN: '',
                modalFondo: '',
                modalSaldo: 0,
                modalFecha: null
            };
        },
        created() {
            this.getFondos()
            this.getCuentas();
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
            getCuentas: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/cuentas', {
                    headers: {
                        'Authorization': this.bearer
                    }
                }).then(response => (this.cuentas = response.data))
            },
            prepareCreate: function () {
                this.modalForm = 'create';
                this.modalId = null;
                this.modalBanco = '';
                this.modalIBAN = '';
                this.modalFondo = '';
                this.modalSaldo = 0;
                this.modalFecha = null;
            },
            prepareUpdate: function (cuenta) {
                this.modalForm = 'update';
                this.modalId = cuenta.id;
                this.modalBanco = cuenta.banco;
                this.modalIBAN = cuenta.iban;
                this.modalFondo = cuenta.id_fondo;
                this.modalSaldo = cuenta.saldo_inicial;
                this.modalFecha = cuenta.fecha_saldo_ini;
            },
            createItem: function () {
                axios.post('/api/comunidad/' + this.comunidad_id + '/cuentas',
                        {//datos
                            banco: this.modalBanco,
                            iban: this.modalIBAN,
                            id_fondo: this.modalFondo,
                            saldo_inicial: this.modalSaldo,
                            fecha_saldo_ini: this.modalFecha
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Cuenta creada");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible crear cuenta");
                            console.log(error.response);
                        });
            },
            updateItem: function () {
                axios.put('/api/comunidad/' + this.comunidad_id + '/cuentas/' + this.modalId,
                        {//datos
                            banco: this.modalBanco,
                            iban: this.modalIBAN,
                            id_fondo: this.modalFondo,
                            saldo_inicial: this.modalSaldo,
                            fecha_saldo_ini: this.modalFecha
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Cuenta modificada");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible modificar Cuenta");
                            console.log(error.response);
                        });
            },
            deleteItem: function (id) {
                if (confirm('¿Eliminar Cuenta?')) {
                    axios.delete('/api/comunidad/' + this.comunidad_id + '/cuentas/' + id,
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                }
                            })
                            .then(response => {
                                alert("Cuenta eliminda");
                                window.location.reload();
                            })
                            .catch(error => {
                                alert("No ha sido posible eliminar la cuenta");
                                console.log(error.response);
                            });
                }
            },
            isNegative: function(cuenta){
                return (cuenta.ingresos - cuenta.gastos) < 0;
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
