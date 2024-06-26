<template>
  <v-dialog :width="modalWidth" persistent>
    <v-card class="p-3">
      <!-- モーダルクローズボタン -->
      <v-row>
        <v-col class="d-flex justify-end">
          <button
            @click="closeDisplayGalleryMediaDisplaySetSpModal()"
            class="gallery-mediaDisplaySet-close-btn"
            type="button"
          >
            ×
          </button>
        </v-col>
      </v-row>
      <!-- モーダル内容エリア -->
      <div class="gallery-mediaDisplaySet-display-body">
        <div class="mx-auto gallery-mediaDisplaySet-imgs-title">
          <p>順番の並び替えは<br />ドラッグ＆ドロップをしてください。</p>
        </div>
        <!-- 画面設定表示エリア(ドラッグ・ドロップ)-->
        <div class="gallery-mediaDisplaySet-imgs-area mx-auto">
          <draggable
            :list="Library"
            :itemKey="(Library) => Library.id"
            class="d-flex child-flex gallery-mediaDisplaySet-imgs-show"
          >
            <template #item="{ element, index }">
              <v-col cols="6" class="d-flex align-center justify-center pb-0">
                <v-img
                  :key="element.id"
                  :src="
                    element.img_fileformat.split('/')[0] == 'image'
                      ? 'data:image/png;base64,' + element.img_path
                      : 'data:image/png;base64,' + element.img_path_text
                  "
                  aspect-ratio="1"
                  cover
                  class="gallery-mediaDisplay-img"
                >
                  <p class="gallery-mediaDisplay-img-id">{{ index + 1 }}</p>
                </v-img>
              </v-col>
            </template>
          </draggable>
        </div>

        <!-- ギャラリーの設定 -->
        <div class="gallery-mediaDisplaySet-gallerySet-area mx-auto">
          <!-- 仕切り線 -->
          <div class="gallery-horizontal-divider"></div>

          <!-- タイトル -->
          <p
            class="text-subtitle-1 font-weight-bold gallery-mediaDisplaySet-title"
          >
            ギャラリーの設定
          </p>

          <v-row>
            <!-- 表示順 -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              表示順
            </v-col>
            <v-col cols="7">
              <v-select
                class="gallery-mediaDisplaySet-select"
                :items="sorts"
                item-value="id"
                item-title="text"
                hide-details="false"
                v-model="sortModel"
                text
              />
            </v-col>

            <!-- 画像サイズ -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              画像サイズ
            </v-col>
            <v-col cols="7">
              <span class="gallery-mediaDisplaySet-edit-name">横幅</span>
              <input
                dense
                type="number"
                hide-details="false"
                class="gallery-mediaDisplaySet-input"
                v-model="widthModel"
              />
              <br />
              <span class="gallery-mediaDisplaySet-edit-name">縦幅</span>
              <input
                dense
                type="number"
                hide-details="false"
                class="gallery-mediaDisplaySet-input"
                v-model="heightModel"
              />
            </v-col>

            <!-- 表示カラム数 -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              表示カラム数
            </v-col>
            <v-col cols="7">
              <v-select
                class="gallery-mediaDisplaySet-select"
                :items="column_num2"
                hide-details="false"
                v-model="column_numModel"
                item-value="id"
                item-title="text"
                text
              />
            </v-col>
            <v-col cols="11" class="gallery-mediaDisplaySet-set-item">
              <p class="gallery-mediaDisplaySet-set-hint">
                「画像サイズ」と「表示列数」をお知らせの本文表示範囲に応じて調整して表示する。
              </p>
            </v-col>

            <!-- 配置 -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              配置
            </v-col>
            <v-col cols="7">
              <v-radio-group inline v-model="alignModel">
                <v-radio
                  label="左"
                  :value="1"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
                <v-radio
                  label="中央"
                  :value="2"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
                <v-radio
                  label="右"
                  :value="3"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
              </v-radio-group>
            </v-col>

            <!-- リンク -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              リンク
            </v-col>
            <v-col cols="7">
              <v-radio-group inline v-model="linkModel">
                <v-radio
                  label="なし"
                  :value="0"
                  class="gallery-mediaDisplaySet-radio"
                  @click="disableInput(0)"
                ></v-radio>
                <v-radio
                  label="あり"
                  :value="1"
                  class="gallery-mediaDisplaySet-radio"
                  @click="disableInput(1)"
                ></v-radio>
              </v-radio-group>
              <input
                dense
                type="text"
                hide-details="false"
                class="gallery-mediaDisplaySet-input-link"
                placeholder="外部URL"
                :v-model="link_urlModel ? link_urlModel : ''"
                :disabled="mediaLinkInputDisabled"
                :required="mediaLinkInputRequired === '1'"
              />
            </v-col>

            <!-- 画像同士の間の余白 -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              画像同士の<br />間の余白
            </v-col>
            <v-col cols="7">
              <v-radio-group inline v-model="marginModel">
                <v-radio
                  label="なし"
                  :value="0"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
                <v-radio
                  label="小"
                  :value="1"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
                <v-radio
                  label="中"
                  :value="2"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
                <v-radio
                  label="最大"
                  :value="3"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
              </v-radio-group>
            </v-col>

            <!-- キャプションの表示 -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              キャプションの<br />表示
            </v-col>
            <v-col cols="7">
              <v-radio-group inline v-model="captionModel">
                <v-radio
                  label="なし"
                  :value="0"
                  class="gallery-mediaDisplaySet-radio"
                >
                </v-radio>
                <v-radio
                  label="オーバーレイ"
                  :value="1"
                  class="gallery-mediaDisplaySet-radio"
                >
                </v-radio>
                <div class="gallery-mediaDisplaySet-set-insideHint">
                  リンクなしの場合のみ
                </div>
                <v-radio
                  label="ポップアップ"
                  :value="2"
                  class="gallery-mediaDisplaySet-radio"
                >
                </v-radio>
                <div class="gallery-mediaDisplaySet-set-insideHint">
                  リンクありの場合のみ
                </div>
              </v-radio-group>
            </v-col>

            <!-- 枠のデザイン -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              枠のデザイン
            </v-col>
            <v-col cols="7">
              <v-radio-group inline v-model="frame_designModel">
                <v-radio
                  label="なし"
                  :value="0"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
                <v-radio
                  label="狭い"
                  :value="1"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
                <v-radio
                  label="太い"
                  :value="2"
                  class="gallery-mediaDisplaySet-radio"
                >
                </v-radio>
              </v-radio-group>
            </v-col>

            <!-- 枠の色 -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              枠の色
            </v-col>
            <v-col cols="7">
              <div class="gallery-mediaDisplaySet-colorInput">
                <!-- カラーピッカー -->
                <input
                  type="color"
                  id="colorPicker"
                  name="colorPicker"
                  class="gallery-mediaDisplaySet-color-span"
                  @click="selectColor"
                  :value="'#' + frame_colorModel"
                />
                <!-- カラー入力欄 -->
                <span class="gallery-mediaDisplaySet-edit-name">#</span>
                <input
                  dense
                  id="colorInput"
                  type="text"
                  hide-details="false"
                  class="gallery-mediaDisplaySet-input"
                  v-model="frame_colorModel"
                />
              </div>
            </v-col>

            <!-- 影 -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">影</v-col>
            <v-col cols="7">
              <v-radio-group inline v-model="shadowModel">
                <v-radio
                  label="なし"
                  :value="0"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
                <v-radio
                  label="あり"
                  :value="1"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
              </v-radio-group>
            </v-col>

            <!-- ホバー時の画像拡大 -->
            <v-col cols="5" class="gallery-mediaDisplaySet-set-item">
              ホバー時の<br />画像拡大
            </v-col>
            <v-col cols="7">
              <v-radio-group inline v-model="hover_expandModel">
                <v-radio
                  label="なし"
                  :value="0"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
                <v-radio
                  label="あり"
                  :value="1"
                  class="gallery-mediaDisplaySet-radio"
                ></v-radio>
              </v-radio-group>
            </v-col>

            <!-- ホバー時のアイコン -->
            <v-col cols="6" class="gallery-mediaDisplaySet-set-item">
              ホバー時のアイコン
              <p class="gallery-mediaDisplaySet-set-hint">
                リンクありの場合のみ
              </p>
            </v-col>
            <v-col cols="6">
              <div
                v-for="(mdi, index) in hoverIconSelect"
                :key="index"
                class="gallery-mediaDisplaySet-set-hoverIcon"
                @click="hoverIconFocus(mdi)"
              >
                <span
                  :class="
                    mdi.isSelect
                      ? mdi.class + ' gallery-mediaDisplaySet-mdi-active'
                      : mdi.class
                  "
                  :value="mdi.value"
                >
                </span>
              </div>
            </v-col>
          </v-row>
        </div>
      </div>

      <!-- 操作 -->
      <v-card-actions
        class="justify-center gallery-mediaDisplaySet-action-area"
      >
        <!-- 作成するボタン -->
        <v-btn
          @click="makeMediaAction()"
          class="green-btn_noTransform mx-2 gallery-mediaDisplaySet-make-btn"
        >
          作成する
        </v-btn>
        <v-btn
          class="gray-btn mx-2 gallery-mediaDisplaySet-make-btn"
          @click="closeDisplayGalleryMediaDisplaySetSpModal()"
        >
          キャンセル
        </v-btn>
      </v-card-actions>
    </v-card>

    <!-- メディアショートコードモーダル -->
    <gallery-media-short-code-make-modal-component
      :modelValue="displayGalleryMediaShortCodeMake"
      :closeDisplayGalleryMediaShortCodeMakeModal="
        closeDisplayGalleryMediaShortCodeMake
      "
    />
  </v-dialog>
