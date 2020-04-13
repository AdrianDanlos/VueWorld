<template>
  <div>
    <div v-if="loading">Data is loading</div>
    <div v-else>
      <BookableListItem
        :item-title="bookable.title"
        :item-content="bookable.content"
        :item-price="1600"
        v-for="(bookable, index) in bookables"
        :key="index"
      ></BookableListItem>
    </div>
  </div>
</template>


<script>
//We import and declare ('export component') BookablesListItem component locally in this parent component (Bookables).
//To delcare a component globally we would do it in the app.js.
import BookableListItem from "./BookablesListItem";

export default {
  components: {
    BookableListItem //This allows us to use the component in either PacalCase or kebab-case
  },
  data() {
    //Fetching data from the server. Constantly rerendering components as data changes
    return {
      bookables: null,
      loading: false
    };
  },
  created() {
    //"this" references the component 
    this.loading = true;

    //fetching data from the server
    setTimeout(() => {
      this.bookables = [
        {
          title: "Beijing house",
          content: "Amazing hostel to have lots of fun"
        },
        {
          title: "Shanghai house",
          content: "Amazing hostel to have lots of fun"
        }
      ];
      this.loading = false;
    }, 2000);
  }
};
</script>