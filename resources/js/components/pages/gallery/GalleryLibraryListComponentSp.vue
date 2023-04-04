<template>
  <!-- タイトル -->
  <div class="gallery-title-library">
    <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">ライブラリ</p>
    <button class="btn white-btn" type="button">ギャラリーを作成</button>
  </div>

  <!-- 検索エリア -->
  <!-- セレクトボックス -->
  <div class="gallery-library-search-area-sp">
    <v-select
      class="filter-btn gallery-library-search-select-sp"
      :items="['AAA', 'BBB', 'CCC', 'DDD']"
      hide-details="false"
      label="すべてのデータ"
    />
    <v-select
      class="filter-btn gallery-library-search-select-sp ml-2"
      :items="['AAA', 'BBB', 'CCC', 'DDD']"
      hide-details="false"
      label="すべてのデータ"
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
        />
      </div>
    </div>
    <button
      class="green-btn_noTransform px-2 py-1 gallery-library-add-btn-sp"
      type="button"
    >
      追加
    </button>
  </div>

  <!-- 仕切り線 -->
  <div class="gallery-horizontal-divider"></div>

  <!-- ライブラリ一覧 -->
  <div class="gallery-library-list-area-sp">
    <v-row>
      <v-col
        v-for="n in 30"
        :key="n"
        class="d-flex child-flex gallery-library-img-margin-sp"
      >
        <div class="btn-group" @click="displayGalleryMediaSet = true">
          <v-img
            src=""
            aspect-ratio="1"
            cover
            :class="
              img
                ? 'gallery-library-img-sample-sp bg-grey-lighten-2 gallery-library-img-sp'
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
  />
</template>

<script>
import GalleryMediaSetModalComponent from "../../modals/GalleryMediaSetModalComponent.vue";

export default {
  components: { GalleryMediaSetModalComponent },
  data() {
    return {
      displayGalleryMediaSet: false,
    };
  },
  methods: {
    //画面設定モーダルを閉じる
    closeDisplayGalleryMediaSet() {
      this.displayGalleryMediaSet = false;
    },
  },

  async mounted() {},
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
    margin: auto;
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