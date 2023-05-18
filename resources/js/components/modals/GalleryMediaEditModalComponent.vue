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
          :alt="img_alt"
        />
      </div>
      <v-card-actions class="justify-center gallery-mediaSet-action-area">
        <a
          href="#"
          role="button"
          class="green-btn_noTransform mx-2 gallery-mediaSet-update-btn"
          @click.prevent="rotate(90)"
        >
          右回転
        </a>
        <a
          href="#"
          role="button"
          class="green-btn_noTransform mx-2 gallery-mediaSet-update-btn"
          @click.prevent="rotate(-90)"
        >
          左回転
        </a>
        <a
          href="#"
          role="button"
          class="green-btn_noTransform mx-2 gallery-mediaSet-update-btn"
          @click.prevent="save()"
        >
          保存
        </a>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
  
<script>
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";
export default {
  components: { VueCropper },
  props: ["closeDisplayGalleryMediaEditConfirmModal", "img", "type", "img_alt"],
  data() {
    return {
      cropImage: "",
      file: null,
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
      var dataurl = this.$refs.cropper.getCroppedCanvas().toDataURL(this.type);
      // Base64からバイナリへ変換
      var bin = atob(dataurl.replace(/^.*,/, ""));
      var buffer = new Uint8Array(bin.length);
      for (var i = 0; i < bin.length; i++) {
        buffer[i] = bin.charCodeAt(i);
      }
      // Blobを作成
      var blob = new Blob([buffer.buffer], {
        type: this.type,
      });
      this.file = blob;
      this.$emit("update", this.cropImg.slice(22), this.file);
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

/* 操作ボタン */
.gallery-mediaSet-action-area {
  margin-top: 3rem;
}
@media (max-width: 901px) {
  .gallery-mediaSet-action-area {
    margin-top: 2rem;
    display: flex;
    flex-direction: row;
    align-items: center;
  }
}
@media (max-width: 640px) {
  .gallery-mediaSet-action-area {
    margin-top: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
}
.gallery-mediaSet-update-btn {
  width: 5vw;
  border-radius: 3px;
}
@media (max-width: 901px) {
  .gallery-mediaSet-update-btn {
    width: 13vw;
  }
}
@media (max-width: 640px) {
  .gallery-mediaSet-update-btn {
    width: 50vw;
    margin-bottom: 0.7rem;
  }
}
</style>