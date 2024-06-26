<template>
  <!-- タイトル -->
  <div class="gallery-title-library">
    <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">ライブラリ</p>
    <button
      :class="[
        selectedfolderid == null ||
        selectedfolderid == -1 ||
        selectedfolderid == 1
          ? 'btn disable-btn gallery-btn-font-12-sp'
          : selectMediaFlg
          ? 'btn gallery-library-gallery-make-btn-sp gallery-btn-font-12-sp'
          : 'btn white-btn gallery-btn-font-12-sp',
      ]"
      type="button"
      :disabled="
        selectedfolderid == null ||
        selectedfolderid == -1 ||
        selectedfolderid == 1
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
      v-model="data_id"
      hide-details="false"
      :label="this.data_id === null ? '全てのデータ' : ''"
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
        for="uploadFile"
        class="green-btn_noTransform px-2 py-1 gallery-library-add-btn-sp"
        >追加</label
      >
      <input
        type="file"
        id="uploadFile"
        accept="image/*,video/*,audio/*,text/*"
        @change="readUploadFile"
      />
    </div>
  </div>
  <div>
    <!-- 提示メッセージ -->
    <validation-hints :hints="validationHints" v-if="validationHints" />
  </div>

  <!-- 仕切り線 -->
  <div class="gallery-horizontal-divider"></div>

  <!-- ライブラリ一覧 -->
  <div class="gallery-library-list-area-sp" ref="scrollarea">
    <v-row>
      <!-- フォルダ名の表示 -->
      <v-col
        v-if="selectedFolder >= 2"
        cols="12"
        class="gallery-library-folder-name py-0"
      >
        <div>
          <p>【 {{ (getFolderName(selectedFolder), folderName) }} 】</p>
        </div>
        <div
          v-if="hasShortCode"
          class="d-flex gallery-library-shortCode"
          @click="copyTextToClipboard"
        >
          <p>
            ショートコード：[gallery id="{{ selectedFolder }}"]
            <span class="mdi mdi-content-copy"></span>
          </p>
          <p v-if="isCopy" class="mb-0 mx-auto gallery-library-copySuccess">
            コピーしました！
          </p>
        </div>
      </v-col>
      <!-- 画像一覧の表示 -->
      <v-col
        v-for="(item, index) in library"
        :key="index"
        class="d-flex child-flex gallery-library-img-margin-sp"
        cols="4"
      >
        <div class="btn-group" @click="clickMedia(item, item.selected)">
          <v-img
            :src="item.url"
            aspect-ratio="1"
            cover
            :class="
              item.img_fileformat.split('/')[0] == 'image' ||
              item.img_fileformat.split('/')[0] == 'text'
                ? 'gallery-library-img-sp bg-grey-lighten-2'
                : 'gallery-library-not-img-sp bg-grey-lighten-2'
            "
            :fileName="item.img_filename"
          >
            <p
              v-show="
                item.img_fileformat.split('/')[0] == 'image' ||
                item.img_fileformat.split('/')[0] == 'text'
              "
              v-if="selectMediaFlg && item.selected"
              class="gallery-library-img-id-sp"
            >
              {{ item.selectNo }}
            </p>
          </v-img>
          <p>
            データタイプ：{{ datenamed(item.img_fileformat.split("/")[0]) }}　
          </p>
          <p>
            投稿日：{{
              item.created_at.slice(0, 10).replace("-", "/").replace("-", "/")
            }}　
          </p>
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
import { mapActions, mapState } from "vuex";

import GalleryMediaSetModalComponent from "../../modals/GalleryMediaSetModalComponent.vue";
import GalleryMediaDisplaySetModalComponentSp from "../../modals/GalleryMediaDisplaySetModalComponentSp.vue";
import DatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import moment from "moment";
import imageCompression from "browser-image-compression";
import ValidationHints from "../../ValidationHints";

