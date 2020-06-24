<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-for="propiedad in propiedades" v-bind:key="propiedad.id">
                    <div class="card-header"> {{ propiedad.direccion }}</div>

                    <div class="card-body">
                        <p>{{ propiedad.tipo }}</p>
                        <p>{{ propiedad.descripcion }}</p>
                        <p>Coeficiente: {{ propiedad.coeficiente }}%</p>
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
            this.listarPropiedades();
            console.log('Component mounted.');
        },
        methods: {
            listarPropiedades: function () {
                let bearer = 'Bearer ' + this.api_token;
                fetch("/api/comunidades/" + this.com_id, {
                    method: 'GET',
                    headers: {
                        'Authorization': bearer
                    }
                })
                        .then(response => response.json())
                        .then(json => (this.propiedades = json));
            }

        }

    }
</script>
