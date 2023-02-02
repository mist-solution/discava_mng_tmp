<template>
  <v-container>

    <!-- PCの場合 画面タイトル + タブ -->
    <title-component
      v-if="!moblieFlg()"
      name = "投稿記事一覧"
      :tabFlg ="true"
    />

    <!-- SPの場合 画面タイトル + タブ -->
    <sp-announce-title-component
      v-if="moblieFlg()"
      name = "投稿記事一覧"
      :tabFlg ="true"
    />

    <!-- 投稿ボタン -->
    <v-card-title class="ml-0 pl-0 pc_btn" width="80%" v-if="!moblieFlg()">
      <div class="btn-group ml-auto" v-if="create_auth_flg">
        <router-link v-bind:to="{ name: 'announce.register' }" class="mt-2">
          <button class="btn green-btn_toukou mr-2 px-4 justify-center">
            <v-icon color="white" x-small class="pb-1">mdi-pencil</v-icon>
            投稿
          </button>
        </router-link>
      </div>
      <v-col align="right" class="mr-2 displaycount">
        <input
          class="LimitCount"
          type="number"
          Style="text-align:right"
          aria-label="Search"
          maxlength="2"
          min="1"
          hide-details="false"
          v-model="perRowPage"
          @change = "RowPageChange"
        />件表示
      </v-col>
    </v-card-title>

    <v-row v-if="!moblieFlg()">
      <v-col align="left">
        全 {{  $store.state.announce.totalCount }} 件
      </v-col>

      <v-select
        dense
        class="filter-btn"
        :items="items2"
        label="投稿月"
        item-value="id"
        item-title="text"
        v-model="createdmodel"
        @update:modelValue="createdChange"
      />

      <v-select
        dense
        class="filter-btn"
        :items="items2"
        label="更新月"
        item-value="id"
        item-title="text"
        v-model="updatedmodel"
        @update:modelValue="updatedChange"
      />

      <v-select
        dense
        class="filter-btn"
        :items="categories"
        item-value="id"
        item-title="category_name"
        label="カテゴリー"
        hide-details="false"
        v-model="categoriesmodel"
        @update:modelValue="categoriesChange"
      />

      <v-select
        dense
        class="filter-btn"
        :items="users"
        label="投稿者名"
        item-value="id"
        item-title="name"
        hide-details="false"
        v-model="usermodel"
        @update:modelValue="userChange"
      />

      <v-select
        dense
        class="filter-btn"
        :items="items"
        label="公開状態"
        item-title="text"
        item-value="id"
        v-model="releasemodel"
        @update:modelValue="releaseChange"
      />

      <button
        class="green-btn_noTransform mx-2 px-3 py-2"
        type="button"
        @click="FilterAnnounce()"
      >
        検索
      </button>

      <button
        class="green-btn mx-2 px-3 py-2"
        type="button"
        @click="resetFilterAnnounce()"
      >
        リセット
      </button>
    </v-row>

    <v-row v-if="moblieFlg()" class="sp_btn">
      <!-- 検索ボタン（spのみ） -->
      <v-col>
        <div class="btn-group ml-auto" @click="(displayAnnounceFilter = true)">
          <button class="btn filterbtn-sp mr-2 px-4 justify-center">
            <v-icon color="black" x-small class="pb-1">mdi-magnify</v-icon>
          </button>
        </div>
      </v-col>

      <v-col>
        <input
          class="LimitCount"
          type="number"
          aria-label="Search"
          maxlength="2"
          min="1"
          hide-details="false"
          Style="text-align:right"
          v-model="perRowPage"
          @change = "RowPageChange"
        /> / {{  $store.state.announce.totalCount }} 件
      </v-col>

        <v-card-title class="ml-0 pl-0" width="60%">
        <div class="btn-group ml-auto" v-if="create_auth_flg">
          <router-link v-bind:to="{ name: 'announce.register' }" class="mt-2">
            <button class="btn green-btn_toukou mr-2 px-4 justify-center">
              <v-icon color="white" x-small class="pb-1">mdi-pencil</v-icon>
              投稿
            </button>
          </router-link>
        </div>
        </v-card-title>
    </v-row>

    <!-- テーブル -->
    <v-card class="mt-5">
      <v-card-text>
        <v-window v-model="tab">
          <v-window-item value="one">
            <announce-list-table v-if="!moblieFlg()"/>
            <announce-list-table-sp v-if="moblieFlg()"/>
          </v-window-item>

          <v-window-item value="two">
            <announce-list-table v-if="!moblieFlg()"/>
            <announce-list-table-sp v-if="moblieFlg()"/>
          </v-window-item>

          <v-window-item value="three">
            <announce-list-table v-if="!moblieFlg()"/>
            <announce-list-table-sp v-if="moblieFlg()"/>
          </v-window-item>

          <v-window-item value="four">
            <announce-list-table v-if="!moblieFlg()"/>
            <announce-list-table-sp v-if="moblieFlg()"/>
          </v-window-item>
        </v-window>
      </v-card-text>
    </v-card>
  </v-container>

  <!-- 検索モーダル -->
  <announce-filter-sp-confirm-modal-component
    :modelValue="displayAnnounceFilter"
    @update:modelValue="displayAnnounceFilter = $event"
    :closeAction="closeFilter"
    :items="items"
    :items2="items2"
    :categories="categories"
    :users="users"
  />
