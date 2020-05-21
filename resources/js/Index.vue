<template>
  <div>
    <nav class="navbar bg-white border-bottom navbar-light">
      <routerLink class="navbar-brand mr-auto" :to="{ name: 'home' }">Airbnb</routerLink> <!--Redirects to the component declared with that name in the vue router-->
    </nav>
    <div class="container my-4 px-4">
      <router-view></router-view> <!--Component that renders the matched component for the given path.--> 
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      lastSearch: this.$store.state.lastSearch
    };
  },
  computed: mapState({
    lastSearchComputed: "lastSearch" //We get the values from lastSearch object in vueX state (store.js) and assign them to a new object "lastSearchComputed".
  }),
  // computed: {
  //   ...mapState({ //We can also use the rest/spread operator for destructuring, as mapState returns an object from the state
  //     lastSearchComputed: "lastSearch" 
  //   }),
  // }
};
</script> 