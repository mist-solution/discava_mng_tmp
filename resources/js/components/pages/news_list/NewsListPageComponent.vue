<template>
  <v-card>
    <v-card-title class="ml-2" width="80%">お知らせ一覧</v-card-title>
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
