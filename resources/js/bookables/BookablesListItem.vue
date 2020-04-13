<template>
  <div>
    <h1>{{ itemTitle }}</h1>
    <p>{{ itemContent }}</p>
    <p>{{ itemPrice }}</p>
  </div>
</template>

<script>
export default {
  props: { itemTitle: String, itemContent: String, itemPrice: Number },
  mounted() {
      console.log(this.itemTitle)
  }
};
</script>