</template>

<script>
import { mapGetters,mapActions } from "vuex";

import AnnounceListTable from "./AnnounceListTableComponent.vue";
import AnnounceListTableSp from "./AnnounceListTableComponentSp.vue";
// import AnnounceListActionBarConponent from "./AnnounceListActionBarConponent.vue";
import TitleComponent from "../../common/TitleComponent.vue"
import SpAnnounceTitleComponent from "../../common/SpAnnounceTitleComponent.vue"
import AnnounceFilterSpConfirmModalComponent from "../../modals/AnnounceFilterSpConfirmModalComponent.vue"
// import moment from 'moment';
export default {
  components: {
    AnnounceListTable,
    // AnnounceListActionBarConponent,
    TitleComponent,
    SpAnnounceTitleComponent,
    AnnounceListTableSp,
    AnnounceFilterSpConfirmModalComponent,
  },
  data() {
    return {
      tab: null,
      create_auth_flg: null,
      items: [ 
        {id: 0, text: "全て" },
        {id: 1, text: "公開期間中" },
        {id: 2, text: "公開期間外" }
      ],
      items2: [],
      users: [],
      year: "",
      month: "",
      oldtime: "",
      created_id: "",
      updated_id: "",
      categories_id: "",
      user_id: "",
      release_id: "",
      displayAnnounceFilter: false,
      perRowPage: 25,
      createdmodel: null,
      updatedmodel: null,
      categoriesmodel: null,
      usermodel: null,
      releasemodel: null,
    };
  },
  computed:{
    ...mapGetters("announceCategory", ["getCategories"]),
    categories: {
      get() {
        return this.getCategories;
      }
    },
  },
  methods: {
    ...mapActions('announceCategory', ['fetchCategoriesWithAll']),
    ...mapActions('authority', ['fetchAllAuthority']),
    // モバイル判定
    moblieFlg() {
      return window.matchMedia &&
        window.matchMedia('(max-device-width: 640px)').matches ?
        true : false
    },
    //アカウント名一覧取得
    getAccountNameList(){
      axios
       .get("/api/enduser", {
        })
        .then((res) => {
          this.users = res.data.users;
          this.users.unshift({ id: 0, name: '全て'});
        });
    },

    //投稿月/更新月のドロップダウンリスト作成
    createDropdownList(){
      this.items2[0] = {id: 0, text:"全て" , year:"", month:""}
      let id = 1
      let yearlist = this.year
      let monthlist = this.month
      axios
        .get("/api/oldestAnnounce", {
          })
          .then((res) => {
            this.oldtime = res.data.created_at;
          });
      /*let oldestyear = moment(this.oldtime).format("YYYY");
      let oldestmonth = moment(this.oldtime).format("MM");*/
      let oldestyear = 2022
      let oldestmonth = 12
      for(var i = 1; i < 120; i++){
        if(yearlist == oldestyear || monthlist == oldestmonth){
          this.items2[i] = {id: id, text: yearlist + "年" + monthlist + "月", year: yearlist, month: monthlist}
          break;
        }else{
          this.items2[i] = {id: id, text: yearlist + "年" + monthlist + "月", year: yearlist, month: monthlist}
          id = id + 1
          monthlist = monthlist - 1;
          if(monthlist == 0){
            monthlist = 12;
            yearlist = yearlist - 1;
          }
        }
      }
    },
    //ドロップダウンリスト更新
    createdChange: function(id) {
      const postData = {
        id: id,
      };
      this.created_id = id;
    },
    updatedChange: function(id) {
      const postData = {
        id: id,
      };
      this.updated_id = id;
    },
    categoriesChange: function(id) {
      const postData = {
        id: id,
      };
      this.categories_id = id;
    },
    userChange: function(id) {
      const postData = {
        id: id,
      };
      this.user_id = id;
    },
    releaseChange: function(id) {
      const postData = {
        id: id,
      };
      this.release_id = id;
    },
    FilterAnnounce(){
      //投稿月検索
      if(this.created_id != 0){
        if(this.created_id == 1){
          let start = new Date(this.items2[this.created_id].year + "-" + this.items2[this.created_id].month + "-1")
          this.$store.dispatch("announce/setDisplaySearchAddDateBegin", start);
        }else{
          let start = new Date(this.items2[this.created_id].year + "-" + this.items2[this.created_id].month + "-1")
          let end = new Date(this.items2[this.created_id - 1].year + "-" + this.items2[this.created_id - 1].month + "-1")
          this.$store.dispatch("announce/setDisplaySearchAddDateBegin", start);
          this.$store.dispatch("announce/setDisplaySearchAddDateEnd", end);
        }
      }else{
        this.$store.dispatch("announce/setDisplaySearchAddDateBegin", null);
        this.$store.dispatch("announce/setDisplaySearchAddDateEnd", null);
      }
      //更新月検索
      if(this.updated_id != 0){
        if(this.updated_id == 1){
          let start = new Date(this.items2[this.updated_id].year.toString() + "-" + this.items2[this.updated_id].month.toString() + "-1")
          this.$store.dispatch("announce/setDisplaySearchUpdDateBegin", start);
        }else{
          let start = new Date(this.items2[this.updated_id].year.toString() + "-" + this.items2[this.updated_id].month.toString() + "-1")
          let end = new Date(this.items2[this.updated_id - 1].year.toString() + "-" + this.items2[this.updated_id - 1].month.toString() + "-1")
          this.$store.dispatch("announce/setDisplaySearchUpdDateBegin", start);
          this.$store.dispatch("announce/setDisplaySearchUpdDateEnd", end);
        }
      }else{
        this.$store.dispatch("announce/setDisplaySearchUpdDateBegin", null);
        this.$store.dispatch("announce/setDisplaySearchUpdDateEnd", null);
      }
      //カテゴリ検索
      if(this.categories_id != 0){
        this.$store.dispatch("announce/setDisplaySearchCategory", this.categories_id);
      }else{
        this.$store.dispatch("announce/setDisplaySearchCategory", null);
      }
      //ユーザー検索
      if(this.user_id != 0){
        this.$store.dispatch("announce/setDisplayAnnounceAddAccount", this.user_id);
      }else{
        this.$store.dispatch("announce/setDisplayAnnounceAddAccount", null);
      }
      //公開/非公開検索
      this.$store.dispatch("announce/setDisplaySearchRelease", this.release_id);
    },

    //検索条件リセット
    resetFilterAnnounce(){
      this.created_id = 0;
      this.updated_id = 0;
      this.categories_id = 0;
      this.user_id = 0;
      this.release_id = 0;
      this.createdmodel = null;
      this.updatedmodel = null;
      this.categoriesmodel = null;
      this.usermodel = null;
      this.releasemodel = null;
      this.FilterAnnounce();
    },

    //検索モーダルを閉じる（SP  ）
    closeFilter(){
      this.displayAnnounceFilter = false;
    },

    //表示件数変更
    RowPageChange(){
      this.$store.dispatch("announce/setDisplayLimit", this.perRowPage);
    },
  },
  async created(){
    this.fetchCategoriesWithAll();
    let now = new Date();
    this.year = now.getFullYear();
    this.month = now.getMonth() + 1;
    this.createDropdownList()
  },
  async mounted() {
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.create_auth_flg = authority.create_auth_flg;
    }
    this.getAccountNameList();
  },
};
</script>

