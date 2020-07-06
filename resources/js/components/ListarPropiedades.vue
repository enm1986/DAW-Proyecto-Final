<template>
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-sm table-striped table-bordered" v-if="propiedades.length > 0">
                <thead>
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Coeficiente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="propiedad in propiedades" v-bind:key="propiedad.id">
                        <td>{{ propiedad.tipo }}</td>
                        <td>{{ propiedad.descripcion }}</td>
                        <td>{{ propiedad.coeficiente }} %</td>
                    </tr>
                </tbody>
            </table>
            <span v-else>No tienes propiedades</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['com_id'],
        data: function () {
            return{
                bearer: 'Bearer ' + $cookies.get("api_token"),
                propiedades: null,
            };
        },
        mounted() {
            this.getPropiedades();
            console.log('Component mounted.');
        },
        methods: {
            getPropiedades: function () {
                axios.get('/api/propiedades/' + this.com_id, {
                    headers: {
                        'Authorization': this.bearer
                    }
                }).then(response => (this.propiedades = response.data));
            }
        }
    }
</script>
<style scoped>
    .card-header, .card-body{
        display: flex;
        justify-content: space-between;
    }
    table {
        font-size: 0.9em;
        text-align: center;
    }
</style>
