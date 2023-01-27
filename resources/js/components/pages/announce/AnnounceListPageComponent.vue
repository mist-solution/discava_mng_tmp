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
    <v-card-title class="ml-0 pl-0" width="80%">
      <div class="btn-group ml-auto" v-if="create_auth_flg">
        <router-link v-bind:to="{ name: 'announce.register' }" class="mt-2">
          <button class="btn green-btn_toukou mr-2 px-4 justify-center">
            <v-icon color="white" x-small class="pb-1">mdi-pencil</v-icon>
            投稿
          </button>
        </router-link>
      </div>
    </v-card-title>

    <!-- 表示件数 -->
    <v-row justify="end">
      <v-col align="right" class="mr-2">
        合計件数： {{  $store.state.announce.totalCount }}
      </v-col>
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
</template>

<script>
import { mapActions } from "vuex";

import AnnounceListTable from "./AnnounceListTableComponent.vue";
import AnnounceListTableSp from "./AnnounceListTableComponentSp.vue";
// import AnnounceListActionBarConponent from "./AnnounceListActionBarConponent.vue";
import TitleComponent from "../../common/TitleComponent.vue"
import SpAnnounceTitleComponent from "../../common/SpAnnounceTitleComponent.vue"
export default {
  components: {
    AnnounceListTable,
    // AnnounceListActionBarConponent,
    TitleComponent,
    SpAnnounceTitleComponent,
    AnnounceListTableSp,
  },
  data() {
    return {
      tab: null,
      create_auth_flg: null,
    };
  },
  methods: {
    ...mapActions('authority', ['fetchAllAuthority']),
    // モバイル判定
    moblieFlg() {
      return window.matchMedia &&
        window.matchMedia('(max-device-width: 640px)').matches ?
        true : false
    }
  },
  async mounted() {
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.create_auth_flg = authority.create_auth_flg;
    }
  },
};
</script>

<style scoped>
  /* 投稿ボタン */
  .green-btn_toukou {
    border-radius: 5px;
    background-color: #69A5AF;
    box-shadow:0px 1px 5px 0px #69A5AF !important;
    font-size: large;
    font-weight: 400;
    box-shadow: 0 4px 8px rgba(105, 165, 175, 0.56);
    transition: 0.3s;
  }
  .green-btn_toukou:hover {
  color: white !important;
  background-color: #69A5AF !important;
  transform: translate(0, 3px);
  transition: 0.3s;
  box-shadow: 0 2px 4px rgba(105, 165, 175, 0.56) !important;
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

</style>