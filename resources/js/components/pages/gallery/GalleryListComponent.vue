<template>
  <div class="edit-title">
    <title-component class="sp_disable" name="ギャラリー編集" />
    <sp-gallery-title-component class="pc_disable" name="ギャラリー編集" />
  </div>
  <div class="gallery-flex">
    <!-- フォルダ管理 -->
    <v-card class="main-cont p-3">
      <gallery-folder-list-component></gallery-folder-list-component>
    </v-card>

    <!-- ライブラリ -->
    <v-card class="main-cont mt-5 mt-sm-0 p-3"> </v-card>
  </div>
</template>

<script>
import TitleComponent from "../../common/TitleComponent.vue";
import SpGalleryTitleComponent from "../../common/SpGalleryTitleComponent.vue";
import GalleryFolderListComponent from "../gallery/GalleryFolderListComponent.vue";

export default {
  components: {
    TitleComponent,
    SpGalleryTitleComponent,
    GalleryFolderListComponent,
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
}
</style>