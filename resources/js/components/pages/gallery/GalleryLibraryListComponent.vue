<template>
  <v-container>
    <!-- タイトル -->
    <div class="gallery-title-library">
      <v-row>
        <v-col cols="6" class="d-flex">
          <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">ライブラリ</p>
          <button
            class="green-btn_noTransform px-2 py-1 gallery-library-add-btn"
            type="button"
          >
            追加
          </button>
        </v-col>
        <v-col cols="6" class="d-flex justify-end">
          <button class="btn white-btn" type="button">ギャラリーを作成</button>
        </v-col>
      </v-row>
    </div>

    <!-- 検索エリア -->
    <div class="gallery-library-search-area">
      <v-row>
        <v-col cols="6" class="d-flex justify-start">
          <v-select
            class="filter-btn gallery-library-search-select"
            :items="['AAA', 'BBB', 'CCC', 'DDD']"
            hide-details="false"
            label="すべてのデータ"
          />
          <v-select
            class="filter-btn gallery-library-search-select"
            :items="['AAA', 'BBB', 'CCC', 'DDD']"
            hide-details="false"
            label="すべてのデータ"
          />
        </v-col>
        <v-col cols="6" class="d-flex justify-end">
          <div class="gallery-library-search">
            <button type="button" class="gallery-library-search-icon">
              <v-icon>mdi-magnify</v-icon>
            </button>
            <div class="d-flex">
              <input
                class="gallery-library-search-input"
                type="search"
                maxlength="30"
                hide-details="false"
              />
            </div>
          </div>
        </v-col>
      </v-row>
    </div>

    <!-- 仕切り線 -->
    <div class="gallery-horizontal-divider"></div>

    <!-- ライブラリ一覧 -->
    <div class="gallery-library-list-area">
      <v-row>
        <v-col
          v-for="n in 30"
          :key="n"
          class="d-flex child-flex gallery-library-img-margin"
        >
          <div class="btn-group" @click="displayGalleryMediaSet = true">
            <v-img
              src=""
              aspect-ratio="1"
              cover
              :class="
                img
                  ? 'gallery-library-img-sample bg-grey-lighten-2 gallery-library-img'
                  : 'gallery-library-img-sample bg-grey-lighten-2 gallery-library-img'
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
  </v-container>

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
      img: [],
      displayGalleryMediaSet: true,
    };
  },
  methods: {
    //画面設定モーダルを閉じる
    closeDisplayGalleryMediaSet() {
      this.displayGalleryMediaSet = false;
      console.log("Close BTN");
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
@media (max-width: 900px) {
  .sp_disable {
    display: none;
  }
}

@media (min-width: 901px) {
  .pc_disable {
    display: none;
  }
}

/* タイトルエリア（追加ボタン） */
.gallery-library-add-btn {
  margin-left: 20%;
  height: fit-content;
}

/* 検索エリア */
.filter-btn {
  background-color: #fff;
  border-radius: 10px;
  margin: 0 5px;
}
.gallery-library-search-area {
  display: flex;
  align-items: center;
}
.gallery-library-search-select {
  border: 1px solid #ccc;
  width: 45%;
}
.gallery-library-search {
  display: flex;
  align-items: center;
  width: 45%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 4px;
  margin-left: 5%;
  height: 3.5rem;
}
.gallery-library-search-input {
  font-size: 16px !important;
  height: 2rem;
  border: none;
  outline: none;
  width: 10.5vw;
}
@media (min-width: 1450px) {
  .gallery-library-search-input {
    width: 11.5vw;
  }
}
.gallery-library-search-icon {
  background-color: transparent;
  border: none;
  outline: none;
  margin-right: 5px;
  color: rgba(0, 0, 0, 0.2);
}

/* ライブラリ一覧 */
.gallery-library-list-area {
  overflow-y: auto;
  overflow-x: hidden;
  height: 55vh;
}
@media (min-width: 1450px) {
  .gallery-library-list-area {
    height: 57vh;
  }
}
.gallery-library-img-margin {
  margin: auto;
}
.gallery-library-img {
  width: 10vw;
  transition-duration: 0.3s;
  cursor: pointer;
}
@media (min-width: 1450px) {
  .gallery-library-img {
    width: 8.9vw;
  }
}
.gallery-library-img:hover {
  transform: scale(1.1);
}

/* CRUDを実装したら、このCSSの削除することができます。 */
.gallery-library-img-sample {
  background-color: #f7f7f7;
}
</style>