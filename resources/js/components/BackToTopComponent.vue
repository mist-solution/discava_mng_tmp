<template>
  <div class="container-fluid bg-light mb-3">
    <div class="container">
      <v-btn
        class="back_to_top"
        color="#fed966"
        icon
        variant="contained"
        v-show="isVisible"
        @click="backTop"
      >
        <v-icon>mdi-triangle</v-icon>
        TOP
      </v-btn>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isVisible: false,
    };
  },
  methods: {
    backTop() {
      const that = this;
      document.documentElement.scrollTop = document.body.scrollTop = 0;
    },
    scrollToTop() {
      const that = this;
      let scrollTop =
        window.pageYOffset ||
        document.documentElement.scrollTop ||
        document.body.scrollTop;
      that.scrollTop = scrollTop;
      if (that.scrollTop > 10) {
        that.isVisible = true;
      } else {
        that.isVisible = false;
      }
    },
  },
  mounted() {
    window.addEventListener("scroll", this.scrollToTop);
  },
  destroyed() {
    window.removeEventListener("scroll", this.scrollToTop);
  },
};
</script>
<style>
.back_to_top {
  z-index: 999;
  position: fixed;
  top: 90vh;
  left: 93vw;
  display: flex;
  flex-direction: column;
  font-size: x-small;
  font-weight: 600;
  line-height: 1rem;
}
</style>