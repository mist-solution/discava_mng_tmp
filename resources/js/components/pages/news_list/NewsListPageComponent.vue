<template>
  <v-card>
    <v-card-title class="ml-2" width="80%">
      <h3 class="h4">お知らせ一覧</h3>
      <div class="btn-group ml-auto">
        <router-link v-bind:to="{ name: 'task.list' }">
          <button class="btn btn-success mr-2">List</button>
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
      <v-tab value="one">承認済み記事</v-tab>
      <v-tab value="two">自分の投稿記事</v-tab>
      <v-tab value="three">承認待ち記事</v-tab>
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
};
</script>
