<template>
  <div class="card w-100">
    <div class="card-body">
      <div class="card-title">{{ itemTitle }}</div>
      <div class="card-text">{{ itemDescription }}</div>
      <div class="card-text">{{ itemPrice }}</div>
    </div>
  </div>
</template>

<script>
export default {
  props: { itemTitle: String, itemDescription: String, itemPrice: Number }
};
</script>