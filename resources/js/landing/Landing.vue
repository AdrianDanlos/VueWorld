<template>
  <transition
    appear
    appear-class="custom-appear-class"
    appear-to-class="custom-appear-to-class"
    (2.1.8+)
  >
    <div id="landing" class="d-flex flex-column justify-content-center align-items-center">
      <img class="brand-logo" src="/images/landing/brand.png" alt="brand" />
      <p>{{isError ? errCountryNotFound : brandData}}</p>
      <search-city
        class="w-100"
        :searchLayout="{inputSize: 'col-md-6 offset-md-3', buttonSize: 'col-md-3'}"
        @search="redirect($event)"
      ></search-city>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    return {
      brandData:
        "36,000 properties, 178 countries • Over 13 million verified guest reviews • 24/7 customer service",
      errCountryNotFound:
        "Sorry, we cannot find anything that matches your search term.",
      error: false
    };
  },
  methods: {
    redirect(country) {
      this.error = false;
      if (country) {
        this.$router.push({
          name: "bookablesByCountry",
          params: { country: country }
        });
      } else {
        this.error = true;
      }
    }
  },
  computed: {
    isError() {
      return this.error === true;
    }
  },
  created() {
    document.body.style.overflow = "hidden";
  },
  beforeDestroy() {
    document.body.style.overflow = "visible";
  }
};
</script>

<style scoped>
#landing {
  background: url("/images/landing/indonesia.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
  width: 100%;
  height: 100vh;
}
p {
  color: white;
  margin-left: -50px;
  font-weight: 400 !important;
}
.brand-logo {
  margin: 3rem 0;
}

/deep/ .search-container {
  margin-bottom: 40vh;
  width: 100%;
}
/deep/ #search-country-input {
  border: 6px solid rgba(0, 0, 0, 0.5);
  height: 60px;
  font-size: 1.2rem;
}
/deep/ #search-country-input::placeholder {
  font-size: 1.2rem;
}
/deep/ .btn {
  width: 60px;
  font-size: 1.1rem;
}
/deep/ .dropdown {
  width: calc(100% - (6px * 2)); /*100% - border width*/
  top: 55px;
  left: 6px;
}
/deep/ .dropdown li {
  background-color: rgba(255, 255, 255, 0.8);
  font-size: 1.2rem;
  height: 48px;
}
/deep/ .dropdownFlag {
  width: 70px;
}

.custom-appear-class {
  opacity: 0;
}
.custom-appear-to-class {
  transition-duration: 1s;
  opacity: 1;
}
</style>