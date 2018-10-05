import Vue from 'vue';
import lodash from 'lodash';


import Vuetify from 'vuetify';
import axios from 'axios';
import VueAxios from 'vue-axios';
// index.js or main.js
import 'vuetify/dist/vuetify.min.css';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


Vue.use(Vuetify);
Vue.use(VueAxios, axios);
Vue.prototype._ = lodash;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
const app = new Vue({
    el: '#app'
});
