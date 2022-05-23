<template>
  <div v-if="validationErrors">
    <ul class="alert alert-danger py-1 my-0">
      <li style="list-style: none;" v-for="(value, key, index) in validationErrors">{{ value }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'ValidationErrors',
  data() {
    return {};
  },
  props: ['errors'],
  computed: {
    validationErrors() {
      let errors = Object.values(this.errors);
      errors = errors.flat();
      return errors;
    },
  },
};
</script>

<style scoped>

</style>
