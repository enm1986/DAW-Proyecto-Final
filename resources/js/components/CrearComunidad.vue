<template>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="nuevaComunidadLabel">Nueva Comunidad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-sol-tab" data-toggle="tab" href="#nav-sol" role="tab" aria-controls="nav-sol" aria-selected="true">Solicitar Acceso</a>
                    <a class="nav-item nav-link" id="nav-crea-tab" data-toggle="tab" href="#nav-crea" role="tab" aria-controls="nav-crea" aria-selected="false">Crear Comundidad</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-sol" role="tabpanel" aria-labelledby="nav-sol-tab">
                    <div class="modal-body">
                        <div class="d-flex flex-row align-content-center mb-2">
                            <label for="solcif" class="align-self-center">CIF</label>
                            <input id="solcif" v-model="solcif" type="text"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" v-on:click="crearAcceso">Solicitar</button>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-crea" role="tabpanel" aria-labelledby="nav-crea-tab">
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
                nombre: null,
                cif: null,
                direccion: null,
                respuesta: null,
                solcif: null
            };
        },
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        methods: {
            crearComunidad: function () {
                axios.post('/api/comunidad',
                        {//datos
                            nombre: this.nombre,
                            cif: this.cif,
                            direccion: this.direccion
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Comunidad creada");
                            window.location = "/comunidad/" + response.data.id;
                        })
                        .catch(error => {
                            alert("NO se ha podido crear la comunidad");
                            console.log(error.response);
                        });
            },
            crearAcceso: function () {
                axios.post('/api/acceso',
                        {//datos
                            cif: this.solcif
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert(response.data.message);
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("ERROR");
                            console.log(error.response);
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
