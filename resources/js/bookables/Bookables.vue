<template>
  <div>
    <div v-if="loading">Data is loading</div>
    <div v-else>
      <button class="btn btn-secondary mb-3" @click="shuffle">Shuffle appartments</button>
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

export default {
  components: {
    BookableListItem //This allows us to use the component in either PascalCase or kebab-case
  },
  data() {
    //Fetching data from the server. Constantly rerendering components as data changes
    return {
      bookables: null,
      loading: false,
      columns: 3, //Amount of bookables we want for each row.
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
    }
  },
  created() {
    //"this" references the component
    this.loading = true;

    //fetching data from the server
    //axios returns a promise object -> console.log(axios.get('api/bookables'))
    const countries = axios.get(`/api/bookables/countries/${this.$route.params.country}`).then(result => {
      console.log(result.data);
      this.bookables = result.data;
      this.loading = false;
    });

    console.log(countries);
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
</style>