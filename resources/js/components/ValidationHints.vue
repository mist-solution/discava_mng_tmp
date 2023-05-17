<template>
  <div v-if="validationHints" class="hintMsg col-sm-10 col-md-10 col-11">
    <ul class="alert alert-danger list-unstyled">
      <li v-for="(value, index) in validationHints" :key="index">
        {{ value }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    hints: Object,
  },
  computed: {
    validationHints() {
      let hints = Object.values(this.hints);
      hints = hints.flat();
      return hints;
    },
  },
};
</script>

<style scoped>
.hintMsg > ul {
  margin-top: 0.3rem;
  margin-bottom: -0.7rem;
  --bs-alert-bg: none !important;
  --bs-alert-border: none !important;
  padding: 0.4rem;
  color: #c60100;
  font-size: 14px;
  font-weight: bolder;
}
</style>
