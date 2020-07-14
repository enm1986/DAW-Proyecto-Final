<template>
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-2">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Fondo</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="fondo in fondos" v-bind:key="fondo.id">
                            <td>{{ fondo.nombre }}</td>
                            <td>{{ fondo.descripcion }}</td>
                            <td v-bind:class="{'text-danger': isNegative(fondo)}">{{ fondo.ingresos - fondo.gastos }}€</td>                        </tr>
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
                fondos: []
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
                }).then(response => (this.fondos = response.data))
            },
            isNegative: function (item) {
                return Number(item.ingresos - item.gastos) < 0;
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
