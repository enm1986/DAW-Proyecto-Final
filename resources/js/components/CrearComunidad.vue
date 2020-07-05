<template>
    <div class="container">
        <div class="modal-body">
            <div class="d-flex flex-row align-content-center mb-2">
                <label for="nombre" class="align-self-center">Nombre</label>
                <input id="nombre" v-model="nombre" type="text"/>
            </div>
            <div class="d-flex flex-row mb-2">
                <label for="cif" class="align-self-center">CIF</label>
                <input id="cif" v-model="cif" type="text"/>
            </div>
            <div class="d-flex flex-row mb-2">
                <label for="direccion" class="align-self-center">Dirección</label>
                <input id="direccion" v-model="direccion" type="text"/>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" v-on:click="crearComunidad">Crear Comunidad</button>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return{
                //csrfToken: null,
                api_token: $cookies.get("api_token"),
                nombre: null,
                cif: null,
                direccion: null,
                respuesta: null
            };
        },
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        methods: {
            crearComunidad: function () {
                let bearer = 'Bearer ' + this.api_token;
                axios.post('/api/comunidad',
                        {//datos
                            nombre: this.nombre,
                            cif: this.cif,
                            direccion: this.direccion
                        },
                        {//config
                            headers: {
                                'Authorization': bearer
                            }
                        })
                        .then(function (response) {
                            window.location = "/comunidad/" + response.data.id;
                        });
            }
        }
    }
</script>
<style scoped>
    label{
        width: 140px;
        margin: 0;
    }
</style>
