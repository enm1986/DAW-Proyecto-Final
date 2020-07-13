<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col mb-2">
                <div class="d-flex justify-content-end m-2">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" v-on:click="limpiarForm()">Nueva Cuota</button>
                </div>
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Concepto</th>
                            <th scope="col">Importe</th>
                            <th scope="col">Tipo de gasto</th>
                            <th scope="col">Fondo</th>
                            <th scope="col">Propiedad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cuota in cuotas" v-bind:key="cuota.id">
                            <td><a data-toggle="modal" data-target="#modal" v-on:click="prepareUpdate(cuota)">{{ cuota.fecha_cuota }}</a></td>
                            <td>{{ cuota.concepto }}</td>
                            <td>{{ cuota.importe }}€</td>
                            <td>{{ cuota.tipo_cuota }}</td>
                            <td>{{ cuota.fondo }}</td>
                            <td>{{ cuota.propiedad }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal para modificar/crear-->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="nuevaCuota" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="nuevaCuota">Nueva Cuota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-mismo-tab" data-toggle="tab" href="#nav-mismo" role="tab" aria-controls="nav-mismo" aria-selected="true" v-on:click="limpiarForm()">Mismo Importe</a>
                            <a class="nav-item nav-link" id="nav-dif-tab" data-toggle="tab" href="#nav-dif" role="tab" aria-controls="nav-dif" aria-selected="false" v-on:click="limpiarForm()">Importes Diferentes</a>
                            <a class="nav-item nav-link" id="nav-coef-tab" data-toggle="tab" href="#nav-coef" role="tab" aria-controls="nav-coef" aria-selected="false" v-on:click="limpiarForm()">Importes por Coeficientes</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-mismo" role="tabpanel" aria-labelledby="nav-mismo-tab">
                            <form autocomplete="off" v-on:submit.prevent="createItem('mismo')">
                                <div class="row justify-content-center">
                                    <div class="col-10 col-lg-5">
                                        <div class="d-flex flex-row m-2">
                                            <label for="concepto" class="align-self-center">Concepto</label>
                                            <input id="concepto" v-model="modalConcepto" type="text"/>
                                        </div>
                                        <div class="d-flex flex-row mx-2 mb-2">
                                            <label for="fecCuota" class="align-self-center">Fecha Cuota</label>
                                            <input id="fecCuota" v-model="modalFecCuota" type="date" required/>
                                        </div>
                                        <div class="d-flex flex-row mx-2 mb-2 align-items-center">
                                            <label for="importe">Importe</label>
                                            <input id="importe" style="text-align:right;" v-model="modalImporte" type="number" min="0" step="0.01" required/>
                                            <span>€</span>
                                        </div>
                                        <div class="d-flex flex-row mx-2 mb-2">
                                            <label for="tgasto" class="align-self-center">Tipo de gasto</label>
                                            <select id="tgasto" v-model="modalTipoGasto" required>
                                                <option value="ordinario">Ordinario</option>
                                                <option value="extraordinario">Extraordinario</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-row mx-2 mb-2">
                                            <label for="fondo" class="align-self-center">Fondo</label>
                                            <select id="fondo" v-model="modalFondo" required>
                                                <option disabled value="">Selecciona un fondo</option>
                                                <option v-for="fondo in fondos" v-bind:value="fondo.id"> {{fondo.nombre}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-10 col-lg-5">
                                        <div class="d-flex flex-column m-2">
                                            <label for="propiedad">Propiedades</label>
                                            <span class="font-italic">(selecciona las propiedades a las que aplicar la cuota)</span>
                                            <select id="propiedad" v-model="modalPropiedades" class="custom-select" multiple size="8">
                                                <option v-for="propiedad in propiedades" v-bind:value="propiedad.id"> {{propiedad.descripcion}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Crear Cuota</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-dif" role="tabpanel" aria-labelledby="nav-dif-tab">

                        </div>
                        <div class="tab-pane fade" id="nav-coef" role="tabpanel" aria-labelledby="nav-coef-tab">
                            <form autocomplete="off" v-on:submit.prevent="createItem('coef')">
                                <div class="row justify-content-center">
                                    <div class="col-10 col-lg-5">
                                        <div class="d-flex flex-row m-2">
                                            <label for="concepto" class="align-self-center">Concepto</label>
                                            <input id="concepto" v-model="modalConcepto" type="text"/>
                                        </div>
                                        <div class="d-flex flex-row mx-2 mb-2">
                                            <label for="fecCuota" class="align-self-center">Fecha Cuota</label>
                                            <input id="fecCuota" v-model="modalFecCuota" type="date" required/>
                                        </div>
                                        <div class="d-flex flex-row mx-2 mb-2 align-items-center">
                                            <label for="importe">Importe Total</label>
                                            <input id="importe" style="text-align:right;" v-model="modalImporte" type="number" min="0" step="0.01" required/>
                                            <span>€</span>
                                        </div>
                                        <div class="d-flex flex-row mx-2 mb-2">
                                            <label for="tgasto" class="align-self-center">Tipo de gasto</label>
                                            <select id="tgasto" v-model="modalTipoGasto" required>
                                                <option value="ordinario">Ordinario</option>
                                                <option value="extraordinario">Extraordinario</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-row mx-2 mb-2">
                                            <label for="fondo" class="align-self-center">Fondo</label>
                                            <select id="fondo" v-model="modalFondo" required>
                                                <option disabled value="">Selecciona un fondo</option>
                                                <option v-for="fondo in fondos" v-bind:value="fondo.id"> {{fondo.nombre}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-10 col-lg-5">
                                        <div class="d-flex flex-column m-2">
                                            <label for="propiedad">Propiedades</label>
                                            <span class="font-italic">(selecciona las propiedades a las que aplicar la cuota)</span>
                                            <select id="propiedad" v-model="modalPropiedades" class="custom-select" multiple size="8">
                                                <option v-for="propiedad in propiedades" v-bind:value="propiedad.id">
                                                    {{'('+ propiedad.coeficiente +'%) ' + propiedad.descripcion + ' - Importe: '+ calcCuotaCoef(propiedad.coeficiente, modalImporte)+'€'}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Crear Cuota</button>
                                </div>
                            </form>
                        </div>
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
                cuotas: [],
                fondos: [],
                propiedades: [],
                modalForm: '',
                modalId: null,
                modalConcepto: '',
                modalFecCuota: '',
                modalImporte: 0,
                modalTipoGasto: '',
                modalFondo: '',
                modalPropiedades: []

            };
        },
        created() {
            this.getFondos();
            this.getPropiedades();
            this.getCuotas();
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
            getPropiedades: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/propiedades',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => (this.propiedades = response.data));
            },
            getCuotas: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/cuotas',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => (this.cuotas = response.data));
            },
            createItem: function (modo) {
                axios.post('/api/comunidad/' + this.comunidad_id + '/cuotas',
                        {//datos
                            concepto: this.modalConcepto,
                            fecha_cuota: this.modalFecCuota,
                            importe: this.modalImporte,
                            tipo_cuota: this.modalTipoGasto,
                            id_fondo: this.modalFondo,
                            propiedades: this.modalPropiedades,
                            modo: modo
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Cuotas creadas");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible crear cuotas");
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
            },
            limpiarForm: function () {
                this.modalId = null;
                this.modalConcepto = '';
                this.modalFecCuota = null;
                this.modalImporte = 0;
                this.modalTipoGasto = 'ordinario';
                this.modalFondo = '';
                this.modalPropiedad = [];
            },
            calcCuotaCoef: function (coeficiente, importe) {
                let cuota = importe * coeficiente / 100;
                return cuota.toFixed(2);
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
