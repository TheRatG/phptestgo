import 'babel-polyfill';

import Vue from 'vue';
import Vuetify from 'vuetify';
import store from './store';
import router from './router.js';
import App from './App.vue'
import axios from 'axios';
Vue.use(Vuetify);

const instance = axios.create({
    baseURL: '/api/',
    timeout: 1000,
});

new Vue({
    el: '#app',
    store,
    router,
    components: {App},
    render: h => h(App)
});