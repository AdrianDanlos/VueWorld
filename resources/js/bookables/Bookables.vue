<template>
  <div>
    <v-errors
      class="error-container row px-3 mb-1"
      :errorLayout="'offset-md-3 col-md-9'"
      :errors="[errors]"
    ></v-errors>
    <loading v-if="loading"></loading>
    <div v-else>
      <div class="info-bar row mb-3 px-3">
        <div
          class="country-info-container col-12 col-md-6 col-lg-3 order-2 order-sm-1 order-lg-1 px-0 pr-sm-2"
        >
          <div
            class="d-flex align-items-center justify-content-center country-container h-100 py-2"
          >
            <i class="fas fa-map-marker-alt"></i>
            <span>{{bookables[0].city}},</span>
            <span>{{bookables[0].country}}</span>
            <img class="countryFlag" :src="countryFlag" alt="countryFlag" />
          </div>
        </div>
        <search-city
          class="search-city col-12 col-lg-7 position-static order-3 order-lg-2"
          :searchLayout="{inputSize: 'col-10', inputMargin: 'mt-3 mt-lg-0', buttonSize: 'col-2'}"
          @search="getBookablesByCountry($event)"
        ></search-city>
        <div
          class="shuffle-btn-container d-none d-md-block order-1 order-md-2 order-lg-3 col-12 col-md-6 col-lg-2 px-0 pl-md-2"
        >
          <button
            class="btn full-text py-2 btn-main-transparent w-100 h-100"
            @click="shuffle"
          >Shuffle appartments</button>
          <button
            class="btn short-text py-2 btn-main-transparent w-100 h-100"
            @click="shuffle"
          >Shuffle</button>
        </div>
      </div>

      <transition-group class="row d-flex flex-wrap" name="bookable" tag="div">
        <div
          class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch mb-3"
          v-for="(bookable) in bookables"
          :key="bookable.id"
        >
          <BookableListItem v-bind="bookable"></BookableListItem>
        </div>
      </transition-group>
    </div>
  </div>
</template>


<script>
//We import and declare ('export component') BookablesListItem component locally in this parent component (Bookables).
//To delcare a component globally we would do it in the app.js.
import BookableListItem from "./BookablesListItem";
import validationErrors from "../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  components: {
    BookableListItem //This allows us to use the component in either PascalCase or kebab-case
  },
  data() {
    //Fetching data from the server. Constantly rerendering components as data changes
    return {
      //lenght -> amount of bookables we have
      bookables: Array.apply(null, { length: 30 }).map(function(_, index) {
        return {
          id: index,
          number: (index % 3) + 1 //Divide by amount of bookables per column
        };
      }),
      loading: false,
      countryFlag: "https://restcountries.eu/data/chn.svg",
      errAxiosCall:
        "We had a problem retrieving our bookables. Please, try again later.",
      errCountryNotFound:
        "Sorry, we cannot find anything that matches your search term."
    };
  },
  methods: {
    shuffle: function() {
      this.bookables = _.shuffle(this.bookables);
    },
    async getBookablesByCountry(country) {
      if (country) {
        //Update URL
        if (this.$route.path !== `/bookables/${country}`) {
          this.$router.push({
            name: "bookablesByCountry",
            params: { country: country }
          });
        }

        //"this" references the component
        this.loading = true;
        this.errors = "";

        //fetching data from the server
        //axios returns a promise object -> console.log(axios.get('api/bookables'))
        try {
          this.bookables = (
            await axios.get(`/api/bookables/countries/${country}`)
          ).data;
          console.log(this.bookables);
          // this.countryFlag = (
          //   await axios.get(
          //     `https://restcountries.eu/rest/v2/name/${this.$route.params.country}?fields=flag;`
          //   )
          // ).data[0].flag;
        } catch (error) {}

        if (!this.bookables.length) {
          this.errors = this.errAxiosCall;
        }
        this.loading = false;
      } else {
        this.errors = this.errCountryNotFound;
      }
    }
  },
  created() {
    this.getBookablesByCountry(this.$route.params.country);
  }
};
</script>

<style scoped>
.flip-list-move {
  transition: transform 1s;
}
*:focus {
  outline: 0 !important;
  box-shadow: none;
}
.country-container {
  background-color: white;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.25rem;
}
.country-container span {
  margin: 2px;
}
.country-container i {
  margin-right: 10px;
}
.country-container img {
  margin-left: 10px;
}
.countryFlag {
  width: 40px;
  border-radius: 3px;
}
.error-container {
  height: 20px;
}

.search-city {
  padding: 0;
}

.bookable-move {
  transition: transform 1s;
}
.short-text {
  display: none;
}

@media (max-width: 1200px) {
  .short-text {
    display: block;
  }
  .full-text {
    display: none;
  }
}

@media (max-width: 767px) {
  .country-info-container,
  .shuffle-btn-container {
    height: 50px;
  }
}

/deep/ .info-bar #search-country-input {
  border: 1px solid rgba(0, 0, 0, 0.125);
  height: 50px;
}

/deep/ #search-country-input {
  background-color: white;
}

/deep/ .info-bar .search-container {
  flex-grow: 1;
}
/deep/ .dropdown {
  width: 100%;
  top: 50px;
  left: 0;
}
/deep/ .dropdown li {
  background-color: white;
  height: 50px;
}
/deep/ .dropdownFlag {
  width: 74px;
}

/deep/ .invalid-feedback {
  display: block;
  padding-left: 40px;
}
</style>