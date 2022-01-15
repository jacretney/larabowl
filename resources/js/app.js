require('./bootstrap');

import * as Vue from 'vue/dist/vue.esm-browser';

import HomeComponent from "./pages/home/HomeComponent";

const RootComponent = {
    /* options */
}

const app = Vue.createApp(RootComponent);

app.component('page-home', HomeComponent);

const vm = app.mount('#app');
