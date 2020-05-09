//When the php router returns a view to the frontend, VUE router takes control of the application and decides what to show.

import VueRouter from "vue-router";
import Bookables from "./bookables/Bookables";
import Bookable from "./bookable/Bookable";

const routes = [{
        path: "/",
        component: Bookables,
        name: "home",
    },
    {
        path: "/bookable/:id",
        component: Bookable,
        name: "bookable",
    }
]

//We create a router object with our routes and export it to reference it in app.js
const router = new VueRouter({
    routes, // shorthand for `routes: routes`
    mode: 'history', //to get rid of hash in url
})

export default router;
