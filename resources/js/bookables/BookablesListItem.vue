<template>
  <div>
    <div class="card w-100 h-100">
      <div class="card-body d-flex flex-column">
        <div :style="{ backgroundImage: 'url(' + photo_url + ')' }" id="photo"></div>
        <!--Redirects to the component declared with that name in the vue router-->
        <routerLink :to="{ name: 'bookable', params: {id} }">
          <h5 class="card-title">{{ title }}</h5>
        </routerLink>
        <p class="card-text">{{ description }}</p>
        <div
          class="rating-price-container d-flex justify-content-between align-items-end flex-grow-1 pt-3"
        >
          <div class="d-flex align-items-center">
            <star-rating :value="getAverageRating()" class="card-text main-color"></star-rating>
            <routerLink
              :to="{ name: 'bookable', params: {id}}"
              class="ml-2 review-amount"
            >{{ reviews.length }}</routerLink>
          </div>
          <span class="card-text font-weight-bold">{{ price }}€</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import StarRating from "./../shared/components/StarRating";
export default {
  components: {
    StarRating
  },
  //This is the data inside the object which properties matches the column names in the DB.
  props: {
    id: Number,
    title: String,
    description: String,
    photo_url: String,
    price: Number,
    reviews: Array
  },
  methods: {
    getAverageRating() {
      return (
        this.reviews.reduce((AccRating, item) => AccRating + item.rating, 0) /
        this.reviews.length
      );
    }
  }
};
</script>

<style scoped>
#photo {
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

.card-body {
  position: relative;
}

.review-amount {
  color: #3490dc;
  margin-top: 2px;
}

</style>