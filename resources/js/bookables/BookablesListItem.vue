<template>
  <div class="card w-100">
    <div class="card-body">
      <!--Redirects to the component declared with that name in the vue router-->
      <routerLink :to="{ name: 'bookable', params: {id} }">
        <h5 class="card-title">{{ title }}</h5>
      </routerLink>
      <p class="card-text">{{ id }}</p>
      <p class="card-text">{{ description }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: { id: Number, title: String, description: String }
};
</script>