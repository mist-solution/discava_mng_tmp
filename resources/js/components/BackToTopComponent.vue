<template>
  <div class="container-fluid bg-light mb-3">
    <div class="container">
      <div
      class="back_to_top"
      v-show="isVisible"
      >
        <v-icon>mdi-triangle</v-icon>
        <v-btn
        class="d-flex back-button"
        color="#fed966"
        variant="plain"
        @click="backTop"
        >
          TOP
        </v-btn>
      </div>
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
  top: 85vh;
  right: 10px;
  display: flex;
  flex-direction: column;
  font-size: x-small;
  font-weight: 600;
  line-height: 1rem;
  align-items: center;
}

@media (max-width: 600px) {
  .back_to_top {
    top: 88vh;
  }
}

.back-button {
  height: 24px !important;
}
</style>