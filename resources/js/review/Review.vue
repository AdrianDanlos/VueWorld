<template>
  <div>
    <success v-if="success">You've left a review, thank you very much!</success>
    <fatal-error v-if="error"></fatal-error>
    <loading v-if="loading"></loading>
    <div class="row" v-if="!success && !error && !loading">
      <div :class="[{'col-md-4': twoColumns}, {'d-none': oneColumn}]">
        <div class="card">
          <div class="card-body">
            <div v-if="hasBooking">
              <p>
                Stayed at
                <router-link
                  :to="{name: 'bookable', params: { id: booking.bookable.bookable_id}}"
                >{{ booking.bookable.title }}</router-link>
              </p>
              <p>
                From
                <span class="main-color">{{ booking.from }}</span> to
                <span class="main-color">{{ booking.to }}</span>
              </p>
              <p>{{booking.bookable.description}}</p>
              <img class="w-100" :src="booking.bookable.photo_url" alt="photo" />
            </div>
          </div>
        </div>
      </div>
      <div :class="[{'col-md-8': twoColumns}, {'col-md-12': oneColumn}]">
        <div class="alreadyReviewed" v-if="alreadyReviewed">
          <span>Already reviewed</span>
          <i class="fas fa-feather-alt"></i>
        </div>
        <div class="bookingNoExist" v-else-if="!hasBooking">
          <span>The booking doesn't exist</span>
          <i class="fas fa-dizzy"></i>
        </div>
        <div v-else>
          <div class="form-group mt-4 mt-md-0">
            <label class="text-muted">Select the star rating (1 is worst - 5 is best)</label>
            <star-rating class="fa-lg main-color" v-model="review.rating"></star-rating>
          </div>
          <div class="form-group">
            <label for="content" class="text-muted">Describe your expirience with</label>
            <textarea
              name="content"
              cols="30"
              rows="10"
              class="form-control"
              v-model="review.content"
              :class="[{'is-invalid': errorFor('content')}]"
            ></textarea>
            <v-errors :errors="errorFor('content')"></v-errors>
          </div>

          <button
            class="btn btn-lg btn-main btn-block"
            @click.prevent="storeReview"
            :disabled="sending"
          >Submit</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { is404, is422 } from "./../shared/utils/response"; // this is the equivalent of importing the js in an html file
import validationErrors from "./../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  data() {
    return {
      // We create a review object and then assign to rating the value of the emitted event ($event) by the child StarRating component
      review: {
        id: null,
        rating: 5,
        content: null
      },
      existingReview: null,
      loading: false,
      booking: null,
      error: false, //we store in a boolean value if there was severe errors found (except for the 404 which is handled separately)
      sending: false, //to avoid spamming send button
      success: false
    };
  },
  async created() {
    this.review.id = this.$route.params.reviewKey;
    this.loading = true;

    // 1. If review already exists (in reviews table by id)
    try {
      this.existingReview = (
        await axios.get(`/api/reviews/${this.review.id}`)
      ).data;
    } catch (err) {
      if (is404(err)) {
        // 2. Fetch a booking by a review key
        try {
          this.booking = (
            await axios.get(`/api/booking-by-review/${this.review.id}`)
          ).data;
        } catch (err) {
          this.error = !is404(err);
        }
      } else {
        this.error = true;
      }
    }

    this.loading = false;
  },
  computed: {
    alreadyReviewed() {
      return this.existingReview !== null;
    },
    hasBooking() {
      return this.booking !== null;
    },
    oneColumn() {
      return !this.loading && (this.alreadyReviewed || !this.hasBooking);
    },
    twoColumns() {
      return this.loading || !this.alreadyReviewed;
    }
  },
  watch: {
    success() {
      if (this.success) {
        setTimeout(() => {
          this.$router.push({
            name: "home"
          });
        }, 2000);
      }
    }
  },
  methods: {
    storeReview() {
      this.errors = null;
      this.sending = true;
      this.success = false;

      axios
        .post(`/api/reviews`, this.review)
        .then(response => {
          this.success = 201 === response.status;
        })
        .catch(err => {
          if (is422(err)) {
            const errors = err.response.data.errors; //Axios uses XMLHttpRequest object to make the request. XMLHttpRequest.response property contains response's body content when request is ready.
            if (errors["content"] && 1 === _.size(errors)) {
              //Using lodash library. (lodash) _.size(errors) / (regular JS) Object.keys(errors).length;
              this.errors = errors;
              return;
            }
          }
          this.error = true;
        })
        .then(() => (this.sending = false));
    }
  }
};
</script>

<style scoped>
.alreadyReviewed,
.bookingNoExist {
  height: 50vh;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 5rem;
}
.alreadyReviewed i,
.bookingNoExist i {
  font-size: 5rem;
}
.alreadyReviewed span,
.bookingNoExist span {
  font-size: 3rem;
  margin-right: 1rem;
  text-align: center;
}
@media (max-width: 575px) {
  .bookingNoExist,
  .alreadyReviewed {
    flex-direction: column;
  }
  .alreadyReviewed span,
  .bookingNoExist span {
    margin-bottom: 10px;
  }
}
</style>