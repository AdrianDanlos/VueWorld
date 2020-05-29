<template>
  <div>
    <input type="text" v-model="country">
    <router-link :to="{name: 'bookablesByCountry',  params: {country: country}}">clicka</router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      country: null,
    };
  },
};
</script>

<style scoped>
#container {
  background-image: url("/public/images/landing/0.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
  width: 1000px;
  height: 1000px;
}
</style>
