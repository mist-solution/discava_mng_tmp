<template>
  <v-container class="max-cont">
    <title-component
      name = "投稿記事一覧"
    />
    <v-card>
      <v-card-title class="ml-2" width="80%">
        <div class="btn-group ml-auto">
          <router-link v-bind:to="{ name: 'announce.register' }">
            <button class="btn btn-success mr-2">投稿</button>
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
          >承認待ち</v-tab
        >
        <v-tab
          value="two"
          @click="
            newsStatus(0);
            setSelectTab(2);
          "
          >下書き</v-tab
        >
        <v-tab
          value="three"
          @click="
            newsStatus(3);
            setSelectTab(3);
          "
          >差戻し</v-tab
        >
        <v-tab
          value="four"
          @click="
            newsStatus(2);
            setSelectTab(4);
          "
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
    };
  },
  methods: {
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
};
</script>