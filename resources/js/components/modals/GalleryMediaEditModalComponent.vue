<template>
  <v-dialog :width="modalWidth" persistent>
    <!-- PC -->
    <v-card class="p-3">
      <!-- モーダルクローズボタン -->
      <v-row>
        <v-col class="d-flex justify-end">
          <button
            @click="closeDisplayGalleryMediaEditConfirmModal()"
            class="gallery-mediaEdit-close-btn"
            type="button"
          >
            ×
          </button>
        </v-col>
      </v-row>
      <div class="img-cropper">
        <vue-cropper
          ref="cropper"
          :src="'data:image/png;base64,' + img"
        />
      </div>
      <div>
        <a
          href="#"
          role="button"
          @click.prevent="rotate(90)"
        >
          右回転
        </a>
        <a
          href="#"
          role="button"
          @click.prevent="rotate(-90)"
        >
          左回転
        </a>
        <a
          href="#"
          role="button"
          @click.prevent="save()"
        >
          保存
        </a>
      </div>
    </v-card>
  </v-dialog>
</template>
  
<script>
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';
export default {
  components: { VueCropper },
  props: ["closeDisplayGalleryMediaEditConfirmModal", "img"],
  data() {
    return {
      cropImage: "",
    };
  },    
  methods: {
    // モバイル判定
    moblieFlg() {
      return window.matchMedia &&
        window.matchMedia("(max-device-width: 640px)").matches
        ? true
        : false;
    },
    // 画像切り抜き
    save() {
      this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
      this.$emit("update", this.cropImg.slice(22));
      this.closeDisplayGalleryMediaEditConfirmModal();
    },

    // 画像回転
    rotate(deg) {
      this.$refs.cropper.rotate(deg);
    },
  },
  computed: {
    // モーダル幅調整
    modalWidth() {
      const device = document.body.clientWidth;
      if (device > 1450) {
        // モニター
        return "70vw";
      } else if (device > 901 && device < 1450) {
        // PC
        return "70vw";
      } else if (device > 641 && device < 900) {
        // TB
        return "70vw";
      } else if (device >= 0 && device < 640) {
        // SP
        return "70vw";
      }
    },
  },
  mounted() {},
};
</script>
<!-- 共通CSS -->
<style src="../pages/css/common.css"></style>
<style src="../pages/css/dropdown.css"></style>

<!-- 固有CSS -->
<style scoped>
/* モーダルクローズボタン */
.gallery-mediaEdit-close-btn {
  color: #767676;
  font-size: 2rem;
  margin: 0.5rem 1.5rem 1rem 0rem;
}
@media (max-width: 640px) {
  .gallery-mediaEdit-close-btn {
    margin: 0.5rem 0.5rem 1rem 0rem;
  }
}
.gallery-mediaEdit-close-btn:active {
  border-color: none !important;
}
</style>