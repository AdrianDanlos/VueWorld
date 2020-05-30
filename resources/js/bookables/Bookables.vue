<template>
  <div>
    <div v-if="loading">Data is loading</div>
    <div v-else-if="errors">{{ redirectHome() }}</div>
    <div v-else>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="country-container py-2 px-4">
          <i class="fas fa-map-marker-alt"></i>
          <span>{{bookables[0].city}},</span>
          <span>{{bookables[0].country}}</span>
          <img class="countryFlag" :src="countryFlag" alt="countryFlag" />
        </div>
        <search-city></search-city>
        <button class="btn btn-secondary py-2" @click="shuffle">Shuffle appartments</button>
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
import SearchCity from "../shared/components/SearchCity";

export default {
  mixins: [validationErrors],
  components: {
    BookableListItem, //This allows us to use the component in either PascalCase or kebab-case
    SearchCity
  },
  data() {
    //Fetching data from the server. Constantly rerendering components as data changes
    return {
      bookables: null,
      loading: false,
      columns: 3, //Amount of bookables we want for each row.
      countryFlag: "https://restcountries.eu/data/chn.svg"
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
    redirectHome() {
      this.$router.push({ name: "home" });
    }
  },
  async created() {
    //"this" references the component
    this.loading = true;
    this.errors = false;

    //fetching data from the server
    //axios returns a promise object -> console.log(axios.get('api/bookables'))
    try {
      this.bookables = (
        await axios.get(
          `/api/bookables/countries/${this.$route.params.country}`
        )
      ).data;
      console.log(this.bookables);
      // this.countryFlag = (
      //   await axios.get(
      //     `https://restcountries.eu/rest/v2/name/${this.$route.params.country}?fields=flag;`
      //   )
      // ).data[0].flag;
    } catch (error) {}

    if (!this.bookables.length) {
      this.errors = true;
    }

    this.loading = false;
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
  margin: 0 1px;
}
.country-container img {
  margin-left: 10px;
}
.countryFlag {
  width: 50px;
  border-radius: 3px;
}
</style>