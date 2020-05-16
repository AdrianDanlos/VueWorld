<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div v-if="alreadyReviewed">You have already reviewed this booking</div>
      <div v-else>
        <div class="form-group">
          <label class="text-muted">Select the star rating (1 is worst - 5 is best)</label>
          <star-rating v-model="review.rating" class="fa-lg"></star-rating>
        </div>
        <div class="form-group">
          <label for="content" class="text-muted">Describe your expirience with</label>
          <textarea
            name="content"
            cols="30"
            rows="10"
            class="form-control"
            v-model="review.content"
          ></textarea>
        </div>

        <button class="btn btn-lg btn-primary btn-block">Submit</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  // We create a review object and then assign to rating the value of the emitted event ($event) by the child StarRating component
  data() {
    return {
      review: {
        rating: 5,
        content: null
      },
      existingReview: null,
      loading: null
    };
  },
  created() {
    this.loading = true;
    axios
      .get(`/api/reviews/${this.$route.params.id}`)
      .then(result => (this.existingReview = result.data))
      .catch(error => {})
      .then(() => (this.loading = false));
  },
  computed: {
    alreadyReviewed() {
      return this.existingReview !== null;
    }
  }
};
</script>