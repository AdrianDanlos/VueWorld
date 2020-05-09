<template>
  <div>
    <nav class="navbar bg-white border-bottom navbar-light">
      <routerLink class="navbar-brand mr-auto" :to="{ name: 'home' }">Airbnb</routerLink> <!--Redirects to the component declared with that name in the vue router-->
    </nav>
    <div class="container my-4 px-4">
      <router-view></router-view> <!--Component that renders the matched component for the given path.--> 
    </div>
  </div>
</template>