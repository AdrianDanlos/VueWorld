<template>
  <div class="w-50 m-auto">
    <div class="card card-body">
      <form>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input
            type="text"
            name="email"
            placeholder="Enter your e-mail"
            class="form-control"
            v-model="email"
            :class="[{'is-invalid': errorFor('email')}]"
          />
          <v-errors :errors="errorFor('email')"></v-errors>
        </div>

        <div class="form-group">
          <label for="email">Password</label>
          <input
            type="password"
            name="password"
            placeholder="Enter your password"
            class="form-control"
            v-model="password"
            :class="[{'is-invalid': errorFor('password')}]"
          />
          <v-errors :errors="errorFor('password')"></v-errors>
        </div>

        <button
          type="submit"
          class="btn btn-primary btn-lg btn-block"
          @click.prevent="login"
          :disabled="loading"
        >Log-in</button>

        <hr />

        <div>
          No account yet?
          <router-link :to="{name: 'register'}" class="font-weight-bold">Register</router-link>
        </div>

        <div>
          Forgotten password?
          <router-link :to="{name: 'home'}" class="font-weight-bold">Reset password</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import validationErros from "../shared/mixins/validationErrors";
import {logIn} from "../shared/utils/auth";


export default {
  mixins: [validationErros],
  data() {
    return {
      email: null,
      password: null,
      loading: false
    };
  },
  methods: {
    async login() {
      this.loading = true;
      this.errors = null;

      try {
        await axios.get("/sanctum/csrf-cookie"); //Request needed to initialize CSRF protection for the application (docs) in order to LOGIN
        await axios.post("/login", {
          email: this.email,
          password: this.password
        });

        logIn(); //We set isLoggedIn to true in LocalStorage
        this.$store.dispatch('loadUser');
        this.$router.push({name: "home"});

      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }

      this.loading = false;
    }
  }
};
</script>