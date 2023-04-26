<template>
  <v-dialog :width="modalWidth" persistent>
    <!-- PC -->
    <v-card class="p-3" v-if="!moblieFlg()">
      <!-- 説明文言 -->
      <div class="gallery-mediaCode-title">
        <p class="mb-0">ショートコードを作成しました</p>
      </div>
      <div class="gallery-mediaCode-subTitle">
        <p class="mb-0">下記のコードを貼り付けてギャラリーを表示します</p>
      </div>

      <!-- コード表示 -->
      <div class="gallery-mediaCode-code mx-auto" @click="copyTextToClipboard">
        <p class="mb-0">[gallery id="{{ this.$store.state.library.selectedFolder }}"]</p>
      </div>
      <p v-if="isCopy" class="mb-0 mx-auto gallery-mediaCode-copySuccess">
        コピーしました！
      </p>

      <!-- 操作 -->
      <v-card-actions class="justify-center gallery-mediaCode-action-area">
        <!-- 閉じるボタン -->
        <v-btn
          @click="
            closeDisplayGalleryMediaShortCodeMakeModal(), (this.isCopy = false)
          "
          class="green-btn_noTransform mx-2 gallery-mediaCode-close-btn"
          >閉じる
        </v-btn>
      </v-card-actions>
    </v-card>

    <!-- SP -->
    <v-card class="p-3" v-if="moblieFlg()">
      <!-- 説明文言 -->
      <div class="gallery-mediaCode-title">
        <p class="mb-0">ショートコードを<br />作成しました</p>
      </div>
      <div class="gallery-mediaCode-subTitle">
        <p class="mb-0">下記のコードを貼り付けて<br />ギャラリーを表示します</p>
      </div>

      <!-- コード表示 -->
      <div class="gallery-mediaCode-code mx-auto" @click="copyTextToClipboard">
        <p class="mb-0"> [gallery id="{{ this.$store.state.library.selectedFolder }}"]</p>
      </div>
      <p v-if="isCopy" class="mb-0 mx-auto gallery-mediaCode-copySuccess">
        コピーしました！
      </p>

      <!-- 操作 -->
      <v-card-actions class="justify-center gallery-mediaCode-action-area">
        <!-- 閉じるボタン -->
        <v-btn
          @click="
            closeDisplayGalleryMediaShortCodeMakeModal(), (this.isCopy = false)
          "
          class="green-btn_noTransform mx-2 gallery-mediaCode-close-btn"
          >閉じる
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
  
  <script>
export default {
  components: {},
  props: ["closeDisplayGalleryMediaShortCodeMakeModal"],
  data() {
    return {
      isCopy: false,
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

    // クリックとコピーする
    copyTextToClipboard() {
      navigator.clipboard
        .writeText('[gallery id="'+this.$store.state.library.selectedFolder+'"]')
        .then(() => {
          this.isCopy = true;
        })
        .catch(() => {
          console.error("Copy Error");
        });
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
/* 説明文言 */
.gallery-mediaCode-title {
  text-align: center;
  color: #707070;
  margin-top: 3rem;
  font-size: 22px;
  font-weight: 700;
}

.gallery-mediaCode-subTitle {
  text-align: center;
  color: #9b9b9b;
  margin-top: 1rem;
  font-size: 12px;
}

.gallery-mediaCode-code {
  text-align: center;
  margin-top: 3rem;
  color: #8f8f8f;
  font-size: 16px;
  background-color: #ededed;
  width: fit-content;
  padding: 5px 15px;
  border-radius: 3px;
}
@media (max-width: 640px) {
  .gallery-mediaCode-code {
    margin-top: 1rem;
    font-size: 18px;
  }
}

.gallery-mediaCode-copySuccess {
  color: #8f8f8f;
  font-size: 12px;
}

/* 操作ボタン */
.gallery-mediaCode-action-area {
  margin-top: 3rem;
}
@media (max-width: 640px) {
  .gallery-mediaCode-action-area {
    margin-top: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
}
.gallery-mediaCode-close-btn {
  width: 10vw;
  border-radius: 3px;
}
@media (max-width: 901px) {
  .gallery-mediaCode-close-btn {
    width: 50vw;
    margin-bottom: 1rem;
  }
}

/* びっくりマーク */
@media (max-width: 640px) {
  .gallery-mediaCode-alert-mark {
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
  .gallery-mediaCode-alert-mark span {
    color: #69a5af;
    font-size: 30px;
  }
}
</style>