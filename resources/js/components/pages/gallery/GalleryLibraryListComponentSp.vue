<template>
  <!-- タイトル -->
  <div class="gallery-title-library">
    <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">ライブラリ</p>
    <button
      class="btn white-btn"
      type="button"
      @click="displayGalleryMediaDisplaySetSp = true"
    >
      ギャラリーを作成
    </button>
  </div>

  <!-- 検索エリア -->
  <!-- セレクトボックス -->
  <div class="gallery-library-search-area-sp">
    <v-select
      class="filter-btn gallery-library-search-select-sp"
      :items="['画像データ', '動画データ', '音声データ', 'テキストデータ']"
      hide-details="false"
      label="すべてのデータ"
    />
    <DatePicker
      class=" filter-btn gallery-library-search-datepicker-sp"
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
    <div class="samb-box">
        <label for="image" class="green-btn_noTransform px-2 py-1 gallery-library-add-btn-sp">追加</label>
        <input type="file" id="image" accept="image/*" @change="readImage">
    </div>
  </div>

  <!-- 仕切り線 -->
  <div class="gallery-horizontal-divider"></div>

  <!-- ライブラリ一覧 -->
  <div class="gallery-library-list-area-sp">
    <v-row>
      <v-col
        v-for="(item,index) in library"
        :key="index"
        class="d-flex child-flex gallery-library-img-margin-sp"
        cols="4"
      >
        <div class="btn-group" @click="displayGalleryMediaSet = true">
          <img
            :src=" 'data:image/png;base64,' + item.img_path"
            aspect-ratio="1"
            cover
            :class="
              item.img_path
                ? 'gallery-library-img-sp bg-grey-lighten-2'
                : 'gallery-library-img-sample-sp bg-grey-lighten-2 gallery-library-img-sp'
            "
          >
            <!-- 写真ごとローディングアニメ -->
            <!-- <template v-slot:placeholder>
            <v-row class="fill-height ma-0" align="center" justify="center">
              <v-progress-circular
                indeterminate
                color="grey-lighten-5"
              ></v-progress-circular>
            </v-row>
          </template> -->
        </div>
      </v-col>
    </v-row>
  </div>

  <!-- 画像設定モーダル -->
  <gallery-media-set-modal-component
    :modelValue="displayGalleryMediaSet"
    @update:modelValue="displayGalleryMediaSet = $event"
    :closeDisplayGalleryMediaSetModal="closeDisplayGalleryMediaSet"
  />

  <!-- 画像表示設定モーダル -->
  <gallery-media-display-set-modal-component-sp
    :modelValue="displayGalleryMediaDisplaySetSp"
    @update:modelValue="displayGalleryMediaDisplaySetSp = $event"
    :closeDisplayGalleryMediaDisplaySetSpModal="
      closeDisplayGalleryMediaDisplaySetSp
    "
  />
</template>

<script>
import GalleryMediaSetModalComponent from "../../modals/GalleryMediaSetModalComponent.vue";
import GalleryMediaDisplaySetModalComponentSp from "../../modals/GalleryMediaDisplaySetModalComponentSp.vue";
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';

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
      displayGalleryMediaDisplaySet: false,
      library: [],
      createdmodel: null,
      captionModel: "",
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
    },
    AddDateBegin(){
      this.getLibraryList();
    },
    AddDateEnd(){
      this.getLibraryList();
    },
    FileFormat(){
      this.getLibraryList();
    },
    Caption(){
      this.getLibraryList();
    },
  },
  methods: {
    //画面設定モーダルを閉じる
    closeDisplayGalleryMediaSet() {
      this.displayGalleryMediaSet = false;
    },

    //画面表示設定モーダルを閉じる
    closeDisplayGalleryMediaDisplaySetSp() {
      this.displayGalleryMediaDisplaySetSp = false;
    },

     //画像一覧取得
    getLibraryList() {
    axios
      .get("/api/mediaAttachment", {
        params: {
          searchFileID:
            this.$store.state.library.selectedFolder,
          searchAddDateBegin:
            this.$store.state.library.AddDateBegin,
          searchAddDateEnd:
            this.$store.state.library.AddDateEnd,
          searchFileFormat:
            this.$store.state.library.FileFormat,
          searchCaption:
            this.$store.state.library.Caption,
        },
      })
      .then((res) => {
        this.library = res.data.mediaAttachment
      });
    },

    FilterLibrary(){
      //投稿月検索
      if(this.createdmodel != null){
        let start_year
        let start_month
        let end_year
        let end_month
        if(this.createdmodel.month == 11){
          start_month = 12;
          start_year = this.createdmodel.year;
          end_month = 1;
          end_year = start_year + 1
        }else{
          start_month = this.createdmodel.month + 1;
          start_year = this.createdmodel.year;
          end_month = start_month + 1;
          end_year = start_year;
        }
        let start = new Date(start_year + "-" + start_month + "-1")
        let end = new Date(end_year + "-" + end_month + "-1")
        start.setHours(start.getHours() + 9);
        end.setHours(end.getHours() + 9);
        this.$store.dispatch("library/setAddDateBegin", start);
        this.$store.dispatch("library/setAddDateEnd", end);
      }else{
        this.$store.dispatch("library/setAddDateBegin", null);
        this.$store.dispatch("library/setAddDateEnd", null);
      }
      //キャプション検索
      if(this.captionModel != ""){
        this.$store.dispatch("library/setCaption",this.captionModel);
      }else{
        this.$store.dispatch("library/setCaption",null);
      }
    },

    format(date) {
      return moment(date).format('yyyy/MM');
    },

    previewFormat(date) {
      return moment(date).format('yyyy/MM');
    },

     //画像追加
    readImage() {
      let name ="";
      const inputImage = document.getElementById('image');
      if (inputImage.files.length === 0) {
        return;
      }

      this.file = inputImage.files[0];

      name = this.file.name;

      const options = {
        maxSizeMB: 1, // 最大ファイルサイズ
      };

      if(this.file.size > 1024*1024){
        // 圧縮画像の生成
        this.file = imageCompression(this.file, options); 
      }

      let flg = false;
      if(this.$store.state.library.selectedFolder == -1 || this.$store.state.library.selectedFolder == ""){
        flg = true;
      }
      
      let formData = new FormData();
      const item = {
        media_folder_id: flg? 1 :this.$store.state.library.selectedFolder,
        img_filename: name,
        img_path: this.file,
        img_fileformat: this.file.type,
        img_filesize:this.file.size,
        img_width:0,
        img_height:0,
      };
      formData.append("mediaAttachment", JSON.stringify(item));

      formData.append("file", this.file);

      axios.post('/api/mediaAttachment/register',
        formData,
        { headers: { "Content-type": "multipart/form-data", }}
      ).then((res) => {
        this.getLibraryList();
      });
    },
    
  },

  async mounted() {
    this.getLibraryList();
  },
};
</script>

<!-- 共通CSS -->
<style src="../css/dropdown.css"></style>
<style src="../css/common.css"></style>

<!-- 固有CSS -->
<style scoped>
@media (max-width: 640px) {
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
    height: 3.5rem;
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
    width: 16%;
    height: auto;
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
  /* CRUDを実装したら、このCSSの削除することができます。 */
  .gallery-library-img-sample-sp {
    background-color: #f7f7f7;
  }
}
</style>