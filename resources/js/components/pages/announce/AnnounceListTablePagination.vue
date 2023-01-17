<template>
  <v-pagination
    v-model="page"
    :length="length"
    :total-visible="6"
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
        this.$store.state.announce.totalCount / this.$store.state.announce.displayLimit
      );
    },
  },
  methods: {},
  watch: {
    page(value) {
      this.$store.dispatch("announce/setDisplayPage", value);
    },
  },
};
</script>