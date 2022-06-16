<template>
  <back-to-top-component />
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
            <v-checkbox
              v-model="select"
              :value="item.id"
              @change="setSelectItems"
              v-if="item.approval_status != 1"
            ></v-checkbox>
            {{ item.id }}
          </v-col>
          <v-col :cols="1">
            <v-img
              :src="item.imageUrl"
              height="125"
              width="175"
              class="bg-grey-lighten-2"
            ></v-img>
          </v-col>
          <v-col :cols="10">
            <v-row>
              <v-col class="mt-3">
                <v-card-subtitle class="ml-2">
                  {{ approvalStatus[item.approval_status]["status"] }} ///
                  {{ item.approval_status }}
                </v-card-subtitle>
                <v-card-title class="ml-2">{{ item.title }}</v-card-title>
              </v-col>
              <v-col :cols="2">
                <v-menu>
                  <template v-slot:activator="{ props: menu }">
                    <v-tooltip location="top">
                      <template v-slot:activator="{ props: tooltip }">
                        <v-btn
                          color="primary"
                          v-bind="mergeProps(menu, tooltip)"
                          icon="mdi-dots-horizontal"
                        >
                        </v-btn>
                      </template>
                      <span>I'm A Tooltip</span>
                    </v-tooltip>
                  </template>
                  <v-list>
                    <v-list-item v-for="(item, index) in items" :key="index">
                      <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>
                  </v-list>
                </v-menu>
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
                <v-card-text
                  >更新者：{{ item.upd_account.name }} /// 登録者：{{
                    item.add_account
                  }}</v-card-text
                >
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
import BackToTopComponent from "../../BackToTopComponent.vue";
import { mergeProps } from "vue";

export default {
  components: {
    NewsListTablePagination,
    BackToTopComponent,
  },
  data() {
    return {
      test: [],
      news: null,
      loading: false,
      approvalStatus: [
        { value: "0", status: "未承認" },
        { value: "1", status: "承認" },
        { value: "2", status: "差戻し" },
        { value: "3", status: "否認" },
      ],
      items: [
        { title: "詳細を確認" },
        { title: "承認する" },
        { title: "差し戻す" },
        { title: "削除" },
      ],
      select: [],
    };
  },
  computed: {
    displayLimit() {
      return this.$store.state.news.displayLimit;
    },
    displaySort() {
      return this.$store.state.news.displaySort;
    },
    displayNewsStatus() {
      return this.$store.state.news.displayNewsStatus;
    },
    displayNewsAddAccount() {
      return this.$store.state.news.displayNewsAddAccount;
    },
    displayPage() {
      return this.$store.state.news.displayPage;
    },
  },
  watch: {
    displayLimit() {
      this.getNewsList();
    },
    displaySort() {
      this.getNewsList();
    },
    displayNewsStatus() {
      this.getNewsList();
    },
    displayNewsAddAccount() {
      this.getNewsList();
    },
    displayPage() {
      this.getNewsList();
    },
  },
  methods: {
    mergeProps,
    getNewsList() {
      this.loading = true;
      axios
        .get("/api/announce", {
          params: {
            limit: this.$store.state.news.displayLimit,
            offset:
              this.$store.state.news.displayLimit *
              (this.$store.state.news.displayPage - 1),
            sort: this.$store.state.news.displaySort,
            newsStatus: this.$store.state.news.displayNewsStatus,
            newsAddAccount: this.$store.state.news.displayNewsAddAccount,
          },
        })
        .then((res) => {
          this.news = res.data.anounce;
          this.$store.dispatch("news/setTotalCount", res.data.count);
          this.loading = false;
        });
    },
    getNewsLength() {
      if (!this.news) {
        return 0;
      }
      return this.news.length;
    },

    // 選択した記事をstoreに設定
    setSelectItems() {
      this.$store.dispatch("news/setDisplayCheckedItems", this.select);
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
    this.setSelectItems();
  },
};
</script>