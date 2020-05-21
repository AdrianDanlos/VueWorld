<template>
  <div class="row">
    <div class="col-md-8 pb-4">
      <div class="card">
        <div class="card-body">
          <div v-if="!loading">
            <h2>{{ bookable.title }}</h2>
            <hr />
            <article>{{ bookable.description }}</article>
            <div :style="{ backgroundImage: 'url(' + bookable.photo_url + ')' }" id="photo"></div>
          </div>
          <div v-else>Loading...</div>
        </div>
      </div>
      <review-list :bookable-id="this.$route.params.id"></review-list>
    </div>
    <div class="col-md-4 pb-4">
      <availability :bookable-id="this.$route.params.id"></availability> 
    </div>
  </div>
</template>
<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";

export default {
  components: {
    Availability,
    ReviewList
  },
  data() {
    return {
      bookable: null,
      loading: false
    };
  },
  created() {
    this.loading = true;
    axios.get(`/api/bookables/${this.$route.params.id}`).then(result => {
      this.bookable = result.data;
      this.loading = false;
    });
    
  }
};
</script>


<style scoped>
#photo{
  width: 100%;
  background-size: cover;
  margin-top: 1rem;
}
/* Trick to give the image resonsive height*/
#photo:after {
  content: "";
  display: block;
  padding-bottom: 60%;
}

</style>