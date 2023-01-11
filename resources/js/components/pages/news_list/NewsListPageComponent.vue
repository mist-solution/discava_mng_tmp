<template>
  <v-container class="max-cont">
    <title-component
      name = "投稿記事一覧"
    />
    <v-card>
      <v-card-title class="ml-2" width="80%">
        <div class="btn-group ml-auto" v-if="create_auth_flg">
          <router-link v-bind:to="{ name: 'announce.register' }" class="mt-2">
            <button class="btn green-btn_toukou mr-2 px-4 justify-center">
              <v-icon color="white" x-small class="pb-1">mdi-pencil</v-icon>
              投稿
            </button>
          </router-link>
  <!--
          <router-link v-bind:to="{ name: 'task.list' }">
            <button class="btn btn-success mr-2">TASK List</button>
          </router-link>
          <router-link v-bind:to="{ name: 'task.create' }">
            <button class="btn btn-success mr-2">ADD</button>
          </router-link>
          <router-link v-bind:to="{ name: 'quilleditor' }">
            <button class="btn btn-success">News</button>
          </router-link>
  -->
        </div>
      </v-card-title>
      <v-divider />
      <v-tabs v-model="tab" fixed-tabs class="mx-auto" dark>
        <v-tab
          value="one"
          @click="
            newsStatus(1);
            setSelectTab(1);
          "
          v-if="update_auth_flg"
          >承認待ち</v-tab
        >
        <v-tab
          value="two"
          @click="
            newsStatus(0);
            setSelectTab(2);
          "
          v-if="update_auth_flg"
          >下書き</v-tab
        >
        <v-tab
          value="three"
          @click="
            newsStatus(3);
            setSelectTab(3);
          "
          v-if="update_auth_flg"
          >差戻し</v-tab
        >
        <v-tab
          value="four"
          @click="
            newsStatus(2);
            setSelectTab(4);
          "
          v-if="update_auth_flg"
          >承認済み</v-tab
        >
      </v-tabs>

      <v-card-actions>
        <news-list-action-bar-conponent class="ml-3" />
      </v-card-actions>

      <v-card-text>
        <v-window v-model="tab">
          <v-window-item value="one">
            <news-list-table />
          </v-window-item>

          <v-window-item value="two">
            <news-list-table />
          </v-window-item>

          <v-window-item value="three">
            <news-list-table />
          </v-window-item>

          <v-window-item value="four">
            <news-list-table />
          </v-window-item>
        </v-window>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions } from "vuex";

import NewsListTable from "./NewsListTableComponent.vue";
import NewsListActionBarConponent from "./NewsListActionBarConponent.vue";
import TitleComponent from "../../common/TitleComponent.vue"
export default {
  components: {
    NewsListTable,
    NewsListActionBarConponent,
    TitleComponent
  },
  data() {
    return {
      tab: null,
      create_auth_flg: null,
      update_auth_flg: null,
    };
  },
  methods: {
    ...mapActions('authority', ['fetchAllAuthority']),
    // お知らせの承認ステータス
    newsStatus(newsStatus) {
      this.$store.dispatch("news/setDisplayNewsStatus", newsStatus);
    },

    // 選択したタブをstoreに設定
    setSelectTab(key) {
      let tabName = "";
      if (key == 1) {
        // 承認待ち
        tabName = "notCheckLists";
      } else if (key == 2) {
        // 下書き
        tabName = "draftLists";
      } else if (key == 3) {
        // 差戻し
        tabName = "sendBackLists";
      } else if (key == 4) {
        // 承認済み
        tabName = "checkedLists";
      }
      this.$store.dispatch("news/setDisplayListsItemKey", tabName);
    },
  },
  async mounted() {
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.update_auth_flg = authority.update_auth_flg;
      this.create_auth_flg = authority.create_auth_flg;
      console.log(this.create_auth_flg);
    }
  },
};
</script>

<style scoped>
  /* 投稿ボタン */
  .green-btn_toukou {
    border-radius: 5px;
    background-color: #69A5AF;
    box-shadow: unset;
    font-size: large;
    font-weight: 600;
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
</style>