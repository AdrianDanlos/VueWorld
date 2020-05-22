<template>
  <div class="card w-100">
    <div class="card-body">
      <div :style="{ backgroundImage: 'url(' + photo_url + ')' }" id="photo"></div>
      <!--Redirects to the component declared with that name in the vue router-->
      <routerLink :to="{ name: 'bookable', params: {id} }">
        <h5 class="card-title">{{ title }}</h5>
      </routerLink>
      <p class="card-text">{{ description }}</p>
    </div>
  </div>
</template>

<script>
export default {
  //This is the data inside the object which properties matches the column names in the DB.
  props: {
    id: Number,
    title: String,
    description: String,
    photo_url: String
  }
};
</script>

<style scoped>
#photo{
  width: 100%;
  background-size: cover;
  margin-bottom: 1rem;
}
/* Trick to give the image resonsive height*/
#photo:after {
  content: "";
  display: block;
  padding-bottom: 70%;
}

</style>