<template>
  <div>
    <div class="invalid-feedback" :class="errorLayout" v-for="(error, index) in errors" :key="key(index)">{{ error }}</div>
  </div>
</template>

<script>
export default {
  props: {
    errors: Array,
    errorLayout: String
  },
  methods: {
    key(index) {
      return `validation_error_${index}_${Math.random()}`;
    }
  }
};
</script>

<style scoped>
.form-control.is-invalid ~ div > .invalid-feedback {
  display: block;
}
.invalid-feedback {
  color: #b22222;
}
</style> 