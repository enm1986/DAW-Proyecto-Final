<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-2">
                <div class="card mb-2" v-for="propiedad in propiedades" v-bind:key="propiedad.id">
                    <div class="card-header">
                        <h5>{{propiedad.tipo + ' - ' + propiedad.descripcion}}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col" class="d-none d-sm-table-cell">Tipo de cuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cuota in listaCuotas(propiedad.id)" v-bind:key="cuota.id">
                                    <td>{{cuota.fecha_cuota}}</td>
                                    <td>{{cuota.concepto}}</td>
                                    <td>{{cuota.importe}}€</td>
                                    <td class="d-none d-sm-table-cell">{{cuota.tipo_cuota}}</td>
                                </tr>
                                <tr class="bg-warning">
                                    <td></td>
                                    <td class="font-weight-bold">TOTAL</td>
                                    <td class="font-weight-bold">{{totalCuotasPropiedad(propiedad.id)}}€</td>
                                    <td class="d-none d-sm-table-cell"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h5>Balance final</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Total Gastos</th>
                                    <th scope="col">Total Ingresos</th>
                                    <th scope="col">Balance final</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{totalCuotas}}€</td>
                                    <td>{{totalIngresos}}€</td>
                                    <td class="font-weight-bold" v-bind:class="{'text-danger': isNegative(totalIngresos, totalCuotas)}">{{totalIngresos-totalCuotas}}€</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                cuotas: [],
                propiedades: [],
                ingresos: []
            };
        },
        created() {
            this.getCuotas();
            this.getIngresos();
            eventBus.$on("send-data", (propiedades) => {
                this.propiedades = propiedades;
            });
            console.log('Component created');
        },
        mounted() {
            console.log('Component mounted');
        },
        computed: {
            totalCuotas: function () {
                let importe = 0;
                this.cuotas.forEach((cuota) => {
                    importe += Number.parseFloat(cuota.importe);
                });
                return importe;
            },
            totalIngresos: function () {
                let importe = 0;
                this.ingresos.forEach((ingreso) => {
                    importe += Number.parseFloat(ingreso.importe);
                });
                return importe;
            }
        },
        watch: {},
        methods: {
            getCuotas: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/cuotasprop', {
                    headers: {
                        'Authorization': this.bearer
                    }
                }).then(response => (this.cuotas = response.data));
            },
            getIngresos: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/ingresosprop', {
                    headers: {
                        'Authorization': this.bearer
                    }
                }).then(response => (this.ingresos = response.data));
            },
            listaCuotas: function (propiedad) {
                let cuotas = this.cuotas.filter(c => c.id_propiedad === propiedad);
                return cuotas;
            },
            totalCuotasPropiedad: function (propiedad) {
                let cuotas = this.cuotas.filter(c => c.id_propiedad === propiedad);
                let importe = 0;
                cuotas.forEach((cuota) => {
                    importe += Number.parseFloat(cuota.importe);
                });
                return importe;
            },
            isNegative: function (ingresos, gastos) {
                return Number(ingresos - gastos) < 0;
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
        width: 80px;
        margin: 0;
    }
    h5{
        font-size: 1.1em;
    }

</style>
