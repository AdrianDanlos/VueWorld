<template>
    <div id="landing" :style="{ backgroundImage: 'url(' + image + ')' }">
      <search-city v-model="country"></search-city>
      <router-link :to="{name: 'bookablesByCountry',  params: {country: country}}">Letsgo</router-link>
    </div>
</template>

<script>
import SearchCity from "../shared/components/SearchCity";
// import JS from "./landing";
// import $ from "jquery";

export default {
  components: {
    SearchCity
  },
  data() {
    return {
      image: "/images/landing/1.jpg",
      country: null
    };
  }
};
</script>

<style scoped>
body {
  overflow: hidden;
}
#landing {
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
  width: 100%;
  height: 100vh;
}
</style>
