//When the php router returns a view to the frontend, VUE router takes control of the application and decides what to show.

import VueRouter from "vue-router";
import Example2 from "./components/Example2";
import Bookables from "./bookables/Bookables";

const routes = [{
        path: "/",
        component: Bookables,
        name: "home",
    },
    {
        path: "/second",
        component: Example2,
        name: "second",
    },
]

//We create a router object with our routes and export it to reference it in app.js
const router = new VueRouter({
    routes, // shorthand for `routes: routes`
    mode: 'history', //to get rid of hash in url
})

export default router;
