<template>
  <title-component
    name = "アカウント一覧"
  />
  <!-- タブ部分 -->
  <v-row class="pt-5 align-center justify-end">
    <!-- 一括操作-実行ボタン -->


    <!-- searchフォーム -->
    <v-col cols="3" class="d-flex">
      <form>
        <button icon="mdi-magnify"></button>
        <input
          class="searchform"
          type="search"
          placeholder="test"
          aria-label="Search"
          maxlength="30"
          hide-details="false"
        />
      </form>
    </v-col>

    <!-- 件数表示 -->
    <v-col cols="2" class="d-flex justify-center">
      <p>全16件</p>
      <p class="white-background">10</p>
      <p>件表示</p>
    </v-col>

    <!-- ページャー -->
    <v-col cols="3" class="d-flex">
      <v-container class="max-width">
        <v-pagination
          v-model="page"
          class="my-4"
          :length="15"
        ></v-pagination>
      </v-container>
    </v-col>
  </v-row>

  <!-- アカウント一覧 -->
  <v-card class="ac-list main-cont">
    <v-col
      class="d-flex align-center main-cont"
      cols="4"
      align="center"
    >
      <input type="checkbox">
        <v-select
          dense
          :items="items"
          label="Solo field"
          solo
        ></v-select>
        <v-btn class="green-btn mx-2">
        実行
      </v-btn>
    </v-col>
      <end-user-list-table />

  </v-card>
</template>

<script>
import EndUserListTable from "./EndUserListTableComponent.vue";
import TitleComponent from "../../common/TitleComponent.vue"
export default {
  components: {
    EndUserListTable,
    TitleComponent,
  },
}
</script>

<!-- 共通CSS -->
<style src="../css/common.css"></style>

<!-- 固有CSS -->
<style scoped>
.ac-list{
  position:relative;
  overflow: visible;
}
.ac-list > .main-cont{
  position:absolute;
  bottom:100%;
  background-color: #fff;
}
.searchform {
  border: 10px;
  background-color: #FFF;
}

.gray-background {
  background-color: #F7F7F7;
}

.white-background {
  background: #FFF;
}
</style>