export default {
  components: {
    GalleryMediaSetModalComponent,
    GalleryMediaDisplaySetModalComponentSp,
    DatePicker,
    ValidationHints,
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
        { id: 0, text: "全てのデータ" },
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
      count: 0,
      folderName: "",
      hasShortCode: false,
      isCopy: false,
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
    // 提示メッセージ
    ...mapState({
      validationHints: (state) => state.gallery.galleryHintMessagesInLibrary,
    }),
  },
  watch: {
    async selectedFolder() {
      this.$store.dispatch("library/setAddDateBegin", null);
      this.$store.dispatch("library/setAddDateEnd", null);
      this.$store.dispatch("library/setCaption", null);
      this.$store.dispatch("library/setFileFormat", null);
      this.createdmodel = null;
      this.captionModel = "";
      this.count = 0;
      this.dataidChange(0);
      await this.getLibraryList();
      this.selectedfolderid = this.$store.state.library.selectedFolder;
      this.selectMediaFlg = false;
      this.selectedMedia = [];
      if (
        this.$store.state.library.selectedFolder != 1 &&
        this.$store.state.library.selectedFolder != -1
      ) {
        if (this.$store.state.library.selectedFolder) {
          await axios
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
    closeDisplayGalleryMediaSet(isMoved) {
      this.displayGalleryMediaSet = false;
      this.selectedMedia = [];
      this.getLibraryList(isMoved);
    },

    //画面表示設定モーダルを閉じる
    closeDisplayGalleryMediaDisplaySetSp() {
      this.selectMediaFlg = false;
      this.displayGalleryMediaDisplaySetSp = false;
    },

    //画像一覧取得
    async getLibraryList(isMoved) {
      await axios
        .get("/api/mediaAttachment", {
          params: {
            searchFileID: this.$store.state.library.selectedFolder,
            searchAddDateBegin: this.$store.state.library.AddDateBegin,
            searchAddDateEnd: this.$store.state.library.AddDateEnd,
            searchFileFormat: this.$store.state.library.FileFormat,
            searchCaption: this.$store.state.library.Caption,
            counter: this.count,
          },
        })
        .then((res) => {
          this.library = res.data.mediaAttachment;
          let folderId = this.$store.state.library.selectedFolder;
          let item = "";

          // ファイルを移動した場合
          if (isMoved && isMoved.length != 0) {
            axios
              .get("api/mediafolder/getGallery/" + folderId)
              .then((res) => {
                // ギャラリーを作成された場合
                this.selectedMedia = res.data;
                let getMediaResult = this.selectedMedia;
                for (let i = 0; i < getMediaResult.length; i++) {
                  item = getMediaResult[i];
                  // 画像が存在しない
                  if (!this.library.some((library) => library.id === item.id)) {
                    var hintMsg = [
                      "移動したファイルをギャラリーから削除しました",
                    ];
                    this.$store.dispatch(
                      "gallery/setGalleryHintMessagesLibrary",
                      hintMsg
                    );
                  }
                }
              })
              .catch((error) => {
                console.log(error);
                // ギャラリーを作成したことがない場合、APIから404を返却
                if (error.response.status == 404) {
                  this.$store.dispatch(
                    "gallery/setGalleryHintMessagesLibrary",
                    hintMsg
                  );
                }
              });
          }

          // 検索結果は0件の場合、提示文言を表示
          const searchByFileFormat = this.$store.state.library.FileFormat;
          const searchByDate = this.$store.state.library.AddDateBegin;
          const searchByCaption = this.$store.state.library.Caption;
          if (this.library.length == 0) {
            if (
              // ファイル形式のみ選択
              searchByFileFormat &&
              searchByFileFormat != 0 &&
              !searchByDate &&
              !searchByCaption
            ) {
              var hintMsg = ["選択したファイル形式の検索結果はありません。"];
              this.$store.dispatch(
                "gallery/setGalleryHintMessagesLibrary",
                hintMsg
              );
            } else if (
              // 投稿月のみ選択
              searchByFileFormat == 0 &&
              searchByDate &&
              !searchByCaption
            ) {
              var hintMsg = ["選択した投稿月の検索結果はありません。"];
              this.$store.dispatch(
                "gallery/setGalleryHintMessagesLibrary",
                hintMsg
              );
            } else if (
              // キーワードのみ入力
              searchByFileFormat == 0 &&
              !searchByDate &&
              searchByCaption
            ) {
              var hintMsg = ["入力したキーワードの検索結果はありません。"];
              this.$store.dispatch(
                "gallery/setGalleryHintMessagesLibrary",
                hintMsg
              );
            } else if (
              // 該当フォルダ内画像はなしの場合
              (this.library.length == 0 &&
                searchByFileFormat == null &&
                searchByDate == null &&
                searchByCaption == null) ||
              (this.library.length == 0 &&
                searchByFileFormat == 0 &&
                searchByDate == null &&
                searchByCaption == null)
            ) {
              var hintMsg = ["ファイルをアップロードしてください。"];
              this.$store.dispatch(
                "gallery/setGalleryHintMessagesLibrary",
                hintMsg
              );
            } else {
              var hintMsg = ["条件を満たす検索結果はありません。"];
              this.$store.dispatch(
                "gallery/setGalleryHintMessagesLibrary",
                hintMsg
              );
            }
          } else {
            // 提示文言を初期化する
            this.$store.dispatch("gallery/setGalleryHintMessagesLibrary", "");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // 検索処理
    FilterLibrary() {
      //投稿月検索
      if (this.createdmodel != null) {
        let start = moment(this.createdmodel).format("yyyy/MM/01");
        let end = moment(this.createdmodel).endOf("month").format("YYYY/MM/DD");

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
    async readUploadFile() {
      let name;
      let type;
      let size;
      const uploadFile = document.getElementById("uploadFile");
      if (uploadFile.files.length === 0) {
        return;
      }

      this.file = uploadFile.files[0];

      name = this.file.name;
      type = this.file.type;
      size = this.file.size;

      let fileType = type.split("/")[0];

      // 画像ファイルが１MBを超える場合、圧縮する
      const options = {
        maxSizeMB: 1, // 最大ファイルサイズ
      };
      if (fileType == "image") {
        if (this.file.size > 1000000) {
          // 圧縮画像の生成
          this.file = await imageCompression(this.file, options);
          size = 1000000;
        }

        // 音声・画像ファイルが２MB以内
      } else if (fileType == "audio" || fileType == "video") {
        if (this.file.size > 2000000) {
          var hintMsg = ["2MB以内のファイルをアップロードしてください。"];
          this.$store.dispatch(
            "gallery/setGalleryHintMessagesLibrary",
            hintMsg
          );
          return;
        }
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
        img_width: "0",
        img_height: "0",
      };
      formData.append("mediaAttachment", JSON.stringify(item));
      formData.append("file", this.file);

      // 画像ファイルの保存
      if (fileType == "image") {
        // 画像情報を取得してDBに保存する
        const reader = new FileReader();
        reader.onload = (event) => {
          const img = new Image();
          img.onload = () => {
            // 画像のサイズ
            item.img_width = img.width;
            item.img_height = img.height;

            axios
              .post("/api/mediaAttachment/register", formData, {
                headers: { "Content-type": "multipart/form-data" },
              })
              .then((res) => {
                this.getLibraryList();
                this.$store.dispatch("gallery/setGalleryCreate", "1");
              });
          };
          img.src = event.target.result;
        };
        reader.readAsDataURL(this.file);

        // テキストファイルの保存
      } else if (fileType == "text") {
        const reader = new FileReader();
        reader.onloadend = (event) => {
          const textContent = event.target.result;
          let thumbnailWidth = "";
          let thumbnailHeight = "";

          // テキストファイルのサムネイルを作成
          const lines = [];
          const words = textContent.split("\n");
          let maxLineWidth = 0;
          let totalHeight = 0;
          const fontSize = 14;
          const fontFamily = "Arial";

          // canvas要素を作成
          const canvas = document.createElement("canvas");
          // 2Dコンテキストを取得
          const ctx = canvas.getContext("2d");
          // フォントスタイルとサイズを設定
          ctx.font = `${fontSize}px ${fontFamily}`;

          words.forEach((word) => {
            // テキストの幅を測定
            const metrics = ctx.measureText(word);
            const lineWidth = metrics.width;

            if (lineWidth > maxLineWidth) {
              // 最大行幅を更新
              maxLineWidth = lineWidth;
            }
            // 総高さを更新
            totalHeight += fontSize + 4;
          });

          // 解像度の倍率
          const scaleFactor = 2;
          // canvasの幅を設定（最大行幅と余白を考慮）
          canvas.width = (maxLineWidth + 20) * scaleFactor;
          // canvasの高さを設定（4:3の比率で計算）
          canvas.height = ((maxLineWidth + 20) / 4) * 3 * scaleFactor;
          // canvasをスケーリング
          ctx.scale(scaleFactor, scaleFactor);
          // サムネイル背景色を白に設定
          ctx.fillStyle = "#ffffff";
          // 背景を塗りつぶす
          ctx.fillRect(0, 0, canvas.width, canvas.height);
          // フォントスタイルとサイズを再設定
          ctx.font = `${fontSize}px ${fontFamily}`;
          // テキストの水平揃えを左に設定
          ctx.textAlign = "left";
          // テキストのベースラインを上端に設定
          ctx.textBaseline = "top";
          // テキストの色を黒に設定
          ctx.fillStyle = "#000000";

          let textY = 10;
          words.forEach((word) => {
            // テキストを描画
            ctx.fillText(word, 10, textY);
            // テキストの垂直位置を更新
            textY += fontSize + 4;
          });
          // canvasをBase64エンコードした画像データURLに変換
          const thumbnailText = canvas.toDataURL("image/png").split(",")[1];
          // サムネイルのサイズ
          item.img_width = canvas.width;
          item.img_height = canvas.height;
          // サムネイルデータをフォームデータに追加
          formData.append("thumbnailText", thumbnailText);

          axios
            .post("/api/mediaAttachment/register", formData, {
              headers: { "Content-type": "multipart/form-data" },
            })
            .then((res) => {
              this.getLibraryList();
              this.$store.dispatch("gallery/setGalleryCreate", "1");
            })
            .catch((error) => {
              console.error("Error uploading text file:", error);
            });
        };

        reader.readAsText(this.file);

        // 音声.動画ファイルの保存
      } else if (fileType == "audio" || fileType == "video") {
        const reader = new FileReader();
        reader.onloadend = (event) => {
          axios
            .post("/api/mediaAttachment/register", formData, {
              headers: { "Content-type": "multipart/form-data" },
            })
            .then((res) => {
              this.getLibraryList();
              this.$store.dispatch("gallery/setGalleryCreate", "1");
            })
            .catch((error) => {
              console.error("Error uploading text file:", error);
            });
        };

        reader.readAsDataURL(this.file);
      }

      // 提示文言が表示された場合、初期化する
      if (this.$store.state.gallery.galleryHintMessagesInLibrary) {
        this.$store.dispatch("gallery/setGalleryHintMessagesLibrary", "");
      }
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
      // 該当フォルダに画像は0件の場合
      if (this.library.length == 0) {
        var hintMsg = ["ファイルをアップロードしてください。"];
        this.$store.dispatch("gallery/setGalleryHintMessagesLibrary", hintMsg);
      } else {
        // 該当フォルダに画像は1件以上ある場合
        if (!this.selectMediaFlg) {
          this.selectMediaFlg = true;

          // ギャラリー作成したかしないかを確認する
          let folderId = this.$store.state.library.selectedFolder;
          let item = "";
          // ギャラリー作成Jsonファイルを取得
          axios
            .get("api/mediafolder/getGallery/" + folderId)
            .then((res) => {
              // ギャラリーを作成された場合
              this.hasShortCode = true; // ショートコードの表示
              this.selectedMedia = res.data;
              let selectedMediaResult = this.selectedMedia;
              for (let i = 0; i < selectedMediaResult.length; i++) {
                item = selectedMediaResult[i];

                // 画像が存在しない
                if (!this.library.some((library) => library.id === item.id)) {
                  // selectedMedia配列から削除する
                  this.selectedMedia = this.selectedMedia.filter(
                    (selectedMedia) => selectedMedia.id !== item.id
                  );

                  // 画像が存在する
                } else {
                  this.clickMedia(item);
                }
              }
              // selectedMediaの画像が全て削除された場合
              if (this.selectedMedia.length == 0) {
                var hintMsg = [
                  "ギャラリーに表示する画像の順番を選択してください。",
                ];
                this.$store.dispatch(
                  "gallery/setGalleryHintMessagesLibrary",
                  hintMsg
                );
              }
            })
            .catch((error) => {
              console.log(error);
              // ギャラリーを作成したことがない場合、APIから404を返却
              if (error.response.status == 404) {
                // 該当フォルダに画像は1件以上存在し、選択しない場合
                var hintMsg = [
                  "ギャラリーに表示する画像の順番を選択してください。",
                ];
                this.$store.dispatch(
                  "gallery/setGalleryHintMessagesLibrary",
                  hintMsg
                );
              }
            });
        } else if (this.selectedMedia.length != 0) {
          this.displayGalleryMediaDisplaySetSp = true;
          // 提示文言を初期化する
          this.$store.dispatch("gallery/setGalleryHintMessagesLibrary", "");
        }
      }
    },

    //画像クリック
    clickMedia(item, selected) {
      const fileType = item.img_fileformat.split("/")[0];

      // 画像のみ選択できるという予想（fileType == "image"）
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
            if (this.folder[i].parent_folder_id == 0) {
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
      } else if (
        (!selected && fileType == "image") ||
        (!selected && fileType == "text")
      ) {
        // ギャラリーに選択された画像の順番を取得して表示する
        if (
          this.selectedMedia.some(
            (selectedMedia) => selectedMedia.id === item.id
          )
        ) {
          const index = this.selectedMedia.indexOf(item);
          if (index != -1) {
            for (let i = 0; i < this.library.length; i++) {
              if (this.library[i].id == item.id) {
                this.library[i].selected = true;
                this.library[i].selectNo = index + 1;
              }
            }
          }
        } else if (fileType == "image" || fileType == "text") {
          // ギャラリーに選択されない画像は新番号をあげる
          item.selected = true;
          item.selectNo = this.selectedMedia.length + 1;
          this.selectedMedia.push(item);
        }

        // 画像を選択した場合、提示文言を初期化する
        this.$store.dispatch("gallery/setGalleryHintMessagesLibrary", "");
      } else if (fileType == "image" || fileType == "text") {
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

                // ギャラリーで選択された画像を選択しない場合のselectNo処理
                for (let i = 0; i < this.library.length; i++) {
                  for (let j = 0; j < this.selectedMedia.length; j++) {
                    if (this.library[i].id == this.selectedMedia[j].id) {
                      const index = this.selectedMedia.indexOf(
                        this.library[i].id
                      );
                      this.library[i].selectNo = this.selectedMedia[j].selectNo;
                    }
                  }
                }
              } else {
                this.selectedMedia.pop();
              }
            }

            // 該当フォルダに画像は1件以上存在し、選択しない場合
            if (this.selectedMedia.length == 0) {
              var hintMsg = [
                "ギャラリーに表示する画像の順番を選択してください。",
              ];
              this.$store.dispatch(
                "gallery/setGalleryHintMessagesLibrary",
                hintMsg
              );
            }
            break;
          }
        }
      }
    },

    // フォルダ名を取得
    getFolderName(folderId) {
      // フォルダ名を取得して表示する
      if (folderId && folderId != -1 && folderId != 1) {
        axios
          .get("/api/mediafolder/" + folderId)
          .then((res) => {
            this.folderName = res.data.name;
          })
          .catch((error) => {
            console.error(error);
          });
      }
      if (this.selectedMedia.length == 0) {
        // ショートコード表示を初期化
        this.hasShortCode = false;
        this.isCopy = false;
      }
    },
    // クリックとコピーする
    copyTextToClipboard() {
      navigator.clipboard
        .writeText(
          '[gallery id="' + this.$store.state.library.selectedFolder + '"]'
        )
        .then(() => {
          this.isCopy = true;
        })
        .catch(() => {
          console.error("Copy Error");
        });
    },

    datenamed(val) {
      if (val == "image") {
        return "画像";
      } else if (val == "video") {
        return "動画";
      } else if (val == "text") {
        return "テキスト";
      } else if (val == "audio") {
        return "音声";
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
    const reference = this.$refs.scrollarea;
    const self = this;
    reference.onscroll = function () {
      const element = self.$refs.scrollarea;
      const clientHeight = element.clientHeight;
      const scrollHeight = element.scrollHeight;
      if (scrollHeight - (clientHeight + element.scrollTop) < 1) {
        self.count += 15;
        self.getLibraryList();
      }
    };
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
  .gallery-btn-font-12-sp {
    font-size: 12px;
  }
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
    margin-left: 24%;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* フォルダ名の表示 */
  .gallery-library-folder-name {
    color: #69a4af;
    line-height: 1.7rem;
    color: #69a4af;
  }
  .gallery-library-folder-name p {
    margin-top: 0.8rem;
    margin-right: -0.5rem;
    background-color: #f5f9fa;
    border-right: 3px solid #f5f9fa;
    border-left: 3px solid #f5f9fa;
    border-radius: 5px;
    color: #69a4af;
    font-size: 13px;
    width: max-content;
    font-weight: 600;
  }
  .gallery-library-shortCode {
    cursor: pointer;
  }
  .gallery-library-copySuccess {
    color: #8f8f8f !important;
    font-size: 10px !important;
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
  /* 画像ファイル以外の表示 */
  .gallery-library-not-img-sp {
    background-color: #f7f7f7;
    position: relative;
    width: 22vw;
    transition-duration: 0.3s;
    cursor: pointer;
  }
  .gallery-library-not-img-sp::after {
    content: attr(fileName);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    color: #9f9f9f;
    word-break: break-all;
  }
  .disable_btn {
    border-radius: 5px;
    background-color: transparent;
    color: rgb(172, 171, 171);
    border: solid 0.5px rgb(172, 171, 171);
  }

  .btn-group {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 1rem;
    flex-direction: column;
  }
}
</style>