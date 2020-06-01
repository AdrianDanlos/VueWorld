<template>
  <div>
    <div class="search-blanket" v-if="modal" @click="modal=false"></div>
    <div class="search-container d-flex justify-content-center row mx-0">
      <div
        class="position-relative d-flex justify-content-start p-0"
        :class="searchLayout.inputSize"
      >
        <input
          id="search-country-input"
          v-model="country"
          @keyup.enter="$emit('search', country)"
          @focus="modal = true"
          class="w-100"
          type="text"
          autocomplete="no"
          placeholder="Where do you want to go?"
        />
        <div class="dropdown position-absolute" v-if="filteredCountries && modal">
          <ul>
            <li
              v-for="filteredCountry in filteredCountries"
              :key="filteredCountry"
              @click="setCountry(filteredCountry)"
              class="d-flex align-items-center"
            >{{filteredCountry}}</li>
          </ul>
        </div>
      </div>
      <div class="pl-1" :class="searchLayout.buttonSize">
        <button
          type="button"
          @click="$emit('search', country)"
          class="btn d-flex align-items-center justify-content-center"
        >GO</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    searchLayout: Object
  },
  data() {
    return {
      country: "",
      countries: [
        "Florida",
        "Alabama",
        "New Mexico",
        "California",
        "Nevada",
        "Alaska",
        "Ohio",
        "China",
        "Nepal",
        "Washington",
        "Missouri"
      ],
      filteredCountries: [],
      modal: false
    };
  },
  methods: {
    filterCountries() {
      if (0 === this.country.length) {
        this.filteredCountries = this.countries;
      }
      // this.filteredCountries = this.countries.filter(country => {
      //   return country.toLowerCase().startsWith(this.country.toLowerCase());
      // });
      this.filteredCountries = [];
      this.countries.forEach(country => {
        if (this.filteredCountries.length <= 4 && country.toLowerCase().startsWith(this.country.toLowerCase())) {
          this.filteredCountries.push(country);
        }
      });
    },
    setCountry(country) {
      this.country = country;
      this.modal = false;
    }
  },
  mounted() {
    this.filterCountries();
  },
  watch: {
    country() {
      this.filterCountries();
    }
  }
};
</script>

<style scoped>
input {
  border-radius: 5px;
  background: url("/images/searchBar/search.png") no-repeat;
  background-color: rgba(255, 255, 255, 0.8);
  background-clip: padding-box;
  background-position: left 5px top 3px;
  background-size: 40px 40px;
  padding-left: 60px;
  caret-color: #6c757d;
  color: rgb(56, 56, 56);
}
input:focus,
input:active {
  outline: none;
}
input:focus::placeholder {
  color: transparent;
}
input::placeholder {
  color: rgb(56, 56, 56);
}
i {
  font-size: 22px;
}
.btn {
  background-color: var(--main-color);
  font-weight: bold;
  color: white;
  height: 100%;
}
.search-blanket {
  width: 100vw;
  height: 100vh;
  position: absolute;
  top: 0;
  left: 0;
  background: transparent;
}
.dropdown {
  z-index: 1;
}
.dropdown ul {
  list-style: none;
  padding: 0;
}

.dropdown li {
  border-bottom: 1px solid var(--main-color);
  padding-left: 60px;
  color: rgb(56, 56, 56);
}

.dropdown li:hover {
  cursor: pointer;
  background-color: var(--main-color);
  color: white;
}
</style>