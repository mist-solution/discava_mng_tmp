<template>
  <v-container class="max-cont">
  <title-component
    name = "アカウント一覧"
  />
  <!-- タブ部分 -->
  <v-row class="pt-5 align-center justify-start mx-1">

    <!-- 追加するボタン -->
    <router-link v-bind:to="{ name: 'enduser.register' }" class="mt-2" v-if="approval_auth_flg">
      <button class="btn green-btn_tuika mr-2 px-4 justify-center">
        <v-icon color="white" x-small class="pb-1">mdi-pencil</v-icon>
        追加する
      </button>
    </router-link>
  </v-row>

  <v-row>
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

    <!-- 一括操作-実行ボタン -->
    <v-col
      class="d-flex align-center"
      sm="5"
      cols="10"
      align="center"
      v-if="approval_auth_flg"
    >
<!--
      <input type="checkbox" class="mr-5">
-->
      <v-select
          dense
          :items="items"
          label="一括操作"
          solo
      ></v-select>
      <v-btn class="green-btn_noTransform mx-2">
        実行
      </v-btn>
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
    <v-col align="right" class="mr-2">
      <input
        class="LimitCount"
        type="number"
        Style="text-align:right"
        aria-label="Search"
        min="1"
        maxlength="2"
        hide-details="false"
        v-model="perRowPage"
        @change = "RowPageChange"
      />件表示
    </v-col>
  </v-row>

  <!-- アカウント一覧 -->
  <v-card class="ac-list main-cont">
    <end-user-list-table 
      :searchValue="searchText"
      @LastPageChange="LastPageChange"
    />
  </v-card>

  <div class="pagenation_btn">
    <button
      class="mx-2 px-3 py-2"
      type="button"
      @click="pageToFirst"
      :disabled="firstpage_flg"
      :class="{'disable_btn': firstpage_flg,'white-btn': firstpage_flg == false}"
    >
      ≪
    </button>

    <button
      class="mx-2 px-3 py-2"
      type="button"
      @click="pageToPrev"
      :disabled="firstpage_flg"
      :class="{'disable_btn': firstpage_flg,'white-btn': firstpage_flg == false}"
    >
      ＜
    </button>

    <input
      class="pagenation"
      type="number"
      aria-label="Search"
      min="1"
      :max="LastPage"
      hide-details="false"
      Style="text-align:right"
      v-model="page"
      @change="PageNoChange"
    /> 　/　 {{ LastPage }}

    <button
      class="mx-2 px-3 py-2"
      type="button"
      @click="pageToNext"
      :disabled="lastpage_flg"
      :class="{'disable_btn': lastpage_flg,'white-btn': lastpage_flg == false}"
    >
      ＞
    </button>

    <button
      class="mx-2 px-3 py-2"
      type="button"
      @click="pageToLast"
      :disabled="lastpage_flg"
      :class="{'disable_btn': lastpage_flg,'white-btn': lastpage_flg == false}"
    >
      ≫
    </button>
  </div>
  </v-container>
</template>

<script>
import { mapActions } from "vuex";
import EndUserListTable from "../../items/EndUserListTableComponent.vue";
import TitleComponent from "../../common/TitleComponent.vue"
export default {
  components: {
    EndUserListTable,
    TitleComponent,
  },
  data() {
    return {
      searchText: "",
      items: [ "アカウント一括削除", "権限一括付与", "権限一括削除",],
      approval_auth_flg: null,
      perRowPage: 10,
      LastPage: null,
      page: 1,
      firstpage_flg: true,
      lastpage_flg: false,
    }
  },
  methods: {
    ...mapActions('authority', ['fetchAllAuthority']),
    RowPageChange(){
      this.page = 1;
      this.lastpage_flg = false;
      this.firstpage_flg = true;
      this.$store.dispatch("enduser/setDisplayLimit", this.perRowPage);
      this.$store.dispatch("enduser/setDisplayPage", this.page);
    },
    LastPageChange(value){
      this.LastPage = value;
    },
    pageToFirst(){
      this.page = 1;
      this.lastpage_flg = false;
      this.firstpage_flg = true;
      this.$store.dispatch("enduser/setDisplayPage", this.page);
    },
    pageToPrev(){
      this.page = this.page - 1;
      this.lastpage_flg = false;
      if(this.page == 1){
        this.firstpage_flg = true;
      }
      this.$store.dispatch("enduser/setDisplayPage", this.page);
    },
    pageToNext(){
      this.page = this.page + 1;
      this.firstpage_flg = false;
      if(this.page == this.LastPage){
        this.lastpage_flg = true;
      }
      this.$store.dispatch("enduser/setDisplayPage", this.page);
    },
    pageToLast(){
      this.page = this.LastPage;
      this.firstpage_flg = false;
      this.lastpage_flg = true;
      this.$store.dispatch("enduser/setDisplayPage", this.page);
    },
    PageNoChange(){
      if(this.page == 1){
        this.firstpage_flg = true
        this.lastpage_flg = false
      }else if(this.page == this.LastPage){
        this.firstpage_flg = false
        this.lastpage_flg = true
      }else{
        this.firstpage_flg = false
        this.lastpage_flg = false
      }
      this.$store.dispatch("enduser/setDisplayPage", this.page);
    }
  },
  async mounted() {
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.approval_auth_flg = authority.approval_auth_flg;
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

  /* 追加するボタン */
  .green-btn_tuika {
    border-radius: 5px;
    background-color: #69A5AF;
    box-shadow:0px 1px 5px 0px #69A5AF !important;
    font-size: large;
    font-weight: 400;
    box-shadow: 0 4px 8px rgba(105, 165, 175, 0.56);
    transition: 0.3s;
  }
  .green-btn_tuika:hover {
  color: white !important;
  background-color: #69A5AF !important;
  transform: translate(0, 3px);
  transition: 0.3s;
  box-shadow: 0 2px 4px rgba(105, 165, 175, 0.56) !important;
}
  .green-btn_tuika:active {
    border-color: #69A5AF !important;
  }
  .green-btn_tuika .v-btn__content{
    color:#fff !important;
  }
  .green-btn_tuika {
    color:#fff !important;
  }
  .green-btn_tuika:hover{
    opacity:.8 !important;
    box-shadow: unset !important;
    background-color: #69A5AF !important;
    color:#fff !important;
  }

  .green-btn_tuika > i {
    font-size: 18px !important;
  }

  .LimitCount{
    background-color: white;
    border: solid 1px black;
    width: 45px;
    border-radius: 5px;
    border: none !important;
  }

  .pagenation{
    background-color: white;
    border: solid 1px black;
    width: 30px;
    border-radius: 5px;
    border: none !important;
  }

  .pagenation_btn{
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding-top: 7px;
  }

  .white-btn {
    border-radius: 5px;
    background-color: #fff;
    box-shadow: unset;
    border: none !important;
  }

  .white-btn .v-btn__content{
      color:#69A5AF !important;
  }

  .white-btn {
      color:#69A5AF !important;
  }

  .white-btn:hover{
      box-shadow: unset !important;
      background-color: #fff !important;
      color:#69A5AF !important;
      transform: translate(0, 3px);
      transition: 0.3s;
  }

  .disable_btn{
      border-radius: 5px;
      background-color: transparent;
      color: rgb(172, 171, 171);
      border: solid 0.5px rgb(172, 171, 171);
  }

  .disable-btn:hover{
      background-color: transparent !important;
      color:rgb(172, 171, 171) !important;
      border: solid 0.5px rgb(172, 171, 171);
      transform: none !important;
  }
</style>