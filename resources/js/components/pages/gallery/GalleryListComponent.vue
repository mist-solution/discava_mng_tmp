<template>
  <v-container>
    <title-component
      class="sp_disable title-card-width"
      name="ギャラリー編集"
    />
    <sp-gallery-title-component class="pc_disable" name="ギャラリー編集" />
    <div class="gallery-flex">
      <!-- フォルダ管理 -->
      <v-card class="main-cont p-3 gallery-vCard-relative">
        <gallery-folder-list-component></gallery-folder-list-component>
      </v-card>

      <!-- ライブラリ -->
      <v-card class="main-cont p-3">
        <gallery-library-list-component></gallery-library-list-component>
      </v-card>
    </div>
  </v-container>
</template>

<script>
import TitleComponent from "../../common/TitleComponent.vue";
import SpGalleryTitleComponent from "../../common/SpGalleryTitleComponent.vue";
import GalleryFolderListComponent from "../gallery/GalleryFolderListComponent.vue";
import GalleryLibraryListComponent from "../gallery/GalleryLibraryListComponent.vue";

export default {
  components: {
    TitleComponent,
    SpGalleryTitleComponent,
    GalleryFolderListComponent,
    GalleryLibraryListComponent,
  },
  data() {
    return {};
  },
  methods: {},
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
  .title-card-width {
    width: 79.5vw;
  }
  .gallery-vCard-relative {
    position: relative;
  }
}
</style>