<style src="../css/dropdown.css"></style>
<style src="../css/common.css"></style>
<style scoped>
  /* 投稿ボタン */
  .green-btn_toukou {
    border-radius: 5px;
    background-color: #69A5AF;
    font-size: large;
    font-weight: 400;
    box-shadow: 0 4px 8px rgba(105,165,175,0.56);
    transition: 0.3s;
    font-weight: 600;
    letter-spacing: 1.4px;
  }
  .green-btn_toukou:hover {
  color: white !important;
  background-color: #69A5AF !important;
  transform: translate(0, 3px);
  transition: 0.3s;
  box-shadow: 0 4px 8px rgba(105,165,175,0.56) !important;
}
  .green-btn_toukou:active {
    border-color: #69A5AF !important;
  }
  .green-btn_toukou .v-btn__content{
    color:#fff !important;
  }
  .green-btn_toukou {
    color:#fff !important;
  }
  .green-btn_toukou:hover{
    opacity:.8 !important;
    box-shadow: unset !important;
    background-color: #69A5AF !important;
    color:#fff !important;
  }

  .green-btn_toukou > i {
    font-size: 18px !important;
  }

  .filterbtn-sp{
    color: white;
    border: solid 1px black;
  }

  .LimitCount{
    border-radius: 5px;
    background-color: white;
    border: none !important;
    width: 50px
  }

  .pc_btn{
    display: flex;
  }

  .sp_btn{
    align-items: flex-end;
  }

  .displaycount{
    transform: scale(85%);
  }

  .filter-btn{
    background-color: #fff;
    border-radius: 10px;
  }

</style>