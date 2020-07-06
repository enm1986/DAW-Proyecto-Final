<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-2" v-for="comunidad in comunidades" v-bind:key="comunidad.id">
                    <div class="card-header">
                        {{ comunidad.nombre }}
                        <span v-if="comunidad.tipo_acceso == 'admin'" class="badge badge-warning">Administrador</span>
                    </div>

                    <div class="card-body">
                        <a class="btn btn-secondary btn-block" v-bind:href="'/comunidad/' + comunidad.id" role="button">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return{
                //csrfToken: null,
                bearer: 'Bearer ' + $cookies.get("api_token"),
                comunidades: null
            };
        },
        mounted() {
            //this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
            this.getComunidades();
            console.log('Component mounted.')
        },
        methods: {
            //obtener comunidades            
            getComunidades: function () {
                axios.get('/api/comunidades', {
                    headers: {
                        'Authorization': this.bearer
                    }
                })
                        .then(response => (this.comunidades = response.data));
            }
        }

    }
</script>
<!--
<style scoped>
</style>
-->