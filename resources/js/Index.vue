<template>
  <div>
    <nav class="navbar bg-white border-bottom navbar-light">
      <routerLink class="navbar-brand mr-auto" :to="{ name: 'home' }">Airbnb</routerLink>
      <routerLink class="btn nav-button" :to="{ name: 'second' }">Second</routerLink>
    </nav>
    <div class="container my-4 px-4">
      <router-view></router-view>
    </div>
  </div>
</template>