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
              v-if="item.approval_status != 1 && item.approval_status != 9"
            ></v-checkbox>
            ID:{{ item.id }}
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
                <v-card-subtitle class="ml-3">
                  {{
                    (approvalStatusFormat(item.approval_status),
                    this.approvalStatus)
                  }}
                </v-card-subtitle>
                <v-card-title class="ml-2">{{ item.title }}</v-card-title>
                <v-card-subtitle class="ml-2">
                  {{ item.announce_category.category }}
                </v-card-subtitle>
              </v-col>
              <v-col :cols="2">
                <v-menu :close-on-content-click="true">
                  <template v-slot:activator="{ props }">
                    <v-btn
                      color="primary"
                      v-bind="props"
                      icon="mdi-dots-horizontal"
                    >
                    </v-btn>
                  </template>

                  <v-card>
                    <v-list>
                      <v-list-item
                        color="black"
                        v-for="(listItems, index) in listItems"
                        :key="index"
                        v-bind:to="{
                          name: listItems.link,
                          params: { announceId: item.id },
                        }"
                      >
                        <v-list-item-title>{{
                          listItems.title
                        }}</v-list-item-title>
                      </v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                    <v-list>
                      <v-list-item
                        color="red"
                        v-for="(
                          menuDeleteAnnounce, index
                        ) in menuDeleteAnnounce"
                        :key="index"
                        @click.stop="
                          (displayNewsDeleteConfirm = true),
                            setDeleteAnnounceId(item.id)
                        "
                      >
                        <v-list-item-title>
                          {{ menuDeleteAnnounce.title }}
                        </v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-card>
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
  <!-- 削除モーダル -->
  <news-delete-confirm-modal-component
    :display="displayNewsDeleteConfirm"
    :closeAction="closeAction"
    :deleteAnnounce="deleteAnnounce"
  />
  <v-row class="mt-3"> <news-list-table-pagination /></v-row>
</template>

<script>
import NewsListTablePagination from "./NewsListTablePagination.vue";
import BackToTopComponent from "../../BackToTopComponent.vue";
import { mergeProps } from "vue";
import NewsDeleteConfirmModalComponent from "./NewsDeleteConfirmModalComponent.vue";

export default {
  components: {
    NewsListTablePagination,
    BackToTopComponent,
    NewsDeleteConfirmModalComponent,
  },
  data() {
    return {
      test: [],
      news: null,
      loading: false,
      displayNewsDeleteConfirm: false,
      approvalStatus: "",
      approvalStatusArray: [
        { value: "0", status: "下書き" },
        { value: "1", status: "承認待ち" },
        { value: "2", status: "承認済" },
        { value: "3", status: "差戻し" },
      ],
      listItems: [],
      menuDeleteAnnounce: [],
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
    displaySearchAddDateBegin() {
      return this.$store.state.news.displaySearchAddDateBegin;
    },
    displaySearchAddDateEnd() {
      return this.$store.state.news.displaySearchAddDateEnd;
    },
    displaySearchUpdDateBegin() {
      return this.$store.state.news.displaySearchUpdDateBegin;
    },
    displaySearchUpdDateEnd() {
      return this.$store.state.news.displaySearchUpdDateEnd;
    },
    displaySearchNewsCol() {
      return this.$store.state.news.displaySearchNewsCol;
    },
    displaySearchNews() {
      return this.$store.state.news.displaySearchNews;
    },
    displaySearchCategory() {
      return this.$store.state.news.displaySearchCategory;
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
    displaySearchAddDateBegin() {
      this.getNewsList();
    },
    displaySearchAddDateEnd() {
      this.getNewsList();
    },
    displaySearchUpdDateBegin() {
      this.getNewsList();
    },
    displaySearchUpdDateEnd() {
      this.getNewsList();
    },
    displaySearchNewsCol() {
      this.getNewsList();
    },
    displaySearchNews() {
      this.getNewsList();
    },
    displaySearchCategory() {
      this.getNewsList();
    },
    displayPage() {
      this.getNewsList();
    },
  },
  methods: {
    mergeProps,
    closeAction() {
      this.displayNewsDeleteConfirm = false;
      window.location.reload();
    },

    getNewsList() {
      this.loading = true;
      axios
        .get("/api/announce", {
          params: {
            limit:
              this.$store.state.news.displayLimit,
            offset:
              this.$store.state.news.displayLimit * (this.$store.state.news.displayPage - 1),
            sort:
              this.$store.state.news.displaySort,
            newsStatus:
              this.$store.state.news.displayNewsStatus,
            newsAddAccount:
              this.$store.state.news.displayNewsAddAccount,
            searchAddDateBegin:
              this.$store.state.news.displaySearchAddDateBegin,
            searchAddDateEnd:
              this.$store.state.news.displaySearchAddDateEnd,
            searchUpdDateBegin:
              this.$store.state.news.displaySearchUpdDateBegin,
            searchUpdDateEnd:
              this.$store.state.news.displaySearchUpdDateEnd,
            searchNewsCol:
              this.$store.state.news.displaySearchNewsCol,
            searchNews:
              this.$store.state.news.displaySearchNews,
            searchCategory:
              this.$store.state.news.displaySearchCategory,
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

    // 承認ステータスフォーマット
    approvalStatusFormat(newsApprovalStatus) {
      let step = this.approvalStatusArray.length;
      for (var i = 0; i < step; i++) {
        const approvalStatusValue = this.approvalStatusArray[i].value;
        if (approvalStatusValue == newsApprovalStatus) {
          this.approvalStatus = this.approvalStatusArray[i].status;
        }
      }
      return this.approvalStatus;
    },

    getListItems() {
      let listsItemKey = this.$store.state.news.displayListsItemKey;

      // 承認済みタブ
      if (listsItemKey == "checkedLists") {
        this.listItems = [
          {
            title: "詳細を確認",
            link: "news.detail",
          },
          { title: "共有リンクをコピー" },
          { title: "公開停止" },
        ];
        this.menuDeleteAnnounce = [{ title: "削除" }];

        // 承認待ちタブ
      } else if (listsItemKey == "notCheckLists") {
        this.listItems = [
          {
            title: "詳細を確認",
            link: "news.detail",
          },
          { title: "承認する", link: "news.approval" },
          { title: "差し戻す", link: "news.approval" },
        ];
        this.menuDeleteAnnounce = [{ title: "削除" }];

      // 全ての投稿タブ
      } else if (listsItemKey == "allLists") {
        this.listItems = [
          {
            title: "詳細を確認",
            link: "news.detail",
          },
          { title: "共有リンクをコピー" },
          { title: "公開停止" },
        ];
        this.menuDeleteAnnounce = [{ title: "削除" }];
      }

    },

    // 選択した記事をstoreに設定
    setSelectItems() {
      this.$store.dispatch("news/setDisplayCheckedItems", this.select);
    },

    // 削除確認ダイアログに渡せるため、IDをstoreに設定
    setDeleteAnnounceId(id) {
      let announceId = id;
      this.$store.dispatch("news/setDeleteNewsId", announceId);
    },

    // 削除処理
    deleteAnnounce(announceId) {
      console.log(`ID:${announceId} が削除しました。`);
      axios.delete("/api/announce/" + announceId).then((res) => {});
      window.location.reload();
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
    this.getListItems();
  },
};
</script>
