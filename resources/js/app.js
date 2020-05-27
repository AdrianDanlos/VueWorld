require("./bootstrap");

import moment from "moment"; //We don't need to specify the path because it's already installed in our node modules folder
import VueRouter from "vue-router";
import Vuex from 'vuex';
import Index from "./Index";
import router from "./routes";
import FatalError from "./shared/components/FatalError";
import StarRating from "./shared/components/StarRating";
import Success from "./shared/components/Success";
import ValidationErrors from "./shared/components/ValidationErrors";
import storeDefinition from "./store";

// Global registration of components here
//We are importing components on our router so we dont have to declare them here again

window.Vue = require("vue");
Vue.use(VueRouter); //To enable vue router
Vue.use(Vuex);

Vue.filter("fromNow", value => moment(value).fromNow()); //We are declaring this filter globally so it can be used in every single component

Vue.component("star-rating", StarRating);
Vue.component("fatal-error", FatalError);
Vue.component("success", Success);
Vue.component("v-errors", ValidationErrors);

const store = new Vuex.Store(storeDefinition);


//Whenever axios makes a request and gets back a 401 (bakend expected you to be authenticated but you are not) we update the global state (vuex) and local storage with no user logged.
window.axios.interceptors.response.use(
    response => response,
    error => {
        if (401 === error.response.status) {
            store.dispatch('logout')
        }
        return Promise.reject(error);
    }
);

//Main component of the website that acts as a container
const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        index: Index
    },
    async beforeCreate() {
        this.$store.dispatch("loadStoredState"); //Just before creating the main component of our app we call the loadStoredState action of vueX to get whatever is saved in the localstorage (store.js)
        this.$store.dispatch("loadUser");
    },
});
