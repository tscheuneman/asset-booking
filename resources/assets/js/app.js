
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.moment = require('moment');
window.daterangepicker = require('daterangepicker');

window.Vue = require('vue');
window.VueBus = require('vue-bus');

import {store} from './components/store';

Vue.use(VueBus);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/ExampleComponent.vue'));
Vue.component('googlemap', require('./components/Map.vue'));
Vue.component('navigation', require('./components/Nav.vue'));
Vue.component('filters', require('./components/Filters.vue'));
Vue.component('userbookings', require('./components/Bookings.vue'));
Vue.component('cart', require('./components/Cart.vue'));
Vue.component('entry', require('./components/CartEntry.vue'));

const app = new Vue({
    el: '#app',
    store
});
