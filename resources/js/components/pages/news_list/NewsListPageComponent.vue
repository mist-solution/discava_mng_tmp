<template>
  <v-card>
    <v-card-title class="ml-2" width="80%">
      <h3 class="h4">投稿記事一覧</h3>
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
        >承認済み</v-tab
      >
      <v-tab
        value="two"
        @click="
          newsStatus(2);
          setSelectTab(2);
        "
        >承認待ち</v-tab
      >
      <v-tab
        value="three"
        @click="
          newsStatus();
          setSelectTab(3);
        "
        >全ての投稿</v-tab
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
      </v-window>
    </v-card-text>
  </v-card>
</template>

<script>
import NewsListTable from "./NewsListTableComponent.vue";
import NewsListActionBarConponent from "./NewsListActionBarConponent.vue";
export default {
  components: {
    NewsListTable,
    NewsListActionBarConponent,
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
        tabName = "checkedLists"; // 承認済み
      } else if (key == 2) {
        tabName = "notCheckLists"; // 承認待ち
      } else if (key == 3) {
        tabName = "allLists";     // 全ての投稿
      }
      this.$store.dispatch("news/setDisplayListsItemKey", tabName);
    },
  },
};
</script>
