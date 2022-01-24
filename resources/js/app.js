require('./bootstrap');

const Vue = require('vue');
import {Router} from './router';

/**
 * Create app
 */

const app = Vue.createApp({});

/**
 * Mount app
 */

app.use(Router);

const vm = app.mount('#app');
