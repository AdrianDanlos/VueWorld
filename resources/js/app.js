require('./bootstrap');

import router from './routes.js';
import VueRouter from "vue-router";
import Index from "./Index";

window.Vue = require('vue');

// Global registration here
//We are importing components on our router so we dont have to declare them here again


Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router,
    components: {
        "index": Index,
    }
});
