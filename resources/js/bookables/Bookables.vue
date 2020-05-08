<template>
  <div>
    <div v-if="loading">Data is loading</div>
    <div v-else>
      <div class="row mb-4" v-for="(row, rowIndex) in rows" :key="rowIndex">
        <div class="col-4 d-flex align-items-stretch" v-for="(bookable,columnIndex) in bookablesInRow(row)" :key="columnIndex">
          <BookableListItem
            :item-title="bookable.title"
            :item-description="bookable.description"
            :item-price="1600"
          ></BookableListItem>
        </div>
      </div>
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
      columns: 3 //Amount of bookables we want for each row.
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
    }
  },
  created() {
    //"this" references the component
    this.loading = true;

    const promise = new Promise((resolve, reject) => {
      setTimeout(() => resolve("Hello"), 3000); //In real application we will receive a resolve or reject value from the server. We won't manually pass a value to resolve funtcion.
    })
      .then(result => console.log(`Success ${result}`))
      .catch(result => console.log(`Error ${result}`));

    console.log(promise);

    //fetching data from the server
    //axios returns a promise object
    const request = axios.get('api/bookables').then(result => {
      this.bookables = result.data
      this.loading = false;
    })
  }
};
</script>