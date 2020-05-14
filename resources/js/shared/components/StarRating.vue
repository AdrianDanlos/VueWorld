  
<template>
  <div class="d-flex">
    <i class="fas fa-star" v-for="star in fullStars" :key="'full' + star"></i>
    <i class="fas fa-star-half-alt" v-if="halfStar"></i>
    <i class="far fa-star" v-for="star in emptyStars" :key="'empty' + star"></i>
  </div>
</template>


<script>
export default {
    props: {
        rating: Number
    },
    computed: {
        halfStar(){
            //logic: if rating is 4.1 or above display 4.5
            return this.rating - Math.floor(this.rating) > 0.1 ? 1 : 0;
        },
        fullStars(){
            return Math.floor(this.rating);
        },
        emptyStars(){ 
            return Math.floor(5 - this.rating);
        }
    }
}
</script>