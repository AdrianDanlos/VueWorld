<template>
  <div>
    <div class="card">
      <div class="card-body">
        <div class="card-title">{{ itemTitle }}</div>
        <div class="card-text">{{ itemContent }}</div>
        <div class="card-text">{{ itemPrice }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: { itemTitle: String, itemContent: String, itemPrice: Number }
};
</script>