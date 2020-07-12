+<template>
    <div class="container p-0">
        <div>
            <form autocomplete="off" v-on:submit.prevent="updateComunidad">
                <div class="d-flex flex-row mb-2">
                    <label for="nombre" class="align-self-center">Nombre</label>
                    <input id="nombre" v-model="nombre" type="text" required/>
                </div>
                <div class="d-flex flex-row mb-2">
                    <label for="cif" class="align-self-center">CIF</label>
                    <input id="cif" v-model="cif" type="text" required pattern="H[0-9]{8}"/>
                </div>
                <div class="d-flex flex-row mb-2">
                    <label for="direccion" class="align-self-center">Dirección</label>
                    <input id="direccion" v-model="direccion" type="text" required/>
                </div>
                <div class="d-flex flex-wrap justify-content-between">
                    <button type="submit" class="btn btn-primary mb-2">Actualizar Datos</button>
                    <button type="button" class="btn btn-danger mb-2" v-on:click="deleteComunidad">Eliminar Comunidad</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['comunidad_json'],
        data: function () {
            return{
                bearer: 'Bearer ' + $cookies.get("api_token"),
                id: null,
                nombre: "",
                cif: "",
                direccion: "",
                mensaje: "¿Seguro que desea eliminar la comunidad? \nSe perderán todos los datos de su comunidad."
            };
        },
        mounted() {
            this.getComunidad();
            console.log('Component mounted.');
        },
        methods: {
            getComunidad: function () {
                let comunidad = JSON.parse(this.comunidad_json);
                this.id = comunidad.id;
                this.nombre = comunidad.nombre;
                this.cif = comunidad.cif;
                this.direccion = comunidad.direccion;
            },
            updateComunidad: function () {
                axios.put('/api/comunidad/' + this.id,
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
                            alert("Datos actualizados");
                            //console.log(response);
                        })
                        .catch(error => {
                            alert("Imposible actualizar los datos");
                            window.location.reload();
                            console.log(error.response);
                        });
            },
            deleteComunidad: function () {
                if (confirm(this.mensaje)) {
                    axios.delete('/api/comunidad/' + this.id,
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                }
                            })
                            .then(response => {
                                alert("Comunidad eliminada");
                                window.location = '/home';
                            })
                            .catch(error => {
                                alert("No ha sido posible eliminar la comunidad");
                                console.log(error.response);
                            });
                }
            }
        }

    }
</script>
<style scoped>
    label{
        width: 80px;
        margin: 0;
    }
</style>
