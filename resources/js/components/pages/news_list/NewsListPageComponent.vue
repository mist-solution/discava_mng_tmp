<template>
  <v-card>
    <v-card-title class="ml-2" width="80%">
      <h3 class="h4">お知らせ一覧</h3>
      <div class="btn-group ml-auto">
        <router-link v-bind:to="{ name: 'announce.register' }">
          <button class="btn btn-success mr-2">投稿</button>
        </router-link>
        <router-link v-bind:to="{ name: 'task.list' }">
          <button class="btn btn-success mr-2">TASK List</button>
        </router-link>
        <router-link v-bind:to="{ name: 'task.create' }">
          <button class="btn btn-success mr-2">ADD</button>
        </router-link>
        <router-link v-bind:to="{ name: 'quilleditor' }">
          <button class="btn btn-success">News</button>
        </router-link>
      </div>
    </v-card-title>
    <v-divider />
    <v-tabs v-model="tab" fixed-tabs class="mx-auto" dark>
      <v-tab
        value="one"
        @click="
          newsStatus(1);
          newsAddAccount();
          setSelectTab(1);
        "
        >承認済み記事</v-tab
      >
      <v-tab
        value="two"
        @click="
          newsAddAccount(2);
          newsStatus();
          setSelectTab(2);
        "
        >自分の投稿記事</v-tab
      >
      <v-tab
        value="three"
        @click="
          newsStatus(0);
          newsAddAccount();
          setSelectTab(3);
        "
        >承認待ち記事</v-tab
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

    // 自分のアカウントID
    // 仮実装ID：2
    newsAddAccount(newsAddAccount) {
      this.$store.dispatch("news/setDisplayNewsAddAccount", newsAddAccount);
    },

    // 選択したタブをstoreに設定
    setSelectTab(key) {
      let tabName = "";
      if (key == 1) {
        tabName = "checkedLists"; // 承認済み記事
      } else if (key == 2) {
        tabName = "selfLists"; // 自分の投稿記事
      } else if (key == 3) {
        tabName = "notCheckLists"; // 承認待ち記事
      }
      this.$store.dispatch("news/setDisplayListsItemKey", tabName);
    },
  },
};
</script>
