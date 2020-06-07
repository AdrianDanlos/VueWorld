<template>
  <div>
    <div class="search-blanket" v-if="modal" @click="modal=false"></div>
    <div
      class="search-container justify-content-center row mx-0"
      :class="[searchLayout.inputPadding, searchLayout.inputMargin]"
    >
      <div
        class="position-relative d-flex justify-content-start pl-0"
        :class="searchLayout.inputSize"
      >
        <input
          @keyup.enter="$emit('search', checkCountry())"
          @focus="modal = true"
          :value="country"
          @input="evt=>country=evt.target.value"
          class="search-country-input w-100 d-none d-md-block"
          type="text"
          name="none"
          autocomplete="none"
          placeholder="Find your dream place"
        />
        <input
          @keyup.enter="$emit('search', checkCountry())"
          @focus="modal = true"
          :value="country"
          @input="evt=>country=evt.target.value"
          class="search-country-input w-100 d-block d-md-none"
          type="text"
          name="none"
          autocomplete="none"
          placeholder="Find a country"
        />
        <div class="dropdown position-absolute" v-if="filteredCountries && modal">
          <ul>
            <li
              v-for="filteredCountry in filteredCountries"
              :key="filteredCountry.name"
              @mousedown="setCountry(filteredCountry.name)"
              class="d-flex align-items-center justify-content-between"
            >
              <div>
                <i class="far fa-building main-color"></i>
                <span class="ml-3">{{filteredCountry.name}}</span>
              </div>
              <div class="flag-container">
                <img class="dropdownFlag" :src="filteredCountry.flag" alt="dropdownFlag" />
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="btn-go-container px-0 pl-sm-1" :class="searchLayout.buttonSize">
        <button
          type="button"
          @click="$emit('search', checkCountry())"
          class="btn btn-main d-flex align-items-center justify-content-center w-100"
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
        { flag: "https://restcountries.eu/data/afg.svg", name: "Afghanistan" },
        { flag: "https://restcountries.eu/data/alb.svg", name: "Albania" },
        { flag: "https://restcountries.eu/data/dza.svg", name: "Algeria" }
      ],
      filteredCountries: [],
      modal: false
    };
  },
  methods: {
    filterCountries() {
      if (0 === this.country.length) {
        this.filteredCountries = this.countries.map(country => {
          return country.name;
        });
      }
      this.filteredCountries = [];
      this.countries.forEach(country => {
        if (
          this.filteredCountries.length < 3 &&
          (country.name.toLowerCase().startsWith(this.country.toLowerCase()) ||
            country.alpha3Code
              .toLowerCase()
              .startsWith(this.country.toLowerCase()))
        ) {
          this.filteredCountries.push({
            name: country.name.length < 15 ? country.name : country.alpha3Code,
            flag: country.flag
          });
        }
      });
    },
    setCountry(country) {
      this.country = country;
      this.modal = false;
    },
    checkCountry() {
      let inputCountry = this.country.toLowerCase();

      if (
        this.filteredCountries.length &&
        inputCountry === this.filteredCountries[0].name.toLowerCase()
      ) {
        if (inputCountry.length === 3) {
          //If the dropdown value is on alpha3Code (3chars) find its full name
          return this.countries.find(element => {
            if (element.alpha3Code.toLowerCase() === this.filteredCountries[0].name.toLowerCase()) {
              return element;
            }
          }).name;
        } else {
          return this.country;
        }
      }
      return null;
    }
  },
  async created() {
    try {
      this.filterCountries();
      this.countries = (await axios.get("/api/countries")).data;
      console.log("Ready");
    } catch (error) {}
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
  font-weight: bold;
  height: 100%;
}
.search-blanket {
  width: 100%;
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
  padding-left: 16px;
  color: rgb(44, 44, 44);
  height: 48px;
}

.dropdown li:hover {
  cursor: pointer;
  background-color: var(--main-color);
  color: white;
}
.dropdown li i {
  color: var(--main-color);
}
.dropdown li:hover i {
  color: white !important;
}
.flag-container {
  width: 85px;
  height: 48px;
}
.dropdownFlag {
  height: 100%;
  width: 100%;
  object-fit: cover;
  opacity: 0.7;
}

.btn-go-container {
  z-index: 1;
}

@media (max-width: 767px) {
  .dropdown {
    top: unset;
  }
  .flag-container {
    width: 80px;
    height: 39px;
  }
  .dropdown li {
    border-top: 1px solid var(--main-color);
    border-bottom: unset;
    height: 40px;
  }
}
</style>