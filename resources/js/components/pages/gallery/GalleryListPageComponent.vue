<template>
  <v-container>
    <title-component class="sp_disable" name="ギャラリー編集" />
    <sp-gallery-title-component class="pc_disable" name="ギャラリー編集" />
    <!-- PC -->
    <div class="gallery-flex">
      <!-- フォルダ管理 -->
      <v-card class="main-cont p-3 gallery-vCard-relative">
        <gallery-folder-list-component v-if="!moblieFlg()" />
      </v-card>
      <!-- ライブラリ -->
      <v-card class="main-cont p-3">
        <gallery-library-list-component v-if="!moblieFlg()" />
      </v-card>
    </div>

    <!-- SP -->
    <div class="gallery-flex-sp">
      <!-- フォルダ管理 -->
      <v-card class="main-cont p-3 gallery-vCard-relative">
        <gallery-folder-list-component-sp v-if="moblieFlg()" />
      </v-card>

      <!-- ライブラリ -->
      <v-card class="main-cont p-3">
        <!-- <gallery-library-list-component-sp v-if="moblieFlg()" /> -->
      </v-card>
    </div>
  </v-container>
</template>

<script>
import TitleComponent from "../../common/TitleComponent.vue";
import SpGalleryTitleComponent from "../../common/SpGalleryTitleComponent.vue";
import GalleryFolderListComponent from "../gallery/GalleryFolderListComponent.vue";
import GalleryFolderListComponentSp from "../gallery/GalleryFolderListComponentSp.vue";
import GalleryLibraryListComponent from "../gallery/GalleryLibraryListComponent.vue";
// import GalleryLibraryListComponentSp from "../gallery/GalleryLibraryListComponentSp.vue";

export default {
  components: {
    TitleComponent,
    SpGalleryTitleComponent,
    GalleryFolderListComponent,
    GalleryFolderListComponentSp,
    GalleryLibraryListComponent,
    // GalleryLibraryListComponentSp,
  },
  data() {
    return {};
  },
  methods: {
    // モバイル判定
    moblieFlg() {
      return window.matchMedia &&
        window.matchMedia("(max-device-width: 640px)").matches
        ? true
        : false;
    },
  },
  async mounted() {},
};
</script>

<!-- 共通CSS -->
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
  .gallery-vCard-relative {
    position: relative;
  }
}
</style>