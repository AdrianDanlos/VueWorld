<template>
  <div id="review-list-container">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
      <h6 class="text-uppercase text-secondary font-weight-bolder p-0 m-0">Review List</h6>
      <div class="dropdown">
        <button
          class="btn btn-main dropdown-toggle"
          type="button"
          id="dropdownMenuButton"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >Sort by</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <span class="dropdown-item" @click="sortByRating('best')">
            <i class="fas fa-star"></i>Top Rated
          </span>
          <span class="dropdown-item" @click="sortByRating('worst')">
            <i class="far fa-star"></i>Lowest Rated
          </span>
          <span class="dropdown-item" @click="sortByDateNewest()">
            <i class="far fa-calendar-plus"></i>Newest
          </span>
          <span class="dropdown-item" @click="sortByDateOldest()">
            <i class="far fa-calendar-minus"></i>Oldest
          </span>
        </div>
      </div>
    </div>
    <loading v-if="loading"></loading>
    <div v-else>
      <div class="border-bottom" v-for="(review, index) in reviews" :key="index">
        <div class="row pt-4">
          <div class="col-6">
            <div class="d-flex align-items-center">
              <div>
                <img class="mr-3 rounded-circle" :src="review.picture.thumbnail" alt="pic" />
              </div>
              <div class="d-flex flex-column">
                <span>{{ review.name.first + ' ' + review.name.last}}</span>
                <span class="text-secondary">{{ review.created_at | fromNow() }}</span>
              </div>
            </div>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <star-rating :value="review.rating" class="fa-sm"></star-rating>
          </div>
        </div>
        <div class="row pt-4 pb-4">
          <div class="col-md-12">{{ review.content }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//import moment from 'moment';

export default {
  props: {
    bookableId: [String, Number]
  },
  data() {
    return {
      loading: false,
      reviews: null
    };
  },
  methods: {
    sortByRating(order) {
      this.reviews.sort(function(a, b) {
        return order === "best" ? b.rating - a.rating : a.rating - b.rating;
      });
    },
    sortByDateNewest() {
      this.reviews.sort(function(a, b) {
        return b.created_at < a.created_at
          ? -1
          : b.created_at > a.created_at
          ? 1
          : 0;
      });
    },
    sortByDateOldest() {
      this.reviews.sort(function(a, b) {
        return a.created_at < b.created_at
          ? -1
          : a.created_at > b.created_at
          ? 1
          : 0;
      });
    }
  },
  created() {
    this.loading = true;
    axios
      .get(`/api/bookables/${this.bookableId}/reviews`)
      .then(response => {
        console.log(response.data);
        this.reviews = response.data;
      })
      .then(() => (this.loading = false));
  }
  // filters: {
  //   fromNow(value){
  //     return moment(value).fromNow();
  //   }
  // },
};
</script>

<style scoped>
.dropdown-menu {
  padding: 0;
}
.dropdown-item {
  padding: 0.55rem 1.5rem;
  border-bottom: 1px solid rgb(219, 219, 219);
  font-weight: 300;
}
.dropdown-item:hover {
  cursor: pointer;
}
.dropdown-item i {
  margin-right: 10px;
}
</style>

