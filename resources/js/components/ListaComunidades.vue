<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-for="comunidad in comunidades" v-bind:key="comunidad.id">
                    <div class="card-header">Comunidad: {{ comunidad.nombre }}</div>

                    <div class="card-body">
                        Acceso: {{ comunidad.tipo_acceso }}
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
                api_token: $cookies.get("api_token"),
                comunidades: null
            };
        },
        mounted() {
            this.leerComunidades();
            console.log('Component mounted.')
        },
        methods: {
            //obtener comunidades
            leerComunidades: function () {
                let bearer = 'Bearer ' + this.api_token;
                fetch("http://127.0.0.1:8000/api/comunidades", {
                    method: 'GET',
                    headers: {
                        'Authorization': bearer
                    }
                })
                        .then(response => response.json())
                        .then(json => (this.comunidades = json));
            }
        }

    }
</script>