</template>
  
<script>
import Draggable from "vuedraggable";
import GalleryMediaShortCodeMakeModalComponent from "../modals/GalleryMediaShortCodeMakeModalComponent.vue";

export default {
  components: { Draggable, GalleryMediaShortCodeMakeModalComponent },
  props: [
    "closeDisplayGalleryMediaDisplaySetSpModal",
    "Library",
    "sort",
    "width",
    "height",
    "column_num",
    "align",
    "link",
    "linkurl",
    "margin",
    "caption",
    "frame_design",
    "frame_color",
    "shadow",
    "hover_expand",
    "hover_icon",
  ],
  emits: [
    "update:sort",
    "update:width",
    "update:height",
    "update:column_num",
    "update:align",
    "update:link",
    "update:linkurl",
    "update:margin",
    "update:caption",
    "update:frame_design",
    "update:frame_color",
    "update:shadow",
    "update:hover_expand",
    "update:hover_icon",
  ],
  data() {
    return {
      hoverIconSelect: [
        {
          id: "1",
          class: "mdi mdi-solid gallery-mediaDisplaySet-mdi-null",
          isSelect: false,
          value: "0",
        },
        {
          id: "2",
          class: "mdi mdi-magnify-plus-outline gallery-mediaDisplaySet-mdi",
          isSelect: false,
          value: "1",
        },
        {
          id: "3",
          class: "mdi mdi-magnify gallery-mediaDisplaySet-mdi",
          isSelect: false,
          value: "2",
        },
        {
          id: "4",
          class: "mdi mdi-plus-circle-outline gallery-mediaDisplaySet-mdi",
          isSelect: false,
          value: "3",
        },
        {
          id: "5",
          class: "mdi mdi-plus-box-outline gallery-mediaDisplaySet-mdi",
          isSelect: false,
          value: "4",
        },
      ],
      sorts: [
        {
          id: 1,
          text: "昇順",
        },
        {
          id: 2,
          text: "降順",
        },
      ],
      column_num2: [
        {
          id: 1,
          text: "1",
        },
        {
          id: 2,
          text: "2",
        },
        {
          id: 3,
          text: "3",
        },
        {
          id: 4,
          text: "4",
        },
      ],
      displayGalleryMediaShortCodeMake: false,
      item: null,
      sethover_icon: null,
      mediaLinkInputDisabled: true,
      mediaLinkInputRequired: "",
    };
  },
  computed: {
    sortModel: {
      get() {
        return this.$props.sort;
      },
      set(newVal) {
        this.$emit("update:sort", newVal);
      },
    },
    widthModel: {
      get() {
        return this.$props.width;
      },
      set(newVal) {
        this.$emit("update:width", newVal);
      },
    },
    heightModel: {
      get() {
        return this.$props.height;
      },
      set(newVal) {
        this.$emit("update:height", newVal);
      },
    },
    column_numModel: {
      get() {
        return this.$props.column_num;
      },
      set(newVal) {
        this.$emit("update:column_num", newVal);
      },
    },
    alignModel: {
      get() {
        return this.$props.align;
      },
      set(newVal) {
        this.$emit("update:align", newVal);
      },
    },
    linkModel: {
      get() {
        return this.$props.link;
      },
      set(newVal) {
        this.$emit("update:link", newVal);
      },
    },
    link_urlModel: {
      get() {
        return this.$props.linkurl;
      },
      set(newVal) {
        this.$emit("update:linkurl", newVal);
      },
    },
    marginModel: {
      get() {
        return this.$props.margin;
      },
      set(newVal) {
        this.$emit("update:margin", newVal);
      },
    },
    captionModel: {
      get() {
        return this.$props.caption;
      },
      set(newVal) {
        this.$emit("update:caption", newVal);
      },
    },
    frame_designModel: {
      get() {
        return this.$props.frame_design;
      },
      set(newVal) {
        this.$emit("update:frame_design", newVal);
      },
    },
    frame_colorModel: {
      get() {
        return this.$props.frame_color;
      },
      set(newVal) {
        this.$emit("update:frame_color", newVal);
      },
    },
    shadowModel: {
      get() {
        return this.$props.shadow;
      },
      set(newVal) {
        this.$emit("update:shadow", newVal);
      },
    },
    hover_expandModel: {
      get() {
        this.hoverIconSelect[this.$props.hover_icon].isSelect = true;
        this.sethover_icon = this.$props.hover_icon;
        return this.$props.hover_expand;
      },
      set(newVal) {
        this.$emit("update:hover_expand", newVal);
      },
    },
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
  methods: {
    // モバイル判定
    moblieFlg() {
      return window.matchMedia &&
        window.matchMedia("(max-device-width: 640px)").matches
        ? true
        : false;
    },

    // 作成処理
    makeMediaAction() {
      let formData = new FormData();
      const item = {
        media_width: this.widthModel,
        media_height: this.heightModel,
        media_sort: this.sortModel,
        media_column_num: this.column_numModel,
        media_align: this.alignModel,
        media_link: this.linkModel,
        media_link_url: encodeURIComponent(this.link_urlModel),
        media_margin: this.marginModel,
        media_caption: this.captionModel,
        media_frame_design: this.frame_designModel,
        media_frame_color: encodeURIComponent(this.frame_colorModel),
        media_shadow: this.shadowModel,
        media_hover_expand: this.hover_expandModel,
        media_hover_icon: this.sethover_icon,
      };

      formData.append("mediafolder", JSON.stringify(item));
      axios
        .post(
          "api/mediafolder/" +
            this.$store.state.library.selectedFolder +
            "/update",
          formData,
          { headers: { "Content-type": "multipart/form-data" } }
        )
        .then((res) => {});

      axios
        .post(
          "api/mediafolder/" +
            this.$store.state.library.selectedFolder +
            "/update",
          formData,
          { headers: { "Content-type": "multipart/form-data" } }
        )
        .then((res) => {});

      // ドラッグ＆ドロップの並び順の処理
      const id = this.$store.state.library.selectedFolder;
      let galleryFormData = new FormData();
      let galleryImages = this.Library;
      const sortBy = this.sortModel;

      // 降順処理
      if (sortBy == 2) {
        galleryImages = this.Library.reverse();
      }

      axios
        .post("webapi/media/imageSort/" + id, galleryImages)
        .then((res) => {})
        .catch((error) => {
          console.log(error);
        });

      this.displayGalleryMediaShortCodeMake = true;
    },

    // リンクがありの場合、外部リンクテキストボックスがrequiredにする
    disableInput(value) {
      if (value == 1) {
        this.mediaLinkInputDisabled = false;
        this.mediaLinkInputRequired = value;
      } else {
        this.mediaLinkInputDisabled = true;
        this.mediaLinkInputRequired = value;
      }
    },

    // カラー選択
    selectColor() {
      const colorPickerInput = document.getElementById("colorPicker");
      const colorInput = document.getElementById("colorInput");
      let self = this;

      // テキストボックスで入力したcolor codeをカラーピッカーに表示
      colorInput.addEventListener("input", function () {
        const value = colorInput.value;
        // color codeのバリデーション
        if (!/^[0-9a-fA-F]{6}$/.test(value)) {
          return;
        }
        // color codeを取得するとカラーピッカーに表示
        colorPickerInput.value = "#" + value;
      });

      // カラーピッカーで選択したcolor codeをテキストボックスに表示
      colorPickerInput.addEventListener("change", function () {
        colorInput.value = colorPickerInput.value.replace("#", "");
        self.frame_colorModel = colorInput.value;
      });
    },

    // ホバー時のアイコンCSS
    hoverIconFocus(mdi) {
      mdi.isSelect = !mdi.isSelect;
      this.sethover_icon = mdi.value;
      for (var i = 0; i < this.hoverIconSelect.length; i++) {
        if (this.hoverIconSelect[i] != mdi) {
          this.hoverIconSelect[i].isSelect = false;
        }
      }
    },

    //ショートコードモーダルを閉じる
    closeDisplayGalleryMediaShortCodeMake() {
      this.displayGalleryMediaShortCodeMake = false;
      this.closeDisplayGalleryMediaDisplaySetSpModal();
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
@media (max-width: 640px) {
  .gallery-mediaDisplaySet-display-body {
    overflow-y: auto !important;
    overflow-x: hidden !important;
  }
  /* モーダルクローズボタン */
  .gallery-mediaDisplaySet-close-btn {
    color: #767676;
    font-size: 2rem;
    margin: 0.5rem 0.5rem 1rem 0rem;
  }
  .gallery-mediaDisplaySet-close-btn:active {
    border-color: none !important;
  }

  /* 画像表示設定エリア */
  .gallery-mediaDisplaySet-imgs-title {
    text-align: center;
    font-size: 14px;
    color: #707070;
  }
  .gallery-mediaDisplaySet-imgs-area {
    position: relative;
    width: 95%;
    height: 50vh;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    margin-top: -1rem;
  }
  .gallery-mediaDisplaySet-imgs-show {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: flex-start;
  }
  .gallery-mediaDisplay-img {
    width: 12vw;
    height: auto;
    margin: 0.7rem 0.7rem 0rem 0rem;
    cursor: pointer;
    background-color: #f7f7f7;
  }
  .gallery-mediaDisplay-img-id {
    color: #fff;
    background-color: #69a5af;
    border: #fff 2px solid;
    width: 20px;
    height: 20px;
    position: absolute;
    top: 5px;
    right: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 12px;
  }

  /* ギャラリーの設定エリア */
  .gallery-mediaDisplaySet-gallerySet-area {
    position: relative;
    width: 95%;
    margin-top: 0rem;
  }
  .gallery-mediaDisplaySet-title {
    font-size: 20px !important;
    margin-bottom: 2rem !important;
    color: #767676;
  }

  .gallery-mediaDisplaySet-set-item {
    font-size: 14px;
    color: #707070;
    font-weight: 700;
  }

  .gallery-mediaDisplaySet-set-hint {
    font-size: 12px;
    color: #cacaca;
  }
  .gallery-mediaDisplaySet-set-insideHint {
    font-size: 12px;
    color: #cacaca;
    margin-left: 17%;
    margin-top: -0.6rem;
    font-weight: 700 !important;
  }
  .gallery-mediaDisplaySet-select {
    background-color: #fff;
    border-radius: 5px;
    border: 1px solid #c0c0c0;
    width: 20vw;
  }

  .gallery-mediaDisplaySet-input {
    font-size: 14px;
    color: #707070;
    border: 1px solid #c0c0c0;
    border-radius: 5px;
    width: 17vw;
    line-height: 2rem;
    padding-left: 0.5rem;
    margin-right: 2rem;
    margin-bottom: 1rem;
  }

  .gallery-mediaDisplaySet-input-link {
    font-size: 12px;
    color: #707070;
    border: 1px solid #c0c0c0;
    border-radius: 5px;
    width: 35vw;
    line-height: 2rem;
    padding-left: 0.5rem;
    margin-right: 2rem;
  }

  .gallery-mediaDisplaySet-edit-name {
    font-size: 14px;
    color: #707070;
    margin-right: 5px;
  }

  .gallery-mediaDisplaySet-radio {
    color: #707070;
    margin-left: -12px;
    margin-right: 1.5rem;
    --v-medium-emphasis-opacity: 1;
  }

  .gallery-mediaDisplaySet-color-span {
    width: 25px;
    height: 25px;
    display: inline-block;
    vertical-align: middle;
    margin-right: 1.2rem;
    background-color: #ccc;
    cursor: pointer;
  }

  .gallery-mediaDisplaySet-set-hoverIcon {
    display: inline-flex;
    text-align: center;
  }

  .gallery-mediaDisplaySet-mdi-null {
    border-radius: 3px;
    background-color: #adadad;
    cursor: pointer;
    margin-right: 0.7rem;
    margin-bottom: 0.7rem;
    cursor: pointer;
    color: #adadad;
    font-size: 22px;
    width: 35px;
    height: 35px;
  }

  .gallery-mediaDisplaySet-mdi {
    border-radius: 3px;
    background-color: #adadad;
    cursor: pointer;
    margin-right: 0.7rem;
    margin-bottom: 0.7rem;
    cursor: pointer;
    color: #fff;
    font-size: 22px;
    width: 35px;
    height: 35px;
  }

  .gallery-mediaDisplaySet-mdi-active {
    border: #69a5af 2px solid !important;
    box-sizing: border-box;
  }

  /* 操作ボタン */
  .gallery-mediaDisplaySet-action-area {
    margin-top: 2rem;
  }
  @media (max-width: 640px) {
    .gallery-mediaDisplaySet-action-area {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  }

  .gallery-mediaDisplaySet-make-btn {
    width: 50vw;
    margin-bottom: 0.7rem;
  }
}
</style>