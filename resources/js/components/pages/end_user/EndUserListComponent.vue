<template>
  <v-container class="max-cont">
  <title-component
    name = "アカウント一覧"
  />
  <!-- タブ部分 -->
  <v-row class="pt-5 align-center justify-start">
    <!-- 一括操作-実行ボタン -->
    <v-col
      class="d-flex align-center"
      sm="5"
      cols="10"
      align="center"
    >
      <input type="checkbox" class="mr-5">
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

    <!-- searchフォーム -->
    <v-col
      sm="4"
      cols="6"
      class="d-flex justify-sm-end justify-start"
    >
      <form class="searchform-list">
        <input
          class="searchform search-box"
          type="search"
          placeholder="検索"
          aria-label="Search"
          maxlength="30"
          hide-details="false"
          v-model="searchText"
        />
        <button type="button" class="serch-btn"><v-icon>mdi-magnify</v-icon></button>
      </form>
    </v-col>

    <!-- 件数表示 -->
<!--
    <v-col
      sm="3"
      cols="6"
      class="usercount-list p-0 justify-sm-center justify-start"
    >
      <p class="m-0 px-3">全16件</p>
      <p class="countnum m-0">10</p>
      <p class="m-0 px-2">件表示</p>
    </v-col>
-->
  </v-row>

  <!-- アカウント一覧 -->
  <v-card class="ac-list main-cont">
      <end-user-list-table :searchValue="searchText"/>
  </v-card>
  </v-container>
</template>

<script>
import EndUserListTable from "./EndUserListTableComponent.vue";
import TitleComponent from "../../common/TitleComponent.vue"
export default {
  components: {
    EndUserListTable,
    TitleComponent,
  },
  data() {
    return {
      searchText: "",
    }
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

/* 件数表示 */
.usercount-list {
  display: flex;
  justify-content: center;
  align-items: center;
}

.usercount-list > .countnum {
  background-color: #FFF;
  padding: 5px 10px;
}

/* 検索フォーム */
.searchform-list {
  position: relative;
  max-width: 300px;
}

.searchform-list > .search-box {
  padding: 10px 30px 10px 8px;
  border-radius: 8px;
  width: 180px;
}

@media (max-width: 599.99px){
.searchform-list > .search-box{
    width: 150px;
  }
}


.searchform-list > .serch-btn {
  height:50px;
  position:absolute;
  top:-2px;
  background:none;
  color:#666;
  border:none;
  font-size:14px;
  right: 10px;
}
</style>