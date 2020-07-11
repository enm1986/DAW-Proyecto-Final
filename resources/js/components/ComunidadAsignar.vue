<template>
    <div class="container p-0">
        <div class="row justify-content-center">

            <fieldset class="asignar d-flex flex-column flex-sm-row">
                <legend class="asignar">Nueva asignación</legend>
                <select id="propiedades" class="m-1" v-model="selectPropiedades">
                    <option disabled value="">Seleccionar Propiedad</option>
                    <option v-for="propiedad in propiedades" :value="propiedad.id"> {{propiedad.descripcion}}</option>
                </select> 
                <select id="propietarios" class="m-1" v-model="selectPropietarios">
                    <option disabled value="">Seleccionar Propietario</option>
                    <option v-for="propietario in propietarios" :value="propietario.id"> {{propietario.nombre}}</option>
                </select>  
                <button type="button" class="btn btn-success m-1" v-on:click="createItem()"><i class="fas fa-plus"></i></button>
            </fieldset>

            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Propiedad</th>
                        <th scope="col">Propietario</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="propiedad in elementosMostrados" v-bind:key="propiedad.id">
                        <td>{{mostrarPropiedad(propiedad)}}</td>
                        <td>
                            <div class="p-1" v-for="propietario in mostrarPropietarios(propiedad.id)" :key="propietario.id">
                                <span>{{propietario.nombre}}</span>
                            </div>
                        </td>
                        <td> 
                            <div v-for="propietario in mostrarPropietarios(propiedad.id)" :key="propietario.id">
                                <button type="button" class="btn btn-danger btn-sm m-1" v-on:click="deleteItem(propiedad.id, propietario.id)"><i class="far fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--Paginador-->
            <nav aria-label="Paginador asignaciones">
                <ul class="pagination">
                    <li class="page-item">
                        <button type="button" class="page-link" v-if="pagina != 1" @click="pagina--">&laquo;</button>
                    </li>
                    <li class="page-item">
                        <button type="button" class="page-link" v-bind:class="{'bg-info text-light': pagina==npagina}" v-for="npagina in paginas.slice(pagina-2 > 0 ? pagina-3 : 0, pagina+2)" @click="pagina=npagina">{{npagina}}</button>
                    </li>
                    <li class="page-item">
                        <button type="button" class="page-link" v-if="pagina < paginas.length" @click="pagina++">&raquo;</button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    import {eventBus} from "../app.js";
    export default {
        props: ['comunidad_id'],
        data: function () {
            return{
                bearer: 'Bearer ' + $cookies.get("api_token"),
                propiedades: [],
                propietarios: [],
                tipos_prop: [],
                asignaciones: [],
                selectPropietarios: '',
                selectPropiedades: '',
                pagina: 1,
                porPagina: 7,
                paginas: [],
            };
        },
        created() {
            this.getTipos();
            this.getPropiedades();
            this.getPropietarios();
            this.getAsignaciones();
            console.log('Component created');
        },
        mounted() {
            console.log('Component mounted');
        },
        computed: {
            elementosMostrados: function () {
                return this.paginar(this.propiedades);
            }
        },
        watch: {
            propiedades: function () {
                this.setPaginador(this.propiedades);
            }
        },
        methods: {
            getTipos: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/propiedades/tipos', {
                    headers: {
                        'Authorization': this.bearer
                    }
                }).then(response => (this.tipos_prop = response.data));
            },
            getPropiedades: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/propiedades',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => (this.propiedades = response.data));
            },
            getPropietarios: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/propietarios',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => (this.propietarios = response.data));
            },
            getAsignaciones: function () {
                axios.get('/api/comunidad/' + this.comunidad_id + '/asignar',
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => (this.asignaciones = response.data));
            },
            createItem: function () {
                axios.post('/api/comunidad/' + this.comunidad_id + '/asignar',
                        {//datos
                            id_propiedad: this.selectPropiedades,
                            id_propietario: this.selectPropietarios
                        },
                        {//config
                            headers: {
                                'Authorization': this.bearer
                            }
                        })
                        .then(response => {
                            alert("Propiedad asignada");
                            window.location.reload();
                        })
                        .catch(error => {
                            alert("Imposible asignar");
                            console.log(error.response);
                        });
            },
            deleteItem: function (propiedad, propietario) {
                if (confirm('¿Eliminar asignación?')) {
                    axios.delete('/api/comunidad/' + this.comunidad_id + '/asignar',
                            {//config
                                headers: {
                                    'Authorization': this.bearer
                                },
                                data: {//datos
                                    id_propiedad: propiedad,
                                    id_propietario: propietario
                                }
                            })
                            .then(response => {
                                alert("Asignación eliminada");
                                window.location.reload();
                            })
                            .catch(error => {
                                alert("No ha sido posible eliminar la asignación");
                                console.log(error.response);
                            });
                }
            },
            mostrarPropiedad: function (propiedad) {
                let tipo = this.tipos_prop.find(t => t.id === propiedad.id_tipo);
                return tipo.tipo + ' - ' + propiedad.descripcion + ' (' + propiedad.coeficiente + ' %)';
            },
            mostrarPropietarios: function (id_propiedad) {
                let asigns = this.asignaciones.filter(asigns => asigns.id_propiedad === id_propiedad);
                let lista = [];
                asigns.forEach(asig => {
                    let propietario = this.propietarios.find(p => p.id === asig.id_propietario);
                    lista.push({'id': propietario.id, 'nombre': propietario.nombre})
                });
                return lista;
            },
            setPaginador: function (items) {
                let npaginas = Math.ceil(items.length / this.porPagina);
                for (let i = 1; i <= npaginas; i++) {
                    this.paginas.push(i);
                }
            },
            paginar: function (items) {
                let desde = (this.pagina * this.porPagina) - this.porPagina;
                let hasta = (this.pagina * this.porPagina);
                return items.slice(desde, hasta);
            }
        }
    }
</script>
<style scoped>
    fieldset.asignar{
        width: 100%;
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
    }
    legend.asignar {
        font-size: 1.2em;
        width:auto;
        padding:0 10px;
        border-bottom:none;
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
    option {
        font-size: 0.8em;
    }
</style>
