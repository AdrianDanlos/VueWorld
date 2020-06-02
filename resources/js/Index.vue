<template>
  <div>
    <nav class="navbar navbar-expand-lg bg-white border-bottom navbar-light">
      <router-link class="navbar-brand mr-auto" :to="{name: 'home'}"><img class="w-50" src="/images/landing/brand_text.png" alt="brand"></router-link> <!--Redirects to the component declared with that name in the vue router-->

      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link class="nav-link" :to="{name: 'basket'}">
            Basket
            <span v-if="itemsInBasket" class="badge badge-secondary">{{ itemsInBasket }}</span>
          </router-link>
        </li>

        <li class="nav-item" v-if="!isLoggedIn">
          <router-link :to="{name: 'register'}" class="nav-link">Register</router-link>
        </li>

        <li class="nav-item" v-if="!isLoggedIn">
          <router-link :to="{name: 'login'}" class="nav-link">Sign-in</router-link>
        </li>

        <li class="nav-item" v-if="isLoggedIn">
          <a class="nav-link" href="#" @click.prevent="logout">Logout</a>
        </li>
      </ul>
    </nav>
    <div v-if="isLanding()">
      <router-view></router-view><!-- Component that renders the matched component for the given path of the router.js.  -->
    </div>
    <div v-else id="web-container" class="container mb-4 pr-4 pl-4">
      <router-view></router-view><!-- Component that renders the matched component for the given path of the router.js.  -->
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import { isLoggedIn } from './shared/utils/auth';

export default {
  data() {
    return {
      lastSearch: this.$store.state.lastSearch
    };
  },
  computed: {
    ...mapState({ //Using the rest/spread operator for destructuring. Rest operator merges all the properties from all the mapState objects into one object. MapState always returns 1 single object.
      lastSearchComputed: "lastSearch", //We get the values from lastSearch object in vueX state (store.js) and assign them to a new object "lastSearchComputed".
      isLoggedIn: "isLoggedIn",
    }),
    ...mapGetters({
      itemsInBasket: "itemsInBasket"
    })
  },
  methods: {
    //We create this logout method to tell the backend it has to destroy the current session
    async logout() {
      try {
        axios.post("/logout"); //End point automatically created by laravel auth to destroy the current session
        this.$store.dispatch("logout"); //Destroy current user in vuex
      } catch (error) {
        this.$store.dispatch("logout");
      }
    },
    isLanding(){
      return "/" === this.$route.path;
    }
  }
};
</script> 

<style scoped>
#web-container{
  margin-top: 45px;
}
.navbar-nav{
  font-weight: 400;
}
.badge-secondary{
  background-color: #2cc65b;
}
</style>