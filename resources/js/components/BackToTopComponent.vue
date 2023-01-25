<template>
  <div class="container-fluid bg-light mb-3">
    <div class="container">
      <transition>
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
      </transition>
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

    // ボタン
    window.addEventListener('scroll',function() {
      let topBtn = document.querySelector('.back_to_top');
      const scrollHeight = document.body.clientHeight;
      const scrollPosition = window.pageYOffset;
      const windowHeignt = window.innerHeight;
      const footer = document.querySelector('.footer');
      const footerHeight = footer.offsetHeight;
      if(scrollHeight - scrollPosition - windowHeignt <= footerHeight) {
        topBtn.style.bottom = "39px";
      } else {
        topBtn.style.bottom = "0";
      }
    });
  },
  destroyed() {
    window.removeEventListener("scroll", this.scrollToTop);
  },
};
</script>
<style scoped>
.back_to_top {
  z-index: 999;
  position: fixed;
  right: 10px;
  display: flex;
  flex-direction: column;
  font-size: x-small;
  font-weight: 600;
  line-height: 1rem;
  align-items: center;
  bottom: 0;
  color: black;
}

.back_to_top .stop {
  position: absolute;
  bottom: 39px;
}

.back-button {
  height: 24px !important;
  color: #000 !important;
}

/* ボタンふわっと表示 */
.v-enter-active, .v-leave-active {
  transition: opacity 0.3s ease;
}
.v-enter-from, .v-leave-to {
  opacity: 0;
}
</style>