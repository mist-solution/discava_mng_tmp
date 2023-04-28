<template>
  <!-- タイトル -->
  <div class="gallery-title-library">
    <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">ライブラリ</p>
    <button
      :class="[
        selectedfolderid == null ||
        selectedfolderid == -1 ||
        selectedfolderid == 0
          ? 'btn disable-btn'
          : selectMediaFlg
          ? 'btn gallery-library-gallery-make-btn-sp'
          : 'btn white-btn',
      ]"
      type="button"
      :disabled="
        selectedfolderid == null ||
        selectedfolderid == -1 ||
        selectedfolderid == 0
      "
      @click="GalleryToggle()"
      v-if="create_auth_flg"
    >
      ギャラリーを作成
    </button>
  </div>

  <!-- 検索エリア -->
  <!-- セレクトボックス -->
  <div class="gallery-library-search-area-sp">
    <v-select
      class="filter-btn gallery-library-search-select-sp"
      :items="items"
      item-title="text"
      item-value="id"
      hide-details="false"
      :label="this.data_id === null ? 'すべてのデータ' : ''"
      @update:modelValue="dataidChange"
    />
    <DatePicker
      class="filter-btn gallery-library-search-datepicker-sp"
      v-model="createdmodel"
      placeholder="全ての月"
      :format="format"
      :preview-format="previewFormat"
      selectText="確認"
      cancelText="キャンセル"
      month-picker
      @update:model-value="FilterLibrary"
      locale="jp"
    />
  </div>
  <!-- テキストボックス・追加ボタン -->
  <div class="gallery-library-search-area-sp">
    <div class="gallery-library-search-sp">
      <button type="button" class="gallery-library-search-icon-sp">
        <v-icon>mdi-magnify</v-icon>
      </button>
      <div class="d-flex">
        <input
          class="gallery-library-search-input-sp"
          type="search"
          maxlength="30"
          hide-details="false"
          v-model="captionModel"
          @change="FilterLibrary"
        />
      </div>
    </div>
    <div class="samb-box" v-if="create_auth_flg">
      <label
        for="image"
        class="green-btn_noTransform px-2 py-1 gallery-library-add-btn-sp"
        >追加</label
      >
      <input type="file" id="image" accept="image/*" @change="readImage" />
    </div>
  </div>

  <!-- 仕切り線 -->
  <div class="gallery-horizontal-divider"></div>

  <!-- ライブラリ一覧 -->
  <div class="gallery-library-list-area-sp">
    <v-row>
      <v-col
        v-for="(item, index) in library"
        :key="index"
        class="d-flex child-flex gallery-library-img-margin-sp"
        cols="4"
      >
        <div class="btn-group" @click="clickMedia(item, item.selected)">
          <v-img
            :src="'data:image/png;base64,' + item.img_path"
            aspect-ratio="1"
            cover
            :class="
              item.img_path
                ? 'gallery-library-img-sp bg-grey-lighten-2'
                : 'gallery-library-img-sample-sp bg-grey-lighten-2 gallery-library-img-sp'
            "
          >
            <p
              v-if="selectMediaFlg && item.selected"
              class="gallery-library-img-id-sp"
            >
              {{ item.selectNo }}
            </p>
          </v-img>
        </div>
      </v-col>
    </v-row>
  </div>

  <!-- 画像設定モーダル -->
  <gallery-media-set-modal-component
    :modelValue="displayGalleryMediaSet"
    @update:modelValue="displayGalleryMediaSet = $event"
    :closeDisplayGalleryMediaSetModal="closeDisplayGalleryMediaSet"
    :item="mediaAttachment"
    :folders="folder2"
    v-model:folderid="folderid"
  />

  <!-- 画像表示設定モーダル -->
  <gallery-media-display-set-modal-component-sp
    :modelValue="displayGalleryMediaDisplaySetSp"
    @update:modelValue="displayGalleryMediaDisplaySetSp = $event"
    :closeDisplayGalleryMediaDisplaySetSpModal="
      closeDisplayGalleryMediaDisplaySetSp
    "
    v-model:align="GalleryItem.media_align"
    v-model:sort="GalleryItem.media_sort"
    v-model:width="GalleryItem.media_width"
    v-model:height="GalleryItem.media_height"
    v-model:link="GalleryItem.media_link"
    v-model:linkurl="GalleryItem.media_link_url"
    v-model:column_num="GalleryItem.media_column_num"
    v-model:margin="GalleryItem.media_margin"
    v-model:caption="GalleryItem.media_caption"
    v-model:frame_design="GalleryItem.media_frame_design"
    v-model:frame_color="GalleryItem.media_frame_color"
    v-model:shadow="GalleryItem.media_shadow"
    v-model:hover_expand="GalleryItem.media_hover_expand"
    v-model:hover_icon="GalleryItem.media_hover_icon"
    :Library="selectedMedia"
  />
