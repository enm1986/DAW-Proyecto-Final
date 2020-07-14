<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-2">
                <div class="d-flex flex-row justify-content-end m-2">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalCrea" v-on:click="limpiarForm()">Nueva Cuota</button>
                </div>
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Concepto</th>
                            <th scope="col">Importe</th>
                            <th scope="col">Tipo de cuota</th>
                            <th scope="col">Fondo</th>
                            <th scope="col">Propiedad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cuota in elementosMostrados" v-bind:key="cuota.id">
                            <td><a data-toggle="modal" data-target="#modalMod" v-on:click="prepareUpdate(cuota)">{{ cuota.fecha_cuota }}</a></td>
                            <td>{{ cuota.concepto }}</td>
                            <td>{{ cuota.importe }}€</td>
                            <td>{{ cuota.tipo_cuota }}</td>
                            <td>{{ cuota.fondo }}</td>
                            <td>{{ cuota.propiedad }}</td>
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
        <!-- Modal para crear-->
        <div class="modal fade" id="modalCrea" tabindex="-1" role="dialog" aria-labelledby="nuevaCuota" aria-hidden="true">
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
                            <a class="nav-item nav-link" id="nav-coef-tab" data-toggle="tab" href="#nav-coef" role="tab" aria-controls="nav-coef" aria-selected="false" v-on:click="limpiarForm()">Importes por Coeficientes</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <!-- Nueva Cuota Mismo importe-->
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
                                            <label for="importe">Importe Total</label>
                                            <input id="importe" style="text-align:right;" v-model="modalImporte" type="number" min="0" step="0.01" required/>
                                            <span>€</span>
                                        </div>
                                        <div class="d-flex flex-row mx-2 mb-2">
                                            <label for="tgasto" class="align-self-center">Tipo de cuota</label>
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
                                                    {{ propiedad.descripcion }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-10">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Propiedad</th>
                                                    <th scope="col">Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="propiedad in propiedades" v-bind:key="propiedad.id">
                                                    <td v-if="modalPropiedades.includes(propiedad.id)">{{ propiedad.descripcion }}</td>
                                                    <td v-if="modalPropiedades.includes(propiedad.id)">{{ calcCuotaMismo(modalImporte) }}€</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Crear Cuota</button>
                                </div>
                            </form>
                        </div>
                        <!-- Nueva Cuota Importe por Coef-->
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
                                            <label for="tgasto" class="align-self-center">Tipo de cuota</label>
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
                                            <span class="font-italic">Coeficiente seleccionado: {{ coefParcial }}%</span>
                                            <select id="propiedad" v-model="modalPropiedades" class="custom-select" multiple size="8">
                                                <option v-for="propiedad in propiedades" v-bind:value="propiedad.id">
                                                    {{'('+ propiedad.coeficiente +'%) ' + propiedad.descripcion }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-10">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Propiedad</th>
                                                    <th scope="col">Coeficiente</th>
                                                    <th scope="col">Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="propiedad in propiedades" v-bind:key="propiedad.id">
                                                    <td v-if="modalPropiedades.includes(propiedad.id)">{{ propiedad.descripcion }}</td>
                                                    <td v-if="modalPropiedades.includes(propiedad.id)">{{ propiedad.coeficiente }}</td>
                                                    <td v-if="modalPropiedades.includes(propiedad.id)">{{ calcCuotaCoef(propiedad.coeficiente, modalImporte) }}€</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
        <!-- Modal para modificar-->
        <div class="modal fade" id="modalMod" tabindex="-1" role="dialog" aria-labelledby="modCuota" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="modCuota">Modificar Cuota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" v-on:submit.prevent="updateItem()">

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
                                <label for="tgasto" class="align-self-center">Tipo de cuota</label>
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
                            <div class="d-flex flex-row mx-2 mb-2">
                                <label for="propiedad" class="align-self-center">Propiedad</label>
                                <input id="propiedad" v-model="modalPropiedad" disabled/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" v-on:click="deleteItem(modalId)">Eliminar</button>
                                <button type="submit" class="btn btn-primary">Actualiza</button>
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
                pagina: 1,
                porPagina: 10,
                paginas: [],
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
                modalPropiedades: [],
                modalPropiedad: '',
                fechaActual: new Date().toISOString().slice(0, 10)
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
        computed: {
            coefParcial: function () {
                let coef_total = 0;
                this.modalPropiedades.forEach(propiedad => {
                    let prop = this.propiedades.find(p => p.id === propiedad);
                    coef_total += Number.parseFloat(prop.coeficiente);
                });
                return coef_total;
            },
            elementosMostrados: function () {
                return this.paginar(this.cuotas);
            }
        },
        watch: {
            cuotas: function () {
                this.setPaginador(this.cuotas);
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
                axios.put('/api/comunidad/' + this.comunidad_id + '/cuotas/' + this.modalId,
                        {//datos
                            concepto: this.modalConcepto,
                            fecha_cuota: this.modalFecCuota,
                            importe: this.modalImporte,
                            tipo_cuota: this.modalTipoGasto,
                            id_fondo: this.modalFondo,
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Cuota modificada");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible modificar Cuota");
                            console.log(error.response);
                        });
            },
            deleteItem: function (id) {
                if (confirm('¿Eliminar cuota?')) {
                    axios.delete('/api/comunidad/' + this.comunidad_id + '/cuotas/' + id,
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                }
                            })
                            .then(response => {
                                alert("Cuota eliminada");
                                window.location.reload();
                            })
                            .catch(error => {
                                alert("No ha sido posible eliminar la cuota");
                                console.log(error.response);
                            });
                }
            },
            limpiarForm: function () {
                this.modalId = null;
                this.modalConcepto = '';
                this.modalFecCuota = this.fechaActual;
                this.modalImporte = 0;
                this.modalTipoGasto = 'ordinario';
                this.modalFondo = '';
                this.modalPropiedades = [];
            },
            prepareUpdate: function (cuota) {
                this.modalId = cuota.id;
                this.modalConcepto = cuota.concepto;
                this.modalFecCuota = cuota.fecha_cuota;
                this.modalImporte = cuota.importe;
                this.modalTipoGasto = cuota.tipo_cuota;
                this.modalFondo = cuota.id_fondo;
                this.modalPropiedad = cuota.propiedad;
            },
            calcCuotaMismo: function (importe) {
                let partes = this.modalPropiedades.length;
                let cuota = importe / partes;
                return cuota.toFixed(2);
            },
            calcCuotaCoef: function (coeficiente, importe) {
                let cuota = importe * coeficiente / this.coefParcial;
                return cuota.toFixed(2);
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
