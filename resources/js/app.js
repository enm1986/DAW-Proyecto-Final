/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
Vue.use(require('vue-cookies'));
export const eventBus = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('listar-comunidades', require('./components/ListarComunidades.vue').default);
Vue.component('listar-propiedades', require('./components/ListarPropiedades.vue').default);
Vue.component('crear-comunidad', require('./components/CrearComunidad.vue').default);
Vue.component('comunidad-datos', require('./components/ComunidadDatos.vue').default);
Vue.component('comunidad-propiedades', require('./components/ComunidadPropiedades.vue').default);
Vue.component('comunidad-propietarios', require('./components/ComunidadPropietarios.vue').default);
Vue.component('comunidad-asignar', require('./components/ComunidadAsignar.vue').default);
Vue.component('comunidad-proveedores', require('./components/ComunidadProveedores.vue').default);
Vue.component('contabilidad-fondos', require('./components/ContFondos.vue').default);
Vue.component('contabilidad-cuentas', require('./components/ContCuentas.vue').default);
Vue.component('contabilidad-gastos', require('./components/ContGastos.vue').default);
Vue.component('contabilidad-cuotas', require('./components/ContCuotas.vue').default);
Vue.component('contabilidad-ingresos', require('./components/ContIngresos.vue').default);
Vue.component('listar-fondos', require('./components/ListarFondos.vue').default);
Vue.component('listar-cuentas', require('./components/ListarCuentas.vue').default);
Vue.component('listar-cuotas', require('./components/ListarCuotas.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