</template>

<script>
import { mapActions } from "vuex";

import GalleryMediaSetModalComponent from "../../modals/GalleryMediaSetModalComponent.vue";
import GalleryMediaDisplaySetModalComponentSp from "../../modals/GalleryMediaDisplaySetModalComponentSp.vue";
import DatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import moment from "moment";
import imageCompression from "browser-image-compression";

export default {
  components: {
    GalleryMediaSetModalComponent,
    GalleryMediaDisplaySetModalComponentSp,
    DatePicker,
  },
  data() {
    return {
      img: [],
      displayGalleryMediaSet: false,
      displayGalleryMediaDisplaySetSp: false,
      library: [],
      createdmodel: null,
      captionModel: "",
      mediaAttachment: null,
      approval_auth_flg: false,
      create_auth_flg: false,
      selectedfolderid: null,
      GalleryItem: "",
      items: [
        { id: 0, text: "すべてのデータ" },
        { id: 1, text: "画像データ" },
        { id: 2, text: "動画データ" },
        { id: 3, text: "音声データ" },
        { id: 4, text: "テキストデータ" },
      ],
      data_id: null,
      selectedMedia: [],
      selectMediaFlg: false,
      folder: [],
      folder2: [],
      folderid: "",
    };
  },
  computed: {
    selectedFolder() {
      return this.$store.state.library.selectedFolder;
    },
    AddDateBegin() {
      return this.$store.state.library.AddDateBegin;
    },
    AddDateEnd() {
      return this.$store.state.library.AddDateEnd;
    },
    FileFormat() {
      return this.$store.state.library.FileFormat;
    },
    Caption() {
      return this.$store.state.library.Caption;
    },
  },
  watch: {
    selectedFolder() {
      this.getLibraryList();
      this.selectedfolderid = this.$store.state.library.selectedFolder;
      this.selectMediaFlg = false;
      this.selectedMedia = [];
      if (
        this.$store.state.library.selectedFolder != 0 &&
        this.$store.state.library.selectedFolder != -1
      ) {
        if (this.$store.state.library.selectedFolder) {
          axios
            .get("api/mediafolder/" + this.$store.state.library.selectedFolder)
            .then((res) => {
              this.GalleryItem = res.data;
            });
        }
      }
    },
    AddDateBegin() {
      this.getLibraryList();
    },
    AddDateEnd() {
      this.getLibraryList();
    },
    FileFormat() {
      this.getLibraryList();
    },
    Caption() {
      this.getLibraryList();
    },
  },
  methods: {
    ...mapActions("authority", ["fetchAllAuthority"]),

    //画面設定モーダルを閉じる
    closeDisplayGalleryMediaSet() {
      this.displayGalleryMediaSet = false;
      this.getLibraryList();
    },

    //画面表示設定モーダルを閉じる
    closeDisplayGalleryMediaDisplaySetSp() {
      this.selectMediaFlg = false;
      this.selectedMedia = [];
      this.displayGalleryMediaDisplaySetSp = false;
    },

    //画像一覧取得
    getLibraryList() {
      axios
        .get("/api/mediaAttachment", {
          params: {
            searchFileID: this.$store.state.library.selectedFolder,
            searchAddDateBegin: this.$store.state.library.AddDateBegin,
            searchAddDateEnd: this.$store.state.library.AddDateEnd,
            searchFileFormat: this.$store.state.library.FileFormat,
            searchCaption: this.$store.state.library.Caption,
          },
        })
        .then((res) => {
          this.library = res.data.mediaAttachment;
        });
    },

    FilterLibrary() {
      //投稿月検索
      if (this.createdmodel != null) {
        let start_year;
        let start_month;
        let end_year;
        let end_month;
        if (this.createdmodel.month == 11) {
          start_month = 12;
          start_year = this.createdmodel.year;
          end_month = 1;
          end_year = start_year + 1;
        } else {
          start_month = this.createdmodel.month + 1;
          start_year = this.createdmodel.year;
          end_month = start_month + 1;
          end_year = start_year;
        }
        let start = new Date(start_year + "-" + start_month + "-1");
        let end = new Date(end_year + "-" + end_month + "-1");
        start.setHours(start.getHours() + 9);
        end.setHours(end.getHours() + 9);
        this.$store.dispatch("library/setAddDateBegin", start);
        this.$store.dispatch("library/setAddDateEnd", end);
      } else {
        this.$store.dispatch("library/setAddDateBegin", null);
        this.$store.dispatch("library/setAddDateEnd", null);
      }
      //キャプション検索
      if (this.captionModel != "") {
        this.$store.dispatch("library/setCaption", this.captionModel);
      } else {
        this.$store.dispatch("library/setCaption", null);
      }
    },

    format(date) {
      return moment(date).format("yyyy/MM");
    },

    previewFormat(date) {
      return moment(date).format("yyyy/MM");
    },

    //画像追加
    async readImage() {
      let name = "";
      const inputImage = document.getElementById("image");
      if (inputImage.files.length === 0) {
        return;
      }

      this.file = inputImage.files[0];

      name = this.file.name;
      type = this.file.type;
      size = this.file.size;

      const options = {
        maxSizeMB: 1, // 最大ファイルサイズ
      };

      if (this.file.size > 1000000) {
        // 圧縮画像の生成
        this.file = await imageCompression(this.file, options);
        size = 1000000;
      }

      let flg = false;
      if (
        this.$store.state.library.selectedFolder == -1 ||
        this.$store.state.library.selectedFolder == ""
      ) {
        flg = true;
      }

      let formData = new FormData();
      const item = {
        media_folder_id: flg ? 1 : this.$store.state.library.selectedFolder,
        img_filename: name,
        img_fileformat: type,
        img_filesize: size,
        img_width: 0,
        img_height: 0,
      };
      formData.append("mediaAttachment", JSON.stringify(item));

      formData.append("file", this.file);

      axios
        .post("/api/mediaAttachment/register", formData, {
          headers: { "Content-type": "multipart/form-data" },
        })
        .then((res) => {
          this.getLibraryList();
        });
    },

    //画像編集画面に必要な情報をセット
    setItem(item) {
      this.mediaAttachment = item;
      this.folderid = item.media_folder_id;
    },

    //データの種類で検索
    dataidChange: function (id) {
      const postData = {
        id: id,
      };
      this.data_id = id;
      this.$store.dispatch("library/setFileFormat", this.data_id);
    },

    //ギャラリー作成ボタン押下
    GalleryToggle() {
      if (!this.selectMediaFlg) {
        this.selectMediaFlg = true;
      } else if (this.selectedMedia.length != 0) {
        this.displayGalleryMediaDisplaySetSp = true;
      }
    },

    //画像クリック
    clickMedia(item, selected) {
      if (!this.selectMediaFlg) {
        this.folder2 = [];
        axios.get("api/mediafolder").then((res) => {
          this.folder = res.data.mediaFolder;
          this.folder2[0] = {
            id: 1,
            parent_folder_id: 0,
            name: "未分類",
            kaisou: 1,
          };
          let number = 1;
          for (let i = 0; i < this.folder.length; i++) {
            if (this.folder[i].kaisou == 1) {
              this.folder2[number] = this.folder[i];
              number = number + 1;
              for (let j = 0; j < this.folder.length; j++) {
                if (this.folder[j].parent_folder_id == this.folder[i].id) {
                  this.folder2[number] = this.folder[j];
                  this.folder2[number].name = "　" + this.folder2[number].name;
                  number = number + 1;
                  for (let k = 0; k < this.folder.length; k++) {
                    if (this.folder[k].parent_folder_id == this.folder[j].id) {
                      this.folder2[number] = this.folder[k];
                      this.folder2[number].name =
                        "　　" + this.folder2[number].name;
                      number = number + 1;
                    }
                  }
                }
              }
            }
          }
        });
        this.setItem(item);
        this.displayGalleryMediaSet = true;
      } else if (!selected) {
        item.selected = true;
        item.selectNo = this.selectedMedia.length + 1;
        this.selectedMedia[this.selectedMedia.length] = item;
      } else {
        item.selected = false;
        for (let i = 0; i < this.selectedMedia.length; i++) {
          if (this.selectedMedia[i].id == item.id) {
            for (let j = i; j < this.selectedMedia.length; j++) {
              if (
                this.selectedMedia.length != 1 &&
                j < this.selectedMedia.length - 1
              ) {
                this.selectedMedia[j] = this.selectedMedia[j + 1];
                this.selectedMedia[j].selectNo =
                  this.selectedMedia[j].selectNo - 1;
              } else {
                this.selectedMedia.pop();
              }
            }
            break;
          }
        }
      }
    },
  },

  async mounted() {
    this.getLibraryList();
    let authority = await this.fetchAllAuthority();
    if (authority) {
      this.create_auth_flg = authority.create_auth_flg;
      this.approval_auth_flg = authority.approval_auth_flg;
    }
  },
};
</script>

