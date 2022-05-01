<template>
  <v-pagination v-model="page" :length="length"></v-pagination>
</template>
<script>
export default {
  data() {
    return {
      page: 1,
    };
  },
  computed: {
    length() {
      return Math.ceil(
        this.$store.state.news.totalCount / this.$store.state.news.displayLimit
      );
    },
  },
  metohds: {
  },
  watch: {
    page(value) {
      this.$store.dispatch("news/setDisplayPage", value);
    },
  },
};
</script>