<template>
  <v-container>

    <!-- PCの場合 画面タイトル + タブ -->
    <title-component
      v-if="!moblieFlg()"
      name = "投稿記事一覧"
      :tabFlg ="true"
      @LastPageChange="LastPageChange"
    />

    <!-- SPの場合 画面タイトル + タブ -->
    <sp-announce-title-component
      v-if="moblieFlg()"
      name = "投稿記事一覧"
      :tabFlg ="true"
      @LastPageChange="LastPageChange"
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
    </v-card-title>

    <v-row v-if="!moblieFlg()">
      <v-col class="sort-flex px-0" col="6">

        <DatePicker
          class="filter-btn datepicker"
          v-model="createdmodel"
          placeholder="投稿月"
          :format="format"
          :preview-format="previewFormat"
          selectText="確認"
          cancelText="キャンセル"
          month-picker
          @update:model-value="FilterAnnounce"
        />

        <DatePicker
          class="filter-btn datepicker"
          v-model="updatedmodel"
          placeholder="更新月"
          :format="format"
          :preview-format="previewFormat"
          selectText="確認"
          cancelText="キャンセル"
          month-picker
          @update:model-value="FilterAnnounce"
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
          @update:modelValue='categoriesChange'
        />
      </v-col>

      <v-col class="sort-flex px-0" col="6">
        <input
          dense
          class="filter-btn user_search"
          placeholder="　投稿者名"
          type="search"
          hide-details="false"
          v-model="usermodel"
          @change="FilterAnnounce"
          Style="text-align: center"
        />

        <v-select
          dense
          class="filter-btn"
          :items="items"
          label="公開状態"
          item-title="text"
          item-value="id"
          v-model="releasemodel"
          @update:modelValue='releaseChange'
        />

        <button
          class="green-btn mx-2 px-3 py-2"
          type="button"
          @click="resetFilterAnnounce()"
        >
          リセット
        </button>
      </v-col>
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

    <div class="bottom_header" v-if="!moblieFlg()">
      <div class="text-gray">
            全 {{  $store.state.announce.totalCount }} 件
      </div>

    <div class="pagenation_btn">
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

      <button
        class="mx-2 px-3 py-2"
        type="button"
        @click="pageToFirst"
        :disabled="firstpage_flg"
        :class="{'disable_btn': firstpage_flg,'white-btn': firstpage_flg == false,'disable_page': !pager_flg}"
      >
        <v-icon>mdi-chevron-double-left</v-icon>
      </button>

      <button
        class="mx-2 px-3 py-2"
        type="button"
        @click="pageToPrev"
        :disabled="firstpage_flg"
        :class="{'disable_btn': firstpage_flg,'white-btn': firstpage_flg == false,'disable_page': !pager_flg}"
      >
        <v-icon>mdi-chevron-left</v-icon>
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
        :class="{'disable_page': !pager_flg}"
      /> 
      <div :class="{'disable_page': !pager_flg}">
      　/　 {{ LastPage }}
      </div>

      <button
        v-if="reset"
        class="mx-2 px-3 py-2"
        type="button"
        @click="pageToNext"
        :disabled="lastpage_flg"
        :class="{'disable_btn': lastpage_flg,'white-btn': lastpage_flg == false,'disable_page': !pager_flg}"
      >
        <v-icon>mdi-chevron-right</v-icon>
      </button>

      <button
        v-if="reset"
        class="rightbutton mx-2 px-3 py-2"
        type="button"
        @click="pageToLast"
        :disabled="lastpage_flg"
        :class="{'disable_btn': lastpage_flg,'white-btn': lastpage_flg == false,'disable_page': !pager_flg}"
      >
        <v-icon>mdi-chevron-double-right</v-icon>
      </button>
    </div>
    </div>

    <!-- テーブル -->
    <v-card class="mt-5">
      <v-card-text>
        <v-window v-model="tab">
          <v-window-item value="one">
            <announce-list-table v-if="!moblieFlg()" @LastPageChange="LastPageChange"/>
            <announce-list-table-sp v-if="moblieFlg()" @LastPageChange="LastPageChange"/>
          </v-window-item>

          <v-window-item value="two">
            <announce-list-table v-if="!moblieFlg()" @LastPageChange="LastPageChange"/>
            <announce-list-table-sp v-if="moblieFlg()" @LastPageChange="LastPageChange"/>
          </v-window-item>

          <v-window-item value="three">
            <announce-list-table v-if="!moblieFlg()" @LastPageChange="LastPageChange"/>
            <announce-list-table-sp v-if="moblieFlg()" @LastPageChange="LastPageChange"/>
          </v-window-item>

          <v-window-item value="four">
            <announce-list-table v-if="!moblieFlg()" @LastPageChange="LastPageChange"/>
            <announce-list-table-sp v-if="moblieFlg()" @LastPageChange="LastPageChange"/>
          </v-window-item>
        </v-window>
      </v-card-text>
    </v-card>

    <div class="pagenation_btn" :class="{'disable_page': !pager_flg}">
      <button
        class="mx-2 px-3 py-2"
        type="button"
        @click="pageToFirst"
        :disabled="firstpage_flg"
        :class="{'disable_btn': firstpage_flg,'white-btn': firstpage_flg == false}"
      >
        <v-icon>mdi-chevron-double-left</v-icon>
      </button>

      <button
        class="mx-2 px-3 py-2"
        type="button"
        @click="pageToPrev"
        :disabled="firstpage_flg"
        :class="{'disable_btn': firstpage_flg,'white-btn': firstpage_flg == false}"
      >
        <v-icon>mdi-chevron-left</v-icon>
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
        v-if="reset"
        class="mx-2 px-3 py-2"
        type="button"
        @click="pageToNext"
        :disabled="lastpage_flg"
        :class="{'disable_btn': lastpage_flg,'white-btn': lastpage_flg == false}"
      >
         <v-icon>mdi-chevron-right</v-icon>
      </button>

      <button
        v-if="reset"
        class="rightbutton mx-2 px-3 py-2"
        type="button"
        @click="pageToLast"
        :disabled="lastpage_flg"
        :class="{'disable_btn': lastpage_flg,'white-btn': lastpage_flg == false}"
      >
    <v-icon>mdi-chevron-double-right</v-icon>
    </button>
  </div>

  
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
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';
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
    DatePicker,
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
        {id: 1, text: "公開中" },
        {id: 2, text: "公開期間外" }
      ],
      items2: [],
      //users: [],
      year: "",
      month: "",
      oldtime: "",
      created_id: "",
      updated_id: "",
      categories_id: "",
      //user_id: "",
      release_id: "",
      displayAnnounceFilter: false,
      perRowPage: 25,
      createdmodel: null,
      updatedmodel: null,
      categoriesmodel: null,
      usermodel: null,
      releasemodel: null,
      page: 1,
      firstpage_flg: true,
      lastpage_flg: false,
      pager_flg: true,
      LastPage: null,
      reset: true,
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
    /*getAccountNameList(){
      axios
       .get("/api/enduser", {
        })
        .then((res) => {
          this.users = res.data.users;
          this.users.unshift({ id: 0, name: '全て'});
        });
    },*/

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
      //let oldestyear = moment(this.oldtime).format("YYYY");
      //let oldestmonth = moment(this.oldtime).format("MM");
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
      this.FilterAnnounce()
    },
    updatedChange: function(id) {
      const postData = {
        id: id,
      };
      this.updated_id = id;
      this.FilterAnnounce()
    },
    categoriesChange: function(id) {
      const postData = {
        id: id,
      };
      this.categories_id = id;
      this.FilterAnnounce()
    },
    releaseChange: function(id) {
      const postData = {
        id: id,
      };
      this.release_id = id;
      this.FilterAnnounce()
    },
    FilterAnnounce(){
      //投稿月検索
      if(this.createdmodel != null){
        let start_year
        let start_month
        let end_year
        let end_month
        if(this.createdmodel.month == 11){
          start_month = 12;
          start_year = this.createdmodel.year;
          end_month = 1;
          end_year = start_year + 1
        }else{
          start_month = this.createdmodel.month + 1;
          start_year = this.createdmodel.year;
          end_month = start_month + 1;
          end_year = start_year;
        }
        let start = new Date(start_year + "-" + start_month + "-1")
        let end = new Date(end_year + "-" + end_month + "-1")
        start.setHours(start.getHours() + 9);
        end.setHours(end.getHours() + 9);
        console.log(start)
        console.log(end)
        this.$store.dispatch("announce/setDisplaySearchAddDateBegin", start);
        this.$store.dispatch("announce/setDisplaySearchAddDateEnd", end);
      }else{
        this.$store.dispatch("announce/setDisplaySearchAddDateBegin", null);
        this.$store.dispatch("announce/setDisplaySearchAddDateEnd", null);
      }
      //更新月検索
      if(this.updatedmodel != null){
        let start_year
        let start_month
        let end_year
        let end_month
        if(this.updatedmodel.month == 11){
          start_month = 12;
          start_year = this.updatedmodel.year;
          end_month = 1;
          end_year = start_year + 1
        }else{
          start_month = this.updatedmodel.month + 1;
          start_year = this.updatedmodel.year;
          end_month = start_month + 1;
          end_year = start_year;
        }
        let start = new Date(start_year + "-" + start_month + "-1")
        let end = new Date(end_year + "-" + end_month + "-1")
        start.setHours(start.getHours() + 9);
        end.setHours(end.getHours() + 9);
        this.$store.dispatch("announce/setDisplaySearchUpdDateBegin", start);
        this.$store.dispatch("announce/setDisplaySearchUpdDateEnd", end);
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
      if(this.usermodel != ""){
        this.$store.dispatch("announce/setDisplayAnnounceAddAccount", this.usermodel);
      }else{
        this.$store.dispatch("announce/setDisplayAnnounceAddAccount", null);
      }
      //公開/非公開検索
      this.$store.dispatch("announce/setDisplaySearchRelease", this.release_id);
      this.$store.dispatch("announce/setDisplayPage", 1);
    },

    //検索条件リセット
    resetFilterAnnounce(){
      this.created_id = 0;
      this.updated_id = 0;
      this.categories_id = 0;
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
      this.page = 1;
      if(this.totalcount - this.perRowPage <= 0){
        this.lastpage_flg = true;
      }else{
        this.lastpage_flg = false;
      }
      this.firstpage_flg = true;
      this.$store.dispatch("announce/setDisplayLimit", this.perRowPage);
      this.$store.dispatch("announce/setDisplayPage", this.page);
    },
    LastPageChange(value1,value2){
      this.pager_flg = true;
      this.page = 1
      this.firstpage_flg = true
      this.LastPage = value1;
      this.totalcount = value2;
      if(this.LastPage == 1){
        this.lastpage_flg = true
        this.reset = false;
        this.$nextTick(() => (this.reset = true));
      }else if(this.LastPage == 0){
        this.page = 0;
        this.lastpage_flg = true;
        this.pager_flg = false;
        this.reset = false;
        this.$nextTick(() => (this.reset = true));
      }else{
        this.lastpage_flg = false
      }
    },
    pageToFirst(){
      this.page = 1;
      this.lastpage_flg = false;
      this.firstpage_flg = true;
      this.$store.dispatch("announce/setDisplayPage", this.page);
    },
    pageToPrev(){
      this.page = this.page - 1;
      this.lastpage_flg = false;
      if(this.page == 1){
        this.firstpage_flg = true;
      }
      this.$store.dispatch("announce/setDisplayPage", this.page);
    },
    pageToNext(){
      this.page = this.page + 1;
      this.firstpage_flg = false;
      if(this.page == this.LastPage){
        this.lastpage_flg = true;
      }
      this.$store.dispatch("announce/setDisplayPage", this.page);
    },
    pageToLast(){
      this.page = this.LastPage;
      this.firstpage_flg = false;
      this.lastpage_flg = true;
      this.$store.dispatch("announce/setDisplayPage", this.page);
    },
    PageNoChange(){
      if(this.page == 1){
        if(this.LastPage != 1){
          this.firstpage_flg = true
          this.lastpage_flg = false
        }else{
          this.firstpage_flg = true
          this.lastpage_flg = true
        }
      }else if(this.page == this.LastPage){
        this.firstpage_flg = false
        this.lastpage_flg = true
      }else{
        this.firstpage_flg = false
        this.lastpage_flg = false
      }
      this.$store.dispatch("announce/setDisplayPage", this.page);
    },

    format(date) {
      return moment(date).format('yyyy/MM');
    },

     previewFormat(date) {
      return moment(date).format('yyyy/MM');
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
    //this.getAccountNameList();
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
    width: 50px;
    color: #707070;
  }

  

  .sp_btn{
    align-items: flex-end;
  }

  .displaycount{
    transform: scale(85%);
    color: #707070;
  }

  .filter-btn{
    background-color: #fff;
    border-radius: 10px;
    margin: 0 5px;
  }

.sort-flex {
  display: flex;
  align-items: center;
  justify-content: center;
}

.v-label.v-field-label {
  font-size: 14px !important;
}

.user_search{
  height: 55px;
}

::placeholder {
	text-align: left;
  }

  .dp__input{
    height: 55px;
  }

.white-btn {
    border-radius: 5px;
    background-color: #fff;
    box-shadow: unset;
    border: none !important;
    font-weight: 600;
    letter-spacing: 1.3px;
  }

  .white-btn .v-btn__content{
      color:#69A5AF !important;
  }

  .white-btn {
      color:#69A5AF !important;
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

  .pagenation{
    background-color: white;
    border: solid 1px black;
    width: 50px;
    height: 40px;
    border-radius: 5px;
    border: none !important;
  }

  .pagenation_btn{
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding-top: 7px;
  }
  
  .disable_page{
    display: none;
  }
  
  .bottom_header{
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .rightbutton{
    margin-right: 0px !important;
  }
</style>