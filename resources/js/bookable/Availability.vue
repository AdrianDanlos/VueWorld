<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder">
      Check Availability
      <transition name="fade">
        <span v-if="noAvailability" class="text-danger">(NOT AVAILABLE)</span>
        <span v-if="hasAvailability" class="main-color">(AVAILABLE)</span>
      </transition>
    </h6>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="from">From</label>
        <input
          type="text"
          name="from"
          class="form-control form-control-sm"
          placeholder="year-month-day"
          v-model="from"
          :disabled="inBasketAlready"
          @keyup.enter="check"
          :class="[{'is-invalid': errorFor('from')}]"
        />
        <v-errors :errors="errorFor('from')"></v-errors>
      </div>

      <div class="form-group col-md-6">
        <label for="to">To</label>
        <input
          type="text"
          name="to"
          class="form-control form-control-sm"
          placeholder="year-month-day"
          v-model="to"
          :disabled="inBasketAlready"
          @keyup.enter="check"
          :class="[{'is-invalid': errorFor('to')}]"
        />
        <v-errors :errors="errorFor('to')"></v-errors>
      </div>
    </div>
    <button class="btn btn-main btn-block" @click="check" :disabled="loading">
      <span v-if="!loading">Check!</span>
      <span v-if="loading">
        <i class="fas fa-circle-notch fa-spin"></i> Checking...
      </span>
    </button>
  </div>
</template>

<script>
import { is422 } from "./../shared/utils/response";
import validationErrors from "./../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  props: {
    bookableId: [String, Number] //We accept the bookableId both as a string and as a number. Sometimes we receive the data as a string and other times as a number.
  },
  data() {
    return {
      from: this.$store.state.lastSearch.from,
      to: this.$store.state.lastSearch.to,
      loading: false,
      status: null
    };
  },
  methods: {
    async check() {
      this.loading = true;
      this.errors = null;
      this.$store.dispatch("setLastSearch", {
        from: this.from,
        to: this.to
      });
      try {
        this.status = (
          await axios.get(
            `/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`
          )
        ).status;
        this.$emit("availability", this.hasAvailability);
      } catch (err) {
        if (is422(err)) {
          this.errors = err.response.data.errors;
        }
        this.status = err.response.status;
        this.$emit("availability", this.hasAvailability);
      }
      this.loading = false;
    }
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
    hasAvailability() {
      return 200 === this.status;
    },
    noAvailability() {
      return 404 === this.status;
    },
    inBasketAlready() {
      if (null === this.bookableId) {
        return false;
      }
      return this.$store.getters.inBasketAlready(parseInt(this.bookableId));
    }
  }
};
</script>

<style scoped>
/* 'scoped' keeps the scope of the stylesheet to the component. Otherwise the scope would be global. */
label {
  font-size: 0.7rem;
  text-transform: uppercase;
  color: gray;
  font-weight: bolder;
}
.is-invalid {
  border-color: #b22222;
  background-image: none;
}
.invalid-feedback {
  color: #b22222;
}

</style>