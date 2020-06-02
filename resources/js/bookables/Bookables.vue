<template>
  <div>
    <v-errors
      class="error-container row px-3 mb-1"
      :errorLayout="'offset-md-3 col-md-9'"
      :errors="[errors]"
    ></v-errors>
    <div v-if="loading">Data is loading</div>
    <div v-else>
      <div class="info-bar row mb-3 px-3">
        <div
          class="d-flex align-items-center justify-content-center country-container py-2 col-md-3"
        >
          <i class="fas fa-map-marker-alt"></i>
          <span>{{bookables[0].city}},</span>
          <span>{{bookables[0].country}}</span>
          <img class="countryFlag" :src="countryFlag" alt="countryFlag" />
        </div>
        <search-city
          class="search-city col-md-7 position-static"
          :searchLayout="{inputSize: 'col-md-11', buttonSize: 'col-md-1'}"
          @search="getBookablesByCountry($event)"
        ></search-city>
        <button class="btn btn-secondary py-2 col-md-2" @click="shuffle">Shuffle appartments</button>
      </div>

      <transition-group name="flip-list">
        <div class="row mb-4" v-for="(row, rowIndex) in rows" :key="rowIndex + 0">
          <div
            class="col-4 d-flex align-items-stretch"
            v-for="(bookable,columnIndex) in bookablesInRow(row)"
            :key="columnIndex"
          >
            <BookableListItem v-bind="bookable"></BookableListItem>
          </div>
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
      bookables: null,
      loading: false,
      columns: 3, //Amount of bookables we want for each row.
      countryFlag: "https://restcountries.eu/data/chn.svg",
      errAxiosCall:
        "We had a problem retrieving our bookables. Please, try again later.",
      errCountryNotFound:
        "Sorry, we cannot find anything that matches your search term."
    };
  },
  computed: {
    rows() {
      return this.bookables === null
        ? 0
        : Math.ceil(this.bookables.length / this.columns); //if we have bookables return amount of rows we need
    }
  },
  methods: {
    bookablesInRow(row) {
      return this.bookables.slice((row - 1) * this.columns, row * this.columns); //gets array of bookables for this row
    },
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
  padding: 0 40px;
}

/deep/ .info-bar #search-country-input {
  border: 1px solid rgba(0, 0, 0, 0.125);
  height: 50px;
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