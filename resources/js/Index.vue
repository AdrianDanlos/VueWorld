<template>
  <div>
    <nav class="navbar bg-white border-bottom navbar-light">
      <routerLink class="navbar-brand mr-auto" :to="{ name: 'home' }">Airbnb</routerLink> <!--Redirects to the component declared with that name in the vue router-->
      <router-link class="btn nav-button" :to="{name: 'basket'}">
        Basket
        <span v-if="itemsInBasket" class="badge badge-secondary">{{ itemsInBasket }}</span>
      </router-link>
    </nav>
    <div class="container my-4 px-4">
      <router-view></router-view> <!--Component that renders the matched component for the given path.--> 
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
  data() {
    return {
      lastSearch: this.$store.state.lastSearch
    };
  },
  computed: {
    ...mapState({ //Using the rest/spread operator for destructuring. Rest operator merges all the properties from all the mapState objects into one object. MapState always returns 1 single object.
      lastSearchComputed: "lastSearch" //We get the values from lastSearch object in vueX state (store.js) and assign them to a new object "lastSearchComputed".
    }),
    ...mapGetters({
      itemsInBasket: "itemsInBasket"
    })
  }
};
</script> 