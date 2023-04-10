<template>
  <v-dialog :width="modalWidth" persistent>
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
      <div class="gallery-mediaSet-display-body">
        <div class="gallery-mediaSet-display-area">
          <!-- 画像、画像名 -->
          <v-row
            @mouseenter.prevent="(showEditBtn = true), (showDeleteBtn = true)"
            @mouseleave.prevent="(showEditBtn = false), (showDeleteBtn = false)"
          >
            <v-col>
              <v-img src="" cover class="gallery-mediaSet-img"></v-img>
              <!-- 編集ボタン -->
              <span
                v-if="showEditBtn"
                class="mdi mdi-pencil gallery-mediaSet-edit-img-btn"
                @click="editImage"
              >
              </span>
              <!-- 削除ボタン -->
              <span
                v-if="showDeleteBtn"
                class="mdi mdi-trash-can gallery-mediaSet-delete-img-btn"
                @click="deleteImage"
              >
              </span>

              <!-- 編集・削除ボタン　SP版　BEGIN -->
              <!-- 編集ボタンSP -->
              <span
                v-if="moblieFlg()"
                class="mdi mdi-pencil gallery-mediaSet-edit-img-btn"
                @click="editImage"
              >
              </span>
              <!-- 削除ボタンSP -->
              <span
                v-if="moblieFlg()"
                class="mdi mdi-trash-can gallery-mediaSet-delete-img-btn"
                @click="deleteImage"
              >
              </span>
              <!-- 編集・削除ボタン　SP版　END -->
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <span class="gallery-mediaSet-name">test.png</span>
            </v-col>
          </v-row>

          <!-- 画像詳細内容（修正不可）PC BEGIN -->
          <div class="mt-4" v-if="!moblieFlg()">
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容（左1）　ファイル形式-->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name"
                  >ファイル形式</span
                >
              </v-col>
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-content">png</span>
              </v-col>
              <!-- 画像詳細内容（右1）　アップロードした人 -->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name">
                  アップロードした人
                </span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-content"
                  >ああああ</span
                >
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容（左2）　ファイル容量/ -->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name"
                  >ファイル容量</span
                >
              </v-col>
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-content">200KB</span>
              </v-col>
              <!-- 画像詳細内容（右2）　アップロード日 -->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name">
                  アップロード日
                </span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-content"
                  >2023/01/01</span
                >
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容（左3）　サイズ -->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name">サイズ</span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-content">
                  960px x 540px
                </span>
              </v-col>
              <!-- 画像詳細内容（右3）　更新日 -->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name">更新日</span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-content"
                  >2023/01/01</span
                >
              </v-col>
            </v-row>
          </div>
          <!-- 画像詳細内容（修正不可）PC END -->

          <!-- 画像詳細内容（修正不可）SP BEGIN -->
          <div class="mt-4" v-if="moblieFlg()">
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容　ファイル形式-->
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-name"
                  >ファイル形式</span
                >
              </v-col>
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-content">png</span>
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容　ファイル容量-->
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-name"
                  >ファイル容量</span
                >
              </v-col>
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-content">200KB</span>
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容　サイズ-->
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-name">サイズ</span>
              </v-col>
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-content">
                  960px x 540px
                </span>
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容　アップロードした人-->
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-name">
                  アップロードした人
                </span>
              </v-col>
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-content"
                  >ああああ</span
                >
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容　アップロード日-->
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-name"
                  >アップロード日</span
                >
              </v-col>
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-content"
                  >2023/01/01</span
                >
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容　更新日-->
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-name">更新日</span>
              </v-col>
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-content"
                  >2023/01/10</span
                >
              </v-col>
            </v-row>
          </div>
          <!-- 画像詳細内容（修正不可）SP END -->

          <!-- 画像設定（修正可能） PC BEGIN-->
          <div class="mt-4" v-if="!moblieFlg()">
            <v-row class="gallery-mediaSet-edit-area">
              <!-- 画像設定（左1）　キャプション-->
              <v-col cols="6">
                <span class="gallery-mediaSet-edit-item">キャプション</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input"
                />
              </v-col>
              <!-- 画像設定（右1）　メモ -->
              <v-col cols="6">
                <span class="gallery-mediaSet-edit-item">メモ</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input"
                />
              </v-col>
              <!-- 画像設定　代替テキスト-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">代替テキスト</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input"
                />
              </v-col>
              <!-- 画像設定　フォルダ-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">フォルダ</span>
                <v-select
                  class="gallery-mediaSet-select"
                  :items="['未分類', 'BBB', 'CCC', 'DDD']"
                  hide-details="false"
                  text
                />
              </v-col>
              <!-- 画像設定　アップロード先-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item"> アップロード先 </span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  disabled
                  class="gallery-mediaSet-edit-input-disable"
                  value="xxxxx"
                />
              </v-col>
            </v-row>
          </div>
          <!-- 画像設定（修正可能） PC END-->

          <!-- 画像設定（修正可能） SP BEGIN-->
          <div class="mt-4" v-if="moblieFlg()">
            <v-row class="gallery-mediaSet-edit-area">
              <!-- 画像設定　キャプション-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">キャプション</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input"
                />
              </v-col>
              <!-- 画像設定　メモ -->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">メモ</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input"
                />
              </v-col>
              <!-- 画像設定　代替テキスト-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">代替テキスト</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input"
                />
              </v-col>
              <!-- 画像設定　フォルダ-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">フォルダ</span>
                <v-select
                  class="gallery-mediaSet-select"
                  :items="['未分類', 'BBB', 'CCC', 'DDD']"
                  hide-details="false"
                  text
                />
              </v-col>
              <!-- 画像設定　アップロード先-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item"> アップロード先 </span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  disabled
                  class="gallery-mediaSet-edit-input-disable"
                  value="xxxxx"
                />
              </v-col>
            </v-row>
          </div>
          <!-- 画像設定（修正可能） SP END-->
        </div>
      </div>

      <!-- 操作 -->
      <v-card-actions class="justify-center gallery-mediaSet-action-area">
        <!-- 更新ボタン -->
        <v-btn
          @click="updateMediaAction()"
          class="green-btn_noTransform mx-2 gallery-mediaSet-update-btn"
          >更新</v-btn
        >
        <!-- キャンセルボタン -->
        <v-btn
          @click="closeDisplayGalleryMediaSetModal()"
          class="gray-btn mx-2 gallery-mediaSet-cancel-btn"
          >キャンセル</v-btn
        >
      </v-card-actions>
    </v-card>
    <!-- 画像削除モーダル -->
    <gallery-media-delete-confirm-modal-component
      :modelValue="displayGalleryMediaDeleteConfirm"
      :closeDisplayGalleryMediaDeleteConfirmModal="
        closeDisplayGalleryMediaDeleteConfirm
      "
    />
  </v-dialog>
