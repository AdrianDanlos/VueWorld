<template>
  <div class="d-flex justify-content-center flex-grow-1">
    <i class="fas fa-search text-secondary"></i>
    <input class="ml-3 w-75" type="text" placeholder="Where do you want to go?" />
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
input {
  border-radius: 5px;
  border: 1px solid rgba(0, 0, 0, .3);;
}
input:focus,
input:active {
  outline:none;
}
input::placeholder{
    color: black;
    font-size: 0.9rem;
}
i{
    font-size: 22px;
}
</style>