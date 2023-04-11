<template>
  <v-dialog :width="modalWidth" persistent>
    <!-- PC -->
    <v-card class="p-3" v-if="!moblieFlg()">
      <!-- 確認文言 -->
      <div class="gallery-mediaDelete-delete-confirm-body">
        <p class="mb-0">このデータを削除します</p>
      </div>
      <!-- 操作 -->
      <v-card-actions class="justify-center gallery-mediaDelete-action-area">
        <!-- OKボタン -->
        <v-btn
          @click="deleteImage()"
          class="green-btn_noTransform mx-2 gallery-mediaDelete-delete-btn"
          >OK</v-btn
        >
        <!-- キャンセルボタン -->
        <v-btn
          @click="closeDisplayGalleryMediaDeleteConfirmModal()"
          class="gray-btn mx-2 gallery-mediaDelete-cancel-btn"
          >キャンセル</v-btn
        >
      </v-card-actions>
    </v-card>

    <!-- SP -->
    <v-card class="p-3" v-if="moblieFlg()">
      <div class="gallery-mediaDelete-delete-confirm-body">
        <!-- びっくりマーク -->
        <div class="gallery-mediaDelete-alert-mark">
          <span>!</span>
        </div>
        <!-- 確認文言 -->
        <p class="mb-0">このデータを<br />削除します</p>
      </div>
      <!-- 操作 -->
      <v-card-actions class="justify-center gallery-mediaDelete-action-area">
        <!-- OKボタン -->
        <v-btn
          @click="deleteImage()"
          class="green-btn mx-2 gallery-mediaDelete-delete-btn"
          >OK</v-btn
        >
        <!-- キャンセルボタン -->
        <v-btn
          @click="closeDisplayGalleryMediaDeleteConfirmModal()"
          class="gray-btn mx-2 gallery-mediaDelete-cancel-btn"
          >キャンセル</v-btn
        >
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
  
  <script>
export default {
  components: {},
  props: ["closeDisplayGalleryMediaDeleteConfirmModal","id"],
  data() {
    return {};
  },
  methods: {
    // モバイル判定
    moblieFlg() {
      return window.matchMedia &&
        window.matchMedia("(max-device-width: 640px)").matches
        ? true
        : false;
    },

    // 削除処理
    deleteImage() {
      axios.delete('/api/mediaAttachment/' + this.id);
      this.closeDisplayGalleryMediaDeleteConfirmModal();
      this.$emit("close");
    },
  },
  computed: {
    // モーダル幅さ調整
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
/* 確認文言 */
.gallery-mediaDelete-delete-confirm-body {
  text-align: center;
  color: #707070;
  margin-top: 3rem;
  font-size: 16px;
  font-weight: 700;
}
/* 操作ボタン */
.gallery-mediaDelete-action-area {
  margin-top: 3rem;
}
@media (max-width: 640px) {
  .gallery-mediaDelete-action-area {
    margin-top: 3rem;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
}
.gallery-mediaDelete-delete-btn {
  width: 10vw;
  border-radius: 3px;
}
.gallery-mediaDelete-cancel-btn {
  width: 10vw;
  border-radius: 3px;
}
@media (max-width: 901px) {
  .gallery-mediaDelete-delete-btn {
    width: 50vw;
    margin-bottom: 0.7rem;
  }
  .gallery-mediaDelete-cancel-btn {
    width: 50vw;
    margin-bottom: 1rem;
  }
}

/* びっくりマーク */
@media (max-width: 640px) {
  .gallery-mediaDelete-alert-mark {
    display: inline-block;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    text-align: center;
    line-height: 70px;
    margin-bottom: 2rem;
  }
  .gallery-mediaDelete-alert-mark span {
    color: #69a5af;
    font-size: 30px;
  }
}
</style>