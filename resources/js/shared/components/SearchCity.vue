<template>
  <div>
    <div class="search-blanket" v-if="modal" @click="modal=false"></div>
    <div
      class="search-container justify-content-center row mx-0"
      :class="[searchLayout.inputPadding, searchLayout.inputMargin]"
    >
      <div
        class="position-relative d-flex justify-content-start p-0 pr-2 p-sm-0"
        :class="searchLayout.inputSize"
      >
        <input
          id="search-country-input"
          v-model="country"
          @keyup.enter="$emit('search', checkCountry())"
          @focus="modal = true"
          class="w-100"
          type="text"
          autocomplete="search"
          placeholder="Find your dream place"
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
              <img
                class="dropdownFlag"
                :src="filteredCountry.flag"
                alt="dropdownFlag"
              />
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
        { flag: "https://restcountries.eu/data/fra.svg", name: "France" },
        { flag: "https://restcountries.eu/data/afg.svg", name: "Afghanistan" }
      ],
      // countries: [],
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
          this.filteredCountries.length <= 4 &&
          country.name.toLowerCase().startsWith(this.country.toLowerCase())
        ) {
          this.filteredCountries.push({name: country.name, flag: country.flag});
        }
      });
    },
    setCountry(country) {
      this.country = country;
      this.modal = false;
    },
    checkCountry() {
      if (
        this.filteredCountries.length &&
        this.country.toLowerCase() === this.filteredCountries[0].name.toLowerCase()
      ) {
        return this.country;
      }
      return null;
    }
  },
  async created() {
    try {
      this.countries = (await axios.get('https://restcountries.eu/rest/v2/all?fields=name;flag;')).data;
    } catch (error) {
      
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
  font-weight: 400;
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
  color: white;
}
.dropdownFlag {
  opacity: 0.7;
}
.btn-go-container {
  z-index: 1;
}
</style>