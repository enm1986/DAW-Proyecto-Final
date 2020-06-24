<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-for="comunidad in comunidades" v-bind:key="comunidad.id">
                    <div class="card-header">
                        {{ comunidad.nombre }}
                        <span v-if="comunidad.tipo_acceso == 'admin'" class="badge badge-warning">Administrador</span>
                    </div>

                    <div class="card-body">
                        <!--<a class="nav-link" v-bind:href="'/comunidad/'+ comunidad.id">Entrar</a>-->
                        <form method='POST' action="/comunidad">
                            <input type="hidden" name="_token" v-bind:value="csrfToken">
                            <input type="hidden" name='nombre' v-bind:value="comunidad.nombre">
                            <input type="hidden" name='cid' v-bind:value="comunidad.id">
                            <input type="submit" value="Entrar">
                        </form>
                        
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
                csrfToken: null,
                api_token: $cookies.get("api_token"),
                comunidades: null
            };
        },
        mounted() {
            this.csrfToken= document.querySelector('meta[name="csrf-token"]').content
            this.leerComunidades();
            console.log('Component mounted.')
        },
        methods: {
            //obtener comunidades
            leerComunidades: function () {
                let bearer = 'Bearer ' + this.api_token;
                fetch("/api/comunidades", {
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
