<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-for="propiedad in propiedades" v-bind:key="propiedad.id">
                    <div class="card-header"> 
                        <span>{{ propiedad.direccion }}</span>
                        <span>{{ propiedad.descripcion }}</span>
                    </div>

                    <div class="card-body">
                        <span>{{ propiedad.tipo }}</span>
                        <span>Coeficiente: {{ propiedad.coeficiente }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['com_id'],
        data: function () {
            return{
                api_token: $cookies.get("api_token"),
                propiedades: null
            };
        },
        mounted() {
            this.getPropiedades();
            console.log('Component mounted.');
        },
        methods: {
            getPropiedades: function () {
                let bearer = 'Bearer ' + this.api_token;
                axios.get('/api/comunidades/' + this.com_id, {
                    headers: {
                        'Authorization': bearer
                    }
                })
                        .then(response => (this.propiedades = response.data));
            }

        }

    }
</script>
<style scoped>
    .card-header, .card-body{
        display: flex;
        justify-content: space-between;
    }
</style>
