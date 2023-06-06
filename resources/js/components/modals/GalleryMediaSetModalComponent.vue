<template>
  <v-dialog :width="modalWidth" persistent>
    <v-card class="p-3">
      <!-- モーダルクローズボタン -->
      <v-row>
        <v-col class="d-flex justify-end">
          <button
            @click="closeDisplayGalleryMediaSetModal(), (edit_img_flg = false)"
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
          <!-- 画像やサムネイルのみ、編集ボタンを表示 -->
          <v-row
            @mouseenter.prevent="
              item.img_fileformat.split('/')[0] == 'image'
                ? (showEditBtn = true)
                : (showEditBtn = false),
                (showDeleteBtn = true)
            "
            @mouseleave.prevent="(showEditBtn = false), (showDeleteBtn = false)"
          >
            <v-col>
              <div
                v-show="
                  item.img_fileformat.split('/')[0] == 'image' ||
                  item.img_fileformat.split('/')[0] == 'text'
                "
                class="gallery-mediaSet-img-container"
              >
                <!--画像、テキストのサムネイルのみ表示 -->
                <img
                  v-if="
                    (!edit_img_flg &&
                      item.img_fileformat.split('/')[0] == 'image') ||
                    (!edit_img_flg &&
                      item.img_fileformat.split('/')[0] == 'text')
                  "
                  :src="
                    item.img_fileformat.split('/')[0] == 'image'
                      ? 'data:image/png;base64,' + item.img_path
                      : 'data:image/png;base64,' + item.img_path_text
                  "
                  :alt="item.img_alt == null ? item.img_filename : item.img_alt"
                />
                <!-- 画像のみ編集できる -->
                <img
                  v-if="
                    edit_img_flg && item.img_fileformat.split('/')[0] == 'image'
                  "
                  :src="'data:image/png;base64,' + crop_img"
                  :alt="item.img_alt == null ? item.img_filename : item.img_alt"
                />
                <!-- 編集ボタン -->
                <span
                  v-if="showEditBtn && approval_auth_flg"
                  class="mdi mdi-pencil gallery-mediaSet-edit-img-btn"
                  @click="editImage"
                >
                </span>
                <!-- 削除ボタン -->
                <span
                  v-if="showDeleteBtn && approval_auth_flg"
                  class="mdi mdi-trash-can gallery-mediaSet-delete-img-btn"
                  @click="deleteImage"
                >
                </span>
              </div>
              <!-- 編集・削除ボタン　SP版　BEGIN -->
              <!-- 編集ボタンSP（画像のみ） -->
              <span
                v-if="
                  moblieFlg() &&
                  approval_auth_flg &&
                  item.img_fileformat.split('/')[0] == 'image'
                "
                class="mdi mdi-pencil gallery-mediaSet-edit-img-btn"
                @click="editImage"
              >
              </span>
              <!-- 削除ボタンSP -->
              <span
                v-if="moblieFlg() && approval_auth_flg"
                class="mdi mdi-trash-can gallery-mediaSet-delete-img-btn"
                @click="deleteImage"
              >
              </span>
              <!-- 編集・削除ボタン　SP版　END -->
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <span class="gallery-mediaSet-name">{{ item.img_filename }}</span>
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
                <span class="gallery-mediaSet-infomation-content">
                  {{ showExt(item.img_fileformat) }}
                </span>
              </v-col>
              <!-- 画像詳細内容（右1）　アップロードした人 -->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name">
                  アップロードした人
                </span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-content">
                  {{ item.add_account.name }}
                </span>
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
                <span
                  v-if="!edit_img_flg"
                  class="gallery-mediaSet-infomation-content"
                >
                  {{
                    Math.round(item.img_filesize / 1000) > 0
                      ? Math.round(item.img_filesize / 1000)
                      : (item.img_filesize / 1000).toFixed(2)
                  }}KB
                </span>
                <span
                  v-if="edit_img_flg"
                  class="gallery-mediaSet-infomation-content"
                >
                  {{
                    Math.round(editedFile.size / 1000) > 0
                      ? Math.round(editedFile.size / 1000)
                      : (editedFile.size / 1000).toFixed(2)
                  }}KB
                </span>
              </v-col>
              <!-- 画像詳細内容（右2）　アップロード日 -->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name">
                  アップロード日
                </span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-content">
                  {{ format(item.created_at) }}
                </span>
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容（左3）　サイズ -->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name">サイズ</span>
              </v-col>
              <v-col cols="3">
                <span
                  v-if="!edit_img_flg"
                  class="gallery-mediaSet-infomation-content"
                >
                  {{ item.img_height }}px x {{ item.img_width }}px
                </span>
                <span
                  v-if="edit_img_flg"
                  class="gallery-mediaSet-infomation-content"
                >
                  {{ Math.round(date.height) }}px x
                  {{ Math.round(date.width) }}px
                </span>
              </v-col>
              <!-- 画像詳細内容（右3）　更新日 -->
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-name">更新日</span>
              </v-col>
              <v-col cols="3">
                <span class="gallery-mediaSet-infomation-content">
                  {{ format(item.updated_at) }}
                </span>
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
                <span class="gallery-mediaSet-infomation-content">
                  {{ showExt(item.img_fileformat) }}
                </span>
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
                <span
                  v-if="!edit_img_flg"
                  class="gallery-mediaSet-infomation-content"
                >
                  {{
                    Math.round(item.img_filesize / 1000) > 0
                      ? Math.round(item.img_filesize / 1000)
                      : (item.img_filesize / 1000).toFixed(2)
                  }}KB
                </span>
                <span
                  v-if="edit_img_flg"
                  class="gallery-mediaSet-infomation-content"
                >
                  {{
                    Math.round(editedFile.size / 1000) > 0
                      ? Math.round(editedFile.size / 1000)
                      : (editedFile.size / 1000).toFixed(2)
                  }}KB
                </span>
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容　サイズ-->
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-name">サイズ</span>
              </v-col>
              <v-col cols="6">
                <span
                  v-if="!edit_img_flg"
                  class="gallery-mediaSet-infomation-content"
                >
                  {{ item.img_height }}px x {{ item.img_width }}px
                </span>
                <span
                  v-if="edit_img_flg"
                  class="gallery-mediaSet-infomation-content"
                >
                  {{ Math.round(date.height) }}px x
                  {{ Math.round(date.width) }}px
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
                <span class="gallery-mediaSet-infomation-content">
                  {{ item.add_account.name }}
                </span>
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
                <span class="gallery-mediaSet-infomation-content">
                  {{ format(item.created_at) }}
                </span>
              </v-col>
            </v-row>
            <v-row class="gallery-mediaSet-infomation-area">
              <!-- 画像詳細内容　更新日-->
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-name">更新日</span>
              </v-col>
              <v-col cols="6">
                <span class="gallery-mediaSet-infomation-content">
                  {{ format(item.updated_at) }}
                </span>
              </v-col>
            </v-row>
          </div>
          <!-- 画像詳細内容（修正不可）SP END -->

          <!-- 画像設定（修正可能） PC BEGIN-->
          <div class="mt-4" v-if="!moblieFlg() && approval_auth_flg">
            <v-row class="gallery-mediaSet-edit-area">
              <!-- 画像設定（左1）　キャプション-->
              <v-col cols="6">
                <span class="gallery-mediaSet-edit-item">キャプション</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input"
                  v-model="caption"
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
                  v-model="memo"
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
                  v-model="alt"
                />
              </v-col>
              <!-- 画像設定　フォルダ-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">フォルダ</span>
                <v-select
                  class="gallery-mediaSet-select"
                  :items="folders"
                  item-title="name"
                  item-value="id"
                  v-model="folderidModel"
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
                  :value="showUpdatePath(item)"
                />
              </v-col>
            </v-row>
          </div>
          <!-- 画像設定（修正可能） PC END-->

          <!-- 画像設定（修正可能） SP BEGIN-->
          <div class="mt-4" v-if="moblieFlg() && approval_auth_flg">
            <v-row class="gallery-mediaSet-edit-area">
              <!-- 画像設定　キャプション-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">キャプション</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input"
                  v-model="caption"
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
                  v-model="memo"
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
                  v-model="alt"
                />
              </v-col>
              <!-- 画像設定　フォルダ-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">フォルダ</span>
                <v-select
                  class="gallery-mediaSet-select"
                  :items="folders"
                  item-title="name"
                  item-value="id"
                  v-model="folderidModel"
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
                  :value="showUpdatePath(item)"
                />
              </v-col>
            </v-row>
          </div>
          <!-- 画像設定（修正可能） SP END-->

          <!-- 画像設定（閲覧者） PC BEGIN-->
          <div class="mt-4" v-if="!moblieFlg() && !approval_auth_flg">
            <v-row class="gallery-mediaSet-edit-area">
              <!-- 画像設定（左1）　キャプション-->
              <v-col cols="6">
                <span class="gallery-mediaSet-edit-item">キャプション</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input-disable"
                  v-model="caption"
                  disabled
                />
              </v-col>
              <!-- 画像設定（右1）　メモ -->
              <v-col cols="6">
                <span class="gallery-mediaSet-edit-item">メモ</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input-disable"
                  v-model="memo"
                  disabled
                />
              </v-col>
              <!-- 画像設定　代替テキスト-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">代替テキスト</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input-disable"
                  v-model="alt"
                  disabled
                />
              </v-col>
              <!-- 画像設定　フォルダ-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">フォルダ</span>
                <v-select
                  class="gallery-mediaSet-select"
                  :items="folders"
                  item-title="name"
                  item-value="id"
                  v-model="folderidModel"
                  disabled
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
                  :value="showUpdatePath(item)"
                />
              </v-col>
            </v-row>
          </div>
          <!-- 画像設定（閲覧者） PC END-->

          <!-- 画像設定（閲覧者） SP BEGIN-->
          <div class="mt-4" v-if="moblieFlg() && !approval_auth_flg">
            <v-row class="gallery-mediaSet-edit-area">
              <!-- 画像設定　キャプション-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">キャプション</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input-disable"
                  v-model="caption"
                  disabled
                />
              </v-col>
              <!-- 画像設定　メモ -->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">メモ</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input-disable"
                  v-model="memo"
                  disabled
                />
              </v-col>
              <!-- 画像設定　代替テキスト-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">代替テキスト</span>
                <input
                  dense
                  type="text"
                  hide-details="false"
                  class="gallery-mediaSet-edit-input-disable"
                  v-model="alt"
                  disabled
                />
              </v-col>
              <!-- 画像設定　フォルダ-->
              <v-col cols="12">
                <span class="gallery-mediaSet-edit-item">フォルダ</span>
                <v-select
                  class="gallery-mediaSet-select"
                  :items="folders"
                  item-title="name"
                  item-value="id"
                  v-model="folderidModel"
                  disabled
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
                  :value="showUpdatePath(item)"
                />
              </v-col>
            </v-row>
          </div>
          <!-- 画像設定（閲覧者） SP END-->
        </div>
      </div>

      <!-- 操作 -->
      <v-card-actions class="justify-center gallery-mediaSet-action-area">
        <!-- 更新ボタン -->
        <v-btn
          @click="updateMediaAction()"
          class="green-btn_noTransform mx-2 gallery-mediaSet-update-btn"
          v-if="approval_auth_flg"
          >更新</v-btn
        >
        <!-- キャンセルボタン -->
        <v-btn
          @click="
            closeDisplayGalleryMediaSetModal(),
              ((edit_img_flg = false),
              (beforefolderID = null),
              (afterfolderID = null))
          "
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
      :id="item.id"
      :folderid="item.media_folder_id"
      @close="closeDisplayGalleryMediaSetModal()"
    />
    <!-- 画像編集モーダル -->
    <gallery-media-edit-modal-component
      :modelValue="displayGalleryMediaEditConfirm"
      :closeDisplayGalleryMediaEditConfirmModal="
        closeDisplayGalleryMediaEditConfirm
      "
      :img="item.img_path"
      :img_alt="item.img_alt == null ? item.img_filename : item.img_alt"
      :type="showExt(item.img_fileformat)"
      @update="updateImg"
    />
  </v-dialog>