</template>
  
<script>
import GalleryMediaDeleteConfirmModalComponent from "../modals/GalleryMediaDeleteConfirmModalComponent.vue";

export default {
  components: { GalleryMediaDeleteConfirmModalComponent },
  props: ["closeDisplayGalleryMediaSetModal"],
  data() {
    return {
      showDeleteBtn: false,
      showEditBtn: false,
      displayGalleryMediaDeleteConfirm: false,
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

    //画面削除モーダルを閉じる
    closeDisplayGalleryMediaDeleteConfirm() {
      this.displayGalleryMediaDeleteConfirm = false;
    },

    // 更新処理
    updateMediaAction() {
      this.closeDisplayGalleryMediaSetModal();
    },

    // 画像削除処理
    deleteImage() {
      // 画像削除モーダル開く
      this.displayGalleryMediaDeleteConfirm = true;
      console.log("press deleteImage btn");
    },

    // 画像編集処理
    editImage() {
      // 画像編集処理
      console.log("press editImage btn");
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
.gallery-mediaSet-display-body {
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
@media (max-width: 640px) {
  .gallery-mediaSet-close-btn {
    margin: 0.5rem 0.5rem 1rem 0rem;
  }
}
.gallery-mediaSet-close-btn:active {
  border-color: none !important;
}

/* 画像表示エリア */
.gallery-mediaSet-display-area {
  position: relative;
  width: 80%;
}
@media (max-width: 901px) {
  .gallery-mediaSet-display-area {
    width: 93%;
  }
}

.gallery-mediaSet-img {
  width: 100%;
  height: 400px;
  background-color: #f7f7f7;
}
@media (max-width: 901px) {
  .gallery-mediaSet-img {
    height: 300px;
  }
}
@media (max-width: 640px) {
  .gallery-mediaSet-img {
    height: 200px;
  }
}
.gallery-mediaSet-edit-img-btn {
  background-color: #626262b8;
  color: #dfdfdf;
  border-radius: 5px;
  margin: 5px;
  padding: 2px 3px;
  font-size: 18px;
  cursor: pointer;
  position: absolute;
  top: 5px;
  right: 5px;
  width: 25px;
  top: 5px;
  right: 40px;
  height: 25px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.gallery-mediaSet-delete-img-btn {
  background-color: #626262b8;
  color: #dfdfdf;
  border-radius: 5px;
  margin: 5px;
  padding: 2px 3px;
  font-size: 18px;
  cursor: pointer;
  position: absolute;
  width: 25px;
  top: 5px;
  right: 5px;
  height: 25px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* 画像詳細内容エリア */
.gallery-mediaSet-infomation-area {
  margin-bottom: -2rem;
}
.gallery-mediaSet-name {
  font-size: 16px;
  color: #707070;
  font-weight: 700;
}

.gallery-mediaSet-infomation-name {
  font-size: 14px;
  color: #707070;
  font-weight: 700;
}
.gallery-mediaSet-infomation-content {
  font-size: 14px;
  color: #707070;
}
@media (max-width: 640px) {
  .gallery-mediaSet-infomation-area {
    margin-bottom: -2rem;
  }
  .gallery-mediaSet-name {
    font-size: 16px;
    color: #707070;
    font-weight: 700;
  }

  .gallery-mediaSet-infomation-name {
    font-size: 14px;
    color: #707070;
    font-weight: 700;
  }
  .gallery-mediaSet-infomation-content {
    font-size: 14px;
    color: #707070;
  }
}

/* 画像修正エリア */
.gallery-mediaSet-edit-area {
  margin-top: 3rem;
}
.gallery-mediaSet-edit-item {
  font-size: 14px;
  color: #707070;
  font-weight: 700;
  display: block;
}
.gallery-mediaSet-edit-input {
  font-size: 16px;
  color: #707070;
  border: 1px solid #c0c0c0;
  border-radius: 10px;
  width: 100%;
  line-height: 2.5rem;
  margin-top: 0.3rem;
  padding-left: 0.5rem;
}
.gallery-mediaSet-edit-input-disable {
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
.gallery-mediaSet-select {
  background-color: #fff;
  border-radius: 10px;
  border: 1px solid #c0c0c0;
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
  width: 10vw;
  border-radius: 3px;
}
.gallery-mediaSet-cancel-btn {
  width: 10vw;
  border-radius: 3px;
}
@media (max-width: 901px) {
  .gallery-mediaSet-update-btn {
    width: 13vw;
  }
  .gallery-mediaSet-cancel-btn {
    width: 13vw;
  }
}
@media (max-width: 640px) {
  .gallery-mediaSet-update-btn {
    width: 50vw;
    margin-bottom: 0.7rem;
  }
  .gallery-mediaSet-cancel-btn {
    width: 50vw;
  }
}
</style>