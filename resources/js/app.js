require('./bootstrap');

import router from './routes.js';
import VueRouter from "vue-router";
import Index from "./Index";
import moment from 'moment'; //We don't need to specify the path because it's already installed in our node modules folder
import StarRating from './shared/components/StarRating';
import FatalError from './shared/components/FatalError';

window.Vue = require('vue');

// Global registration of components here
//We are importing components on our router so we dont have to declare them here again


Vue.use(VueRouter); //To enable vue router
Vue.filter("fromNow", value => moment(value).fromNow()); //We are declaring this filter globally so it can be used in every single component
Vue.component('star-rating', StarRating);
Vue.component('fatal-error', FatalError);


//Main component of the website that acts as a container
const app = new Vue({
    el: '#app',
    router,
    components: {
        "index": Index,
    }
});
