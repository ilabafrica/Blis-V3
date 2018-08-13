/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap')

import Vue from 'vue'
import store from './store'
import router from './router'
import Vuetify from 'vuetify'
import {ability} from './store'
import VueRouter from 'vue-router'
import { abilitiesPlugin } from '@casl/vue'
export const EventBus = new Vue()


window.Vue = require('vue');
Vue.config.devtools = true;
Vue.config.performance = true;
Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(abilitiesPlugin, ability)
Vue.component('index', require('./components/index.vue'))

const app = new Vue({
    el: '#app',
    store,
    router
});




