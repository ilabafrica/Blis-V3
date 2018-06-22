/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import store from './store'
import router from './router';
import VueRouter from 'vue-router';

window.Vue = require('vue');

Vue.config.devtools = true;
Vue.config.performance = true;
Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.component('index', require('./components/index.vue'));

const app = new Vue({
    el: '#app',
    store,
    router
});