</template>
  
<script>
import { mapActions } from "vuex";

import GalleryMediaDeleteConfirmModalComponent from "../modals/GalleryMediaDeleteConfirmModalComponent.vue";
import GalleryMediaEditModalComponent from "../modals/GalleryMediaEditModalComponent.vue";
import moment from "moment";

export default {
  components: {
    GalleryMediaDeleteConfirmModalComponent,
    GalleryMediaEditModalComponent,
  },
  props: ["closeDisplayGalleryMediaSetModal", "item", "folders", "folderid"],
  emits: ["update:folderid"],
  data() {
    return {
      showDeleteBtn: false,
      showEditBtn: false,
      displayGalleryMediaDeleteConfirm: false,
      displayGalleryMediaEditConfirm: false,
      cap: "",
      memo_: "",
      alt_: "",
      approval_auth_flg: false,
      create_auth_flg: false,
      edit_img_flg: false,
      crop_img: "",
      editedFile: null,
      date: null,
      afterfolderID: null,
      beforefolderID: null,
    };
  },
  methods: {
    ...mapActions("authority", ["fetchAllAuthority"]),

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

    //画面編集モーダルを閉じる
    closeDisplayGalleryMediaEditConfirm() {
      this.displayGalleryMediaEditConfirm = false;
    },

    // 更新処理
    updateMediaAction() {
      let formData = new FormData();
      const info = {
        img_caption: this.cap,
        img_memo: this.memo_,
        img_alt: this.alt_,
        media_folder_id: this.folderidModel,
      };
      formData.append("mediaAttachment", JSON.stringify(info));

      if (this.edit_img_flg) {
        const info2 = {
          img_filesize: this.editedFile.size,
          img_width: this.date.width,
          img_height: this.date.height,
        };
        formData.append("file", this.editedFile);
        formData.append("fileData", JSON.stringify(info2));
      }
      axios.post("/api/mediaAttachment/update/" + this.item.id, formData, {
        headers: { "Content-type": "multipart/form-data" },
      });

      this.edit_img_flg = false;
      if (
        this.beforefolderID !== this.afterfolderID &&
        this.afterfolderID !== null
      ) {
        this.$store.dispatch("gallery/setGalleryMove", this.beforefolderID);
        this.$store.dispatch("gallery/setGalleryMove2", this.afterfolderID);
      }

      this.beforefolderID = null;
      this.afterfolderID = null;

      this.closeDisplayGalleryMediaSetModal();
    },

    // 画像削除処理
    deleteImage() {
      // 画像削除モーダル開く
      this.displayGalleryMediaDeleteConfirm = true;
      console.log("press deleteImage btn");
    },

    // 画像編集モーダルを開く
    editImage() {
      // 画像編集モーダル開く
      this.displayGalleryMediaEditConfirm = true;
    },

    //日付設定
    format(date) {
      return moment(date).format("yyyy/MM/DD");
    },

    // 画像更新処理
    updateImg(value1, value2, value3) {
      this.crop_img = value1;
      this.editedFile = value2;
      this.edit_img_flg = true;
      this.date = value3;
    },

    // 画像 アップロード先取得
    showUpdatePath(item) {
      const siteUrl = window.location.href;
      // アップロード先 = siteUrl/店舗id/画像id/画像名.拡張子
      let updatePath =
        siteUrl + "/" + item.shop_id + "/" + item.id + "/" + item.img_filename;
      return updatePath;
    },

    // 拡張子の処理
    showExt(fullExt) {
      let shortExt = fullExt.split("/")[1];
      if (shortExt == "plain") {
        shortExt = "txt";
      }
      return shortExt;
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

    caption: {
      get() {
        this.cap = this.item.img_caption;
        return this.item.img_caption;
      },
      set(newVal) {
        this.cap = newVal;
      },
    },

    memo: {
      get() {
        this.memo_ = this.item.img_memo;
        return this.item.img_memo;
      },
      set(newVal) {
        this.memo_ = newVal;
      },
    },

    alt: {
      get() {
        this.alt_ = this.item.img_alt;
        return this.item.img_alt;
      },
      set(newVal) {
        this.alt_ = newVal;
      },
    },

    folderidModel: {
      get() {
        if (this.beforefolderID === null || this.afterfolderID === null) {
          this.beforefolderID = this.$props.folderid;
        }
        return this.$props.folderid;
      },
      set(newVal) {
        this.$emit("update:folderid", newVal);
        this.afterfolderID = newVal;
      },
    },
  },
  async mounted() {
    let authority = await this.fetchAllAuthority();
    if (authority) {
      this.create_auth_flg = authority.create_auth_flg;
      this.approval_auth_flg = authority.approval_auth_flg;
    }
  },
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

.gallery-mediaSet-img-container {
  position: relative;
  width: 100%;
  height: 400px;
  background-color: #ffffff;
  overflow: hidden;
}

.gallery-mediaSet-img-container img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.gallery-mediaSet-not-img {
  width: 100%;
  height: 400px;
  background-color: #f7f7f7;
  position: relative;
}
@media (max-width: 901px) {
  .gallery-mediaSet-not-img {
    height: 300px;
  }
}
@media (max-width: 640px) {
  .gallery-mediaSet-not-img {
    height: 200px;
  }
}
.gallery-mediaSet-not-img::after {
  content: attr(fileExt);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: xx-large;
  color: #9f9f9f;
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
  color: #000000;
  background-color: #f5f5f5;
  border: 1px solid #c0c0c0;
  border-radius: 10px;
  width: 100%;
  line-height: 2.5rem;
  margin-top: 0.3rem;
  padding-left: 0.5rem;
}
@media (max-width: 900px) {
  .gallery-mediaSet-edit-input-disable {
    background-color: #f0f0f0;
  }
}
@media (max-width: 640px) {
  .gallery-mediaSet-edit-input-disable {
    background-color: #f0f0f0;
    font-size: x-small;
  }
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