<template>
  <v-dialog v-show="display" :width="modalWidth" persistent>
    <v-card class="p-3">
      <!-- モーダルクローズボタン -->
      <v-row>
        <v-col class="d-flex justify-end">
          <button
            @click="closeDisplayGalleryMediaSetModal()"
            class="gallery-mediaSet-close-btn"
            type="button"
          >
            ×
          </button>
        </v-col>
      </v-row>
      <!-- モーダル内容エリア -->
      <div class="gallery-media-display-body">
        <div class="gallery-media-display-area">
          <!-- 画像、画像名 -->
          <v-row>
            <v-col>
              <v-img src="" cover class="gallery-media-img"></v-img>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <span class="gallery-media-name">test.png</span>
            </v-col>
          </v-row>

          <!-- 画像詳細内容（修正不可） -->
          <div class="mt-4">
            <v-row class="gallery-media-infomation-area">
              <!-- 画像詳細内容（左1）　フォルダ形式-->
              <v-col cols="3">
                <span class="gallery-media-infomation-name">フォルダ形式</span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-media-infomation-content">png</span>
              </v-col>
              <!-- 画像詳細内容（右1）　アップロードした人 -->
              <v-col cols="3">
                <span class="gallery-media-infomation-name">
                  アップロードした人
                </span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-media-infomation-content">ああああ</span>
              </v-col>
            </v-row>
            <v-row class="gallery-media-infomation-area">
              <!-- 画像詳細内容（左2）　フォルダ容量/ -->
              <v-col cols="3">
                <span class="gallery-media-infomation-name">フォルダ容量</span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-media-infomation-content">200KB</span>
              </v-col>
              <!-- 画像詳細内容（右2）　アップロード日 -->
              <v-col cols="3">
                <span class="gallery-media-infomation-name">
                  アップロード日
                </span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-media-infomation-content">2023/01/01</span>
              </v-col>
            </v-row>
            <v-row class="gallery-media-infomation-area">
              <!-- 画像詳細内容（左3）　サイズ -->
              <v-col cols="3">
                <span class="gallery-media-infomation-name">サイズ</span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-media-infomation-content">
                  960px x 540px
                </span>
              </v-col>
              <!-- 画像詳細内容（右3）　更新日 -->
              <v-col cols="3">
                <span class="gallery-media-infomation-name">更新日</span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-media-infomation-content">2023/01/01</span>
              </v-col>
            </v-row>
          </div>

          <!-- 画像設定（修正可能） -->
          <div class="mt-4">
            <v-row class="gallery-media-edit-area">
              <!-- 画像設定（左1）　キャプション-->
              <v-col cols="6">
                <span class="gallery-media-edit-item">キャプション</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-media-edit-input"
                />
              </v-col>
              <!-- 画像設定（右1）　メモ -->
              <v-col cols="6">
                <span class="gallery-media-edit-item">メモ</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-media-edit-input"
                />
              </v-col>
              <!-- 画像設定　代替テキスト-->
              <v-col cols="12">
                <span class="gallery-media-edit-item">代替テキスト</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-media-edit-input"
                />
              </v-col>
              <!-- 画像設定　フォルダ-->
              <v-col cols="12">
                <span class="gallery-media-edit-item">フォルダ</span>
                <v-select
                  class="gallery-media-select"
                  :items="['未分類', 'BBB', 'CCC', 'DDD']"
                  hide-details="false"
                  text
                />
              </v-col>
              <!-- 画像設定　アップロード先-->
              <v-col cols="12">
                <span class="gallery-media-edit-item"> アップロード先 </span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  disabled
                  class="gallery-media-edit-input-disable"
                  value="xxxxx"
                />
              </v-col>
            </v-row>
          </div>
        </div>
      </div>

      <!-- 操作 -->
      <v-card-actions class="justify-center">
        <!-- 更新ボタン -->
        <v-btn @click="updateMediaAction()" class="green-btn mx-2">更新</v-btn>
        <!-- キャンセルボタン -->
        <v-btn @click="closeDisplayGalleryMediaSetModal()" class="gray-btn mx-2"
          >キャンセル</v-btn
        >
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
  
  <script>
export default {
  components: {},
  props: ["display", "closeDisplayGalleryMediaSetModal"],
  data() {
    return {};
  },
  methods: {
    updateMediaAction() {
      console.log("Update BTN");
      this.closeDisplayGalleryMediaSetModal();
    },
  },
  computed: {
    // モーダル幅さ調整
    modalWidth() {
      const device = document.body.clientWidth;
      if (device > 1450) {
        // モニター
        return "80vw";
      } else if (device > 901 && device < 1450) {
        // PC
        return "75vw";
      } else if (device > 641 && device < 900) {
        // TB
        return "80vw";
      } else if (device >= 0 && device < 640) {
        // SP
        return "100vw";
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
.gallery-media-display-body {
  overflow-y: auto !important;
  overflow-x: hidden !important;
  display: flex;
  justify-content: center;
}
/* モーダルクローズボタン */
.gallery-mediaSet-close-btn {
  color: #767676;
  font-size: 2rem;
  margin: 0.5rem 1.5rem 1rem 0rem;
}
.gallery-mediaSet-close-btn:active {
  border-color: none !important;
}

/* 画像表示エリア */
.gallery-media-display-area {
  width: 80%;
}
@media (max-width: 901px) {
  .gallery-media-display-area {
    width: 93%;
  }
}

.gallery-media-img {
  width: 100%;
  height: 400px;
  background-color: #f7f7f7;
}
@media (max-width: 901px) {
  .gallery-media-img {
    height: 300px;
  }
}

/* 画像詳細内容エリア */
.gallery-media-infomation-area {
  margin-bottom: -2rem;
}
.gallery-media-name {
  font-size: 16px;
  color: #707070;
  font-weight: 700;
}

.gallery-media-infomation-name {
  font-size: 14px;
  color: #707070;
  font-weight: 700;
}
.gallery-media-infomation-content {
  font-size: 14px;
  color: #707070;
}

/* 画像修正エリア */
.gallery-media-edit-area {
  margin-top: 3rem;
}
.gallery-media-edit-item {
  font-size: 14px;
  color: #707070;
  font-weight: 700;
  display: block;
}
.gallery-media-edit-input {
  font-size: 16px;
  color: #707070;
  border: 1px solid #c0c0c0;
  border-radius: 10px;
  width: 100%;
  line-height: 2.5rem;
  margin-top: 0.3rem;
  padding-left: 0.5rem;
}
.gallery-media-edit-input-disable {
  font-size: 16px;
  color: #707070;
  background-color: #f5f5f5;
  border: 1px solid #c0c0c0;
  border-radius: 10px;
  width: 100%;
  line-height: 2.5rem;
  margin-top: 0.3rem;
  padding-left: 0.5rem;
}
.gallery-media-select {
  background-color: #fff;
  border-radius: 10px;
  border: 1px solid #c0c0c0;
}
</style>