<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-2">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Banco</th>
                            <th scope="col" class="d-none d-lg-table-cell">IBAN</th>
                            <th scope="col">Saldo</th>
                            <th scope="col" class="d-none d-md-table-cell">Fondo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cuenta in cuentas" v-bind:key="cuenta.id">
                            <td>{{ cuenta.banco }}</td>
                            <td class="d-none d-lg-table-cell">{{ cuenta.iban }}</td>
                            <td v-bind:class="{'text-danger': isNegative(cuenta)}">{{ cuenta.ingresos - cuenta.gastos }}€</td>
                            <td class="d-none d-md-table-cell">{{ cuenta.nombre }}</td>
                        </tr>
                    </tbody>
                </table>
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
                cuentas: []
            };
        },
        created() {
            this.getCuentas();
            console.log('Component created');
        },
        mounted() {
            console.log('Component mounted');
        },
        computed: {},
        watch: {},
        methods: {
            getCuentas: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/cuentas', {
                    headers: {
                        'Authorization': this.bearer
                    }
                }).then(response => (this.cuentas = response.data))
            },
            isNegative: function (cuenta) {
                return Number(cuenta.ingresos - cuenta.gastos) < 0;
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
