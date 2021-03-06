/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import vuetify from './vuetify'
import store from "./store/customers"
import axios from "axios";
import router from './router/customers'


axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status === 422) {
            store.commit("setErrors", error.response.data.errors);
        } else if (error.response.status === 401) {
            store.commit("killToken", null);
            router.push({ name: "Login" });
        } else {
            return Promise.reject(error);
        }
    }
);

axios.interceptors.request.use(function(config) {
    config.headers.common = {
        Authorization: `Bearer ${store.state.authToken}`,
        "Content-Type": "application/json",
        Accept: "application/json"
    };

    return config;
});


axios.get(window.location.origin + "/api/products")
    .then(response => {
        // console.log(response);
        store.dispatch('setProducts', response.data);
    }).catch(error => {
});
axios.get(window.location.origin + "/api/orders")
    .then(response => {
        // console.log(response);
        store.dispatch('setOrders', response.data);
    }).catch(error => {
});

axios.get(window.location.origin + "/api/status")
    .then(response => {
        // console.log(response);
        store.dispatch('setStatus', response.data);
    }).catch(error => {
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('customers', require('./components/customers.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    vuetify,
    router
});


import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    encrypted: false,
    disableStats: true,
    enabledTransports: ['ws'],
    //csrfToken: yourCsrfToken,

});
