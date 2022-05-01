<template>
  <v-row v-show="loading">
    <v-col>
      <v-progress-linear
        indeterminate
        class="mx-auto"
        color="primary"
      ></v-progress-linear>
    </v-col>
  </v-row>
  <v-row v-show="!loading && getNewsLength() == 0">
    <v-col> お知らせがありません。 </v-col>
  </v-row>
  <v-row
    v-for="item in news"
    :key="item.id"
    dense
    v-show="!loading && getNewsLength() != 0"
  >
    <v-col>
      <v-card>
        <v-row>
          <v-col :cols="1">
            <v-img
              :src="item.imageUrl"
              height="125"
              width="175"
              class="bg-grey-lighten-2"
            ></v-img>
          </v-col>
          <v-col :cols="11">
            <v-row>
              <v-col class="mt-3">
                <v-card-subtitle class="ml-2">{{
                  item.approval_status
                }}</v-card-subtitle>
                <v-card-title class="ml-2">{{ item.title }}</v-card-title>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-card-text
                  >登録日：{{ timestampFormat(item.created_at) }}</v-card-text
                >
              </v-col>
              <v-col>
                <v-card-text
                  >更新日：{{ timestampFormat(item.updated_at) }}</v-card-text
                >
              </v-col>
              <v-col>
                <v-card-text>更新者：{{ item.upd_account.name }}</v-card-text>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-card>
    </v-col>
  </v-row>
  <v-row class="mt-3"> <news-list-table-pagination /></v-row>
</template>

<script>
import NewsListTablePagination from "./NewsListTablePagination.vue";
export default {
  components: {
    NewsListTablePagination,
  },
  data() {
    return {
      test: [],
      news: null,
      loading: false,
    };
  },
  computed: {
    displayLimit() {
      return this.$store.state.news.displayLimit;
    },
    displayPage() {
      return this.$store.state.news.displayPage;
    },
  },
  watch: {
    displayLimit() {
      this.getNewsList();
    },
    displayPage() {
      this.getNewsList();
    },
  },
  methods: {
    getNewsList() {
      this.loading = true;
      axios
        .get("/api/announce", {
          params: {
            limit: this.$store.state.news.displayLimit,
            offset: this.$store.state.news.displayLimit * (this.$store.state.news.displayPage - 1),
          },
        })
        .then((res) => {
          this.news = res.data.anounce;
          this.$store.dispatch('news/setTotalCount', res.data.count)
          this.loading = false;
        });
    },
    getNewsLength() {
      if (!this.news) {
        return 0;
      }
      return this.news.length;
    },
    timestampFormat(timestamp) {
      const date = new Date(timestamp);
      return (
        date.getFullYear().toString() +
        "-" +
        (date.getMonth() + 1).toString().padStart(2, "0") +
        "-" +
        date.getDate().toString().padStart(2, "0")
      );
    },
  },
  mounted() {
    this.getNewsList();
  },
};
</script>