<template>
  <v-container class="grey lighten-5">
    <v-row no-gutters>
      <v-row justify="right">
        <v-col cols="12" sm="6" md="8">
          <v-btn
            @click.stop="displaySearch = true"
            class="ma-2"
            color="#d9d9d9"
            icon="mdi-magnify"
            variant="contained"
          >
          </v-btn>
          <label>検索</label>

          <v-btn
            @click.stop="displaySort = true"
            class="ma-2"
            color="#d9d9d9"
            icon="mdi-unfold-more-horizontal"
            variant="contained"
          >
          </v-btn>
          <label>並び順</label>

          <v-btn
            @click.stop="displayLimit = true"
            class="ma-2"
            color="#d9d9d9"
            icon="mdi-plus-minus-variant"
            variant="contained"
          >
          </v-btn>
          <label>表示件数</label>

          <v-btn
            @click.stop="displayCheckAll = true"
            class="ma-2"
            color="#d9d9d9"
            icon="mdi-check"
            variant="contained"
          >
          </v-btn>
          <label>一括承認</label>

          <!-- 検索モーダル -->
          <news-display-search-modal-component
            :display="displaySearch"
            :closeAction="closeAction"
          />

          <!-- 並び順モーダル -->
          <news-display-sort-modal-component
            :display="displaySort"
            :closeAction="closeAction"
          />
          <!-- 表示件数モーダル -->
          <news-display-limit-modal-component
            :display="displayLimit"
            :closeAction="closeAction"
          />

          <!-- 一括承認モーダル -->
          <news-display-check-all-modal-component
            :display="displayCheckAll"
            :closeAction="closeAction"
          />
        </v-col>
      </v-row>

      <v-row justify="end">
        <v-col cols="6" md="4" align-self="center">
          合計件数： {{ $store.state.news.totalCount }}
        </v-col>
      </v-row>
    </v-row>
  </v-container>
</template>

<script>
import NewsDisplaySearchModalComponent from "./NewsDisplaySearchModalComponent.vue";
import NewsDisplayLimitModalComponent from "./NewsDisplayLimitModalComponent.vue";
import NewsDisplaySortModalComponent from "./NewsDisplaySortModalComponent.vue";
import NewsDisplayCheckAllModalComponent from "./NewsDisplayCheckAllModalComponent.vue";

export default {
  components: {
    NewsDisplaySearchModalComponent,
    NewsDisplayLimitModalComponent,
    NewsDisplaySortModalComponent,
    NewsDisplayCheckAllModalComponent,
  },
  data() {
    return {
      displaySearch: false,
      displaySort: false,
      displayLimit: false,
      displayCheckAll: false,
    };
  },
  methods: {
    closeAction() {
      this.displaySearch = false;
      this.displaySort = false;
      this.displayLimit = false;
      this.displayCheckAll = false;
    },
  },
  mounted() {},
};
</script>