<!-- 共通CSS -->
<style src="../css/dropdown.css"></style>
<style src="../css/common.css"></style>

<!-- 固有CSS -->
<style scoped>
@media (max-width: 640px) {
  /* ギャラリー作成ボタン（フォルダが選択した時） */
  .gallery-library-gallery-make-btn-sp {
    background-color: #69a5af;
    border: #69a5af 2px solid !important;
    font-weight: 600;
    letter-spacing: 1.3px;
  }
  .gallery-library-gallery-make-btn-sp .v-btn__content {
    color: #fff !important;
  }
  .gallery-library-gallery-make-btn-sp {
    color: #fff !important;
  }
  .gallery-library-gallery-make-btn-sp:hover {
    box-shadow: unset !important;
    background-color: #69a5af !important;
    color: #fff !important;
    opacity: 0.8 !important;
    transition: 0.4s;
  }

  /* 検索エリア */
  .filter-btn {
    background-color: #fff;
    border-radius: 10px;
    margin: 0 5px;
  }

  .gallery-library-search-area-sp {
    margin-top: 1rem;
    display: flex;
    justify-content: space-between;
  }
  .gallery-library-search-select-sp {
    border: 1px solid #ccc;
    width: 45%;
    margin: 0;
  }
  .gallery-library-search-datepicker-sp {
    border: 1px solid #ccc;
    width: 45%;
  }
  .gallery-library-search-sp {
    display: flex;
    align-items: center;
    width: 75%;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 4px;
    height: 2.5rem;
  }
  .gallery-library-search-input-sp {
    font-size: 16px !important;
    height: 2rem;
    border: none;
    outline: none;
    width: 53vw;
  }

  .gallery-library-search-icon-sp {
    background-color: transparent;
    border: none;
    outline: none;
    margin-right: 5px;
    color: rgba(0, 0, 0, 0.2);
  }

  .gallery-library-add-btn-sp {
    height: 2.5rem;
    margin-left: 30%;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* ライブラリ一覧 */
  .gallery-library-list-area-sp {
    overflow-y: auto;
    overflow-x: hidden;
    height: 55vh;
  }
  .gallery-library-img-margin-sp {
    margin: 0;
  }
  .gallery-library-img-sp {
    width: 22vw;
    transition-duration: 0.3s;
  }

  .gallery-library-img-id-sp {
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
  /* CRUDを実装したら、このCSSの削除することができます。 */
  .gallery-library-img-sample-sp {
    background-color: #f7f7f7;
  }

  .disable_btn {
    border-radius: 5px;
    background-color: transparent;
    color: rgb(172, 171, 171);
    border: solid 0.5px rgb(172, 171, 171);
  }
}
</style>