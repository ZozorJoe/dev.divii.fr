<template>
  <div class="fv-plugins-message-container invalid-feedback">
    <ul class="input-errors" v-if="errors.length">
      <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "InputError",
  props: {
    errors: {
      type: Array,
      default: [],
    },
  },
};
</script>
