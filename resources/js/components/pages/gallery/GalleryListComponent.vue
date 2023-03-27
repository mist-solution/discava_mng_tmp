<template>
  <v-container class="max-cont">
  <title-component
    class = "sp_disable"
    name = "ギャラリー編集"
  />
  <sp-gallery-title-component
    class = "pc_disable"
    name = "ギャラリー編集"
  />

  </v-container>
</template>

<script>
import TitleComponent from "../../common/TitleComponent.vue"
import SpGalleryTitleComponent from "../../common/SpGalleryTitleComponent.vue"

export default {
  components: {
    TitleComponent,
    SpGalleryTitleComponent,
  },
  data() {
    return {
    }
  },
  methods: {

  },
  async mounted() {
  },
}
</script>

<!-- 共通CSS -->
<style src="../css/common.css"></style>

<!-- 固有CSS -->
<style scoped>
  @media (max-width: 900px){
    .sp_disable{
        display: none;
    }
  }

  @media (min-width: 901px){
    .pc_disable{
        display: none;
    }
  }
</style>