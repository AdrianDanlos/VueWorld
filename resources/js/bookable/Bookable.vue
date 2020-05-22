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
      <availability
        :bookable-id="this.$route.params.id"
        @availability="checkPrice($event)"
        class="mb-4"
      ></availability>

      <transition name="fade">
        <price-breakdown v-if="price" :price="price" class="mb-4"></price-breakdown>
      </transition>
      <transition name="fade">
        <button class="btn btn-outline-secondary btn-block" v-if="price">Book now</button>
      </transition>
    </div>
  </div>
</template>
<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";
import { mapState } from "vuex";

export default {
  components: {
    Availability,
    ReviewList,
    PriceBreakdown
  },
  data() {
    return {
      bookable: null,
      loading: false,
      price: null
    };
  },
  created() {
    this.loading = true;
    axios.get(`/api/bookables/${this.$route.params.id}`).then(result => {
      this.bookable = result.data;
      this.loading = false;
    });
  },
  computed: mapState({
    lastSearch: "lastSearch"
  }),
  methods: {
    async checkPrice(hasAvailability) {
      try {
        if (hasAvailability) {
          this.price = (
            await axios.get(
              `/api/bookables/${this.$route.params.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`
            )
          ).data;
        } else {
          this.price = null;
        }
      } catch (err) {
        this.price = null;
      }
    }
  }
};
</script>


<style scoped>
#photo {
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