  <template>
  <div class="d-flex">
    <!-- We emit an even to its parent component and we pass it star which is a number representing the star clicked -->
    <i
      class="fas fa-star"
      v-for="star in fullStars"
      :key="'full' + star"
      @click="$emit('input', star)"
    ></i>
    <i class="fas fa-star-half-alt" v-if="halfStar"></i>
    <i
      class="far fa-star"
      v-for="star in emptyStars"
      :key="'empty' + star"
      @click="$emit('input', fullStars + star)"
    ></i>
  </div>
</template>


<script>
export default {
  props: {
    value: Number
  },
  computed: {
    halfStar() {
      //logic: if rating(value) is 4.1 or above display 4.5
      return this.value - Math.floor(this.value) > 0.25 ? 1 : 0;
    },
    fullStars() {
      return Math.floor(this.value);
    },
    emptyStars() {
      //if we have added a halfstar add floor.emptyStarts. If we havent, add ceil.emptyStars
      return Math.floor(
        5 - (this.halfStar === 0 ? Math.floor(this.value) : Math.ceil(this.value))
      );
    }
  }
};
</script>