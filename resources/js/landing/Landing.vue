<template>
  <div>
    <video autoplay muted loop id="myVideo">
      <source src="../../../storage/videos/landing.mp4" type="video/mp4" />
    </video>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
#myVideo {
  position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
}
</style>