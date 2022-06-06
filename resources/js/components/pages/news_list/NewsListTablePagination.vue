<template>
  <v-pagination
    v-model="page"
    :length="length"
    :total-visible="5"
    border="1px"
  ></v-pagination>
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
  methods: {},
  watch: {
    page(value) {
      this.$store.dispatch("news/setDisplayPage", value);
    },
  },
};
</script>