<template>
  <back-to-top-component />
  <!-- <v-row v-show="loading">
    <v-col>
      <v-progress-linear
        indeterminate
        class="mx-auto"
        color="primary"
      ></v-progress-linear>
    </v-col>
  </v-row>
  <v-row v-show="!loading && getNewsLength() == 0">
    <v-col>
      お知らせがありません。
    </v-col>
  </v-row> -->
    <v-row justify="end">
      <v-col align="right" class="mr-2">
        合計件数： {{ $store.state.news.totalCount }}
      </v-col>
    </v-row>

  <v-row>
    <v-col>
      <EasyDataTable
        v-model:items-selected="selected"
        :headers="headers"
        :items="news"
        table-class-name="customize-table"
        :theme-color="themeColor"
        alternating
        buttons-pagination
        dense
      >
        <template #loading>
          <v-progress-linear
            indeterminate
            class="mx-auto"
            color="primary"
          />
        </template>
        <template #item-title="item">
          <router-link :to="{ name: 'announce.edit', params: { announceId: item.id } }" v-if="update_auth_flg">
            {{ item.title }}
          </router-link>
          <div v-if="!update_auth_flg">
            {{ item.title }}
          </div>
        </template>
        <template #item-created_at="item">
          {{ timestampFormat(item.created_at) }}
        </template>
        <template #item-updated_at="item">
          {{ timestampFormat(item.updated_at) }}
        </template>
        <template #item-approval_status="item">
          <div class="text-center">
            {{ approvalStatusFormat(item.approval_status) }}
            <br>
            <v-menu>
              <template v-slot:activator="{ props }" v-if="update_auth_flg">
                <v-btn   elevation="2" x-small v-bind="props">
                  編集
                </v-btn>
              </template>
              <v-list
              >
                <v-list-item>
                  <v-list-item-title>
                    <div 
                      @click="(displayAnnouncePreview = true),
                       setPreviewInfo(item.start_date,item.end_date,item.contents)" role="button">
                      プレビュー
                    </div>
                  </v-list-item-title>
                </v-list-item>
                <!-- 申請する - ユーザに申請権限があるかつ、お知らせの承認ステータスか0:下書きもしくは3:差戻しの場合表示 -->
                <v-list-item v-if="request_auth_flg &&
                  (item.approval_status === 0 || item.approval_status === 3)"
                >
                  <v-list-item-title>
                    <div
                      @click="(displayNewsRequestConfirm = true),
                        setApprovalAnnounceId(item.id)"
                      role="button"
                    >
                      申請する
                    </div>
                  </v-list-item-title>
                </v-list-item>
                <!-- 承認する - ユーザに承認権限があるかつ、お知らせの承認ステータスか1:承認待ちの場合表示 -->
                <v-list-item v-if="approval_auth_flg && item.approval_status === 1">
                  <v-list-item-title>
                    <div
                      @click="(displayNewsApprovalConfirm = true),
                        setNewsId(item.id)"
                      role="button"
                    >
                      承認する
                    </div>
                  </v-list-item-title>
                </v-list-item>
                <!-- 差し戻す - ユーザに承認権限があるかつ、お知らせの承認ステータスか1:承認待ちもしくは2:承認済みの場合表示 -->
                <v-list-item v-if="approval_auth_flg &&
                  (item.approval_status === 1 || item.approval_status === 2)"
                >
                  <v-list-item-title>
                    <div
                      @click="(displayNewsReturnApprovalConfirm = true),
                        setApprovalAnnounceId(item.id)"
                      role="button"
                    >
                      差し戻す
                    </div>
                  </v-list-item-title>
                </v-list-item>
                <!-- 取り下げる - ユーザに申請権限があるかつ、お知らせの承認ステータスか0:下書き以外の場合表示 -->
                <v-list-item v-if="request_auth_flg && item.approval_status != 0">
                  <v-list-item-title>
                    <div
                      @click="(displayNewsCancelConfirm = true),
                        setApprovalAnnounceId(item.id)"
                      role="button"
                    >
                      取り下げる
                    </div>
                  </v-list-item-title>
                </v-list-item>
                <!-- 削除 - ユーザに削除権限がある場合表示 -->
                <v-list-item v-if="delete_auth_flg">
                  <v-list-item-title>
                    <div
                      @click="(displayNewsDeleteConfirm = true),
                        setDeleteAnnounceId(item.id)"
                      role="button"
                    >
                      削除
                    </div>
                  </v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </div>
        </template>
        <template #item-open_status="item">
          <!-- on off 切り替え -->
          <div class="toggle_switch">
              <input type="checkbox" name="open" id="cb_toggle_switch">
              <label for="cb_toggle_switch"></label>
          </div>
          <!-- 無効化 -->
          <div class="toggle_switch disable">
              <input type="checkbox" name="open" id="cb_toggle_switch">
              <label for="cb_toggle_switch"></label>
          </div>
        </template>
      </EasyDataTable>
    </v-col>
  </v-row>

  <!-- <v-row
    v-for="item in news"
    :key="item.id"
    dense
    v-show="!loading && getNewsLength() != 0"
  >
    <v-col>
      <v-card>
        <v-row>
          <v-col :cols="1">
            ID:{{ item.id }}
            <v-checkbox
              v-model="select"
              :value="item.id"
              @change="setSelectItems"
              v-if="item.approval_status != 1 && item.approval_status != 9"
            ></v-checkbox>
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
                  {{ approvalStatusFormat(item.approval_status) }}
                </v-card-subtitle>
                <v-card-title class="ml-2">
                  <router-link :to="{ name: 'announce.edit', params: { announceId: item.id } }">
                    {{ item.title }}
                  </router-link>
                </v-card-title>
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
                        v-bind:to="{
                          name: listItems[index].link,
                          params: { announceId: item.id },
                        }"
                      >
                        <v-list-item-title>
                          {{ listItems[index].title }}
                        </v-list-item-title>
                      </v-list-item>
                    </v-list>

                    <v-divider></v-divider>
                    
                    <v-list>
                      <v-list-item
                        color="red"
                        @click.stop="(displayNewsDeleteConfirm = true), setDeleteAnnounceId(item.id)"
                      >
                        <v-list-item-title>
                          {{ menuDeleteAnnounce[index].title }}
                        </v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-card>
                </v-menu>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-card-text>
                  登録日：{{ timestampFormat(item.created_at) }}<br/>
                  登録者：{{ item.add_account.name }}
                </v-card-text>
              </v-col>
              <v-col>
                <v-card-text>
                  更新日：{{ timestampFormat(item.updated_at) }}<br/>
                  更新者：{{ item.upd_account.name }}
                </v-card-text>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-card>
    </v-col>
  </v-row> -->


  <!-- 申請モーダル -->
  <news-approval-request-confirm-modal-component
    :modelValue="displayNewsRequestConfirm"
    @update:modelValue="displayNewsRequestConfirm = $event"
    :closeAction="closeRequest"
    :approvalRequest="approvalRequest"
  />

  <!-- 承認モーダル -->
  <news-approval-confirm-modal-component
    :modelValue="displayNewsApprovalConfirm"
    @update:modelValue="displayNewsApprovalConfirm = $event"
    :closeAction="closeApproval"
    :approvalAnnounce="approvalAnnounce"
  />

  <!-- 差し戻しモーダル -->
  <news-approval-return-confirm-modal-component
    :modelValue="displayNewsReturnApprovalConfirm"
    @update:modelValue="displayNewsReturnApprovalConfirm = $event"
    :closeAction="closeReturn"
    :approvalReturn="approvalReturn"
  />

  <!-- 取り下げモーダル -->
  <news-approval-cancel-confirm-modal-component
    :modelValue="displayNewsCancelConfirm"
    @update:modelValue="displayNewsCancelConfirm = $event"
    :closeAction="closeCancel"
    :approvalCancel="approvalCancel"
  />

  <!-- 削除モーダル -->
  <news-delete-confirm-modal-component
    :modelValue="displayNewsDeleteConfirm"
    @update:modelValue="displayNewsDeleteConfirm = $event"
    :closeAction="closeAction"
    :deleteAnnounce="deleteAnnounce"
  />

  <!-- プレビュー画面モーダル -->
  <announce-preview-modal-component
    :modelValue="displayAnnouncePreview"
    @update:modelValue="displayAnnouncePreview = $event"
    :closeAction="closePreview"
    :close_flg=0
    :contents="contents"
    :start_date="start_date"
    :end_date="end_date"
    :username="username"
  />

  <!-- <v-row class="mt-3">
    <news-list-table-pagination />
  </v-row> -->
</template>

<script>
import { mapActions } from "vuex";

import NewsListTablePagination from "./NewsListTablePagination.vue";
import BackToTopComponent from "../../BackToTopComponent.vue";
import { mergeProps } from "vue";
import NewsDeleteConfirmModalComponent from "../../modals/NewsDeleteConfirmModalComponent.vue";
import NewsApprovalConfirmModalComponent from "../../modals/NewsApprovalConfirmModalComponent.vue";
import NewsApprovalReturnConfirmModalComponent from "../../modals/NewsApprovalReturnConfirmModalComponent.vue";
import NewsApprovalRequestConfirmModalComponent from "../../modals/NewsApprovalRequestConfirmModalComponent.vue"
import NewsApprovalCancelConfirmModalComponent from "../../modals/NewsApprovalCancelConfirmModalComponent.vue"
import AnnouncePreviewModalComponent from "../../modals/AnnouncePreviewModalComponent.vue"

export default {
  components: {
    NewsListTablePagination,
    BackToTopComponent,
    NewsDeleteConfirmModalComponent,
    NewsApprovalConfirmModalComponent,
    NewsApprovalReturnConfirmModalComponent,
    NewsApprovalRequestConfirmModalComponent,
    NewsApprovalCancelConfirmModalComponent,
    AnnouncePreviewModalComponent

  },
  data() {
    return {
      selected: [],
      he: [
        { text: 'タイトル', value: 'title' },
      ],
      items: [
        { a: 'a' },
        { a: 'b' },
      ],

      headers: [
        {
          text: '',
          sortable: false,
          value: 'imageUrl',
        },
        { text: 'タイトル', value: 'title' },
        { text: 'カテゴリー', value: 'announce_category.category_name' },
        { text: '投稿日', value: 'created_at' },
        { text: '最終更新', value: 'updated_at' },
        { text: '投稿者', value: 'add_account.name' },
        { text: 'ステータス', value: 'approval_status' },
        { text: '公開', value: 'open_status' },
        {
          text: '',
          sortable: false,
          value: 'button',
        },
      ],
      test: [],
      news: [],
      loading: false,
      displayNewsRequestConfirm: false,
      displayNewsApprovalConfirm: false,
      displayNewsReturnApprovalConfirm: false,
      displayNewsCancelConfirm: false,
      displayNewsDeleteConfirm: false,
      displayAnnouncePreview: false,
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
      themeColor: "#69A5AF",
      approval_auth_flg: null,
      create_auth_flg: null,
      update_auth_flg: null,
      request_auth_flg: null,
      delete_auth_flg: null,
      start_date: null,
      end_date: null,
      contents: null,
      username: null,
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
    ...mapActions('authority', ['fetchAllAuthority']),
    ...mapActions('enduser', ['getUserInfo']),
    mergeProps,
    // モーダルを閉じる
    closeRequest() {
      this.displayNewsRequestConfirm = false;
    },
    closeApproval() {
      this.displayNewsApprovalConfirm = false;
    },
    closeReturn() {
      this.displayNewsReturnApprovalConfirm = false;
    },
    closeCancel() {
      this.displayNewsCancelConfirm = false;
    },
    closeAction() {
      this.displayNewsDeleteConfirm = false;
      // window.location.reload();
    },
    closePreview(){
      this.displayAnnouncePreview = false;
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
      let approvalStatus = '';
      let step = this.approvalStatusArray.length;
      for (var i = 0; i < step; i++) {
        const approvalStatusValue = this.approvalStatusArray[i].value;
        if (approvalStatusValue == newsApprovalStatus) {
          approvalStatus = this.approvalStatusArray[i].status;
        }
      }
      return approvalStatus;
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
    // 承認確認ダイアログに渡せるため、IDをstoreに設定
    setApprovalAnnounceId(id) {
      let announceId = id;
      this.$store.dispatch("news/setApprovalNewsId", announceId);
    },

    // 承認確認ダイアログに渡せるため、IDをstoreに設定
    setApprovalAnnounceId(id) {
      let announceId = id;
      this.$store.dispatch("news/setApprovalNewsId", announceId);
    },

    // お知らせIDをstoreに設定
    setNewsId(id) {
      this.$store.dispatch("news/setNewsId", id);
    },

    // 申請処理
    approvalRequest(announceId) {
      axios.put("/api/announce/" + announceId + "/request")
      .then((res) => {});
      window.location.reload();
    },

    // 承認処理
    approvalAnnounce(announce) {
      axios.post("/api/announce/" + announce + "/approval")
      .then((res) => {});
      window.location.reload();
    },

    // 差戻し処理
    approvalReturn(announceId) {
      axios.put("/api/announce/" + announceId + "/return", {
          announce: this.announce,
          approvalReturnComment:
          this.$store.state.news.approvalReturnComment,
      })
      .then((res) => {});
      window.location.reload();
    },

    // 取り下げ処理
    approvalCancel(announceId) {
      axios.put("/api/announce/" + announceId + "/cansel").then((res) => {});
      window.location.reload();
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

    //プレビュー画面に必要な情報をセット
    setPreviewInfo(start_date,end_date,contents){
      this.start_date = start_date.slice(0,-3)
      this.end_date = end_date.slice(0,-3)
      this.contents = contents
    },
  },
  async mounted() {
    this.getNewsList();
    this.setSelectItems();
    this.getListItems();
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.delete_auth_flg = authority.delete_auth_flg;
      this.update_auth_flg = authority.update_auth_flg;
      this.create_auth_flg = authority.create_auth_flg;
      this.approval_auth_flg = authority.approval_auth_flg;
      this.request_auth_flg = authority.request_auth_flg;
    }
    let name = await this.getUserInfo();
    if(name){
        this.username = name.name;
    }

  },
};
</script>

<!-- 共通CSS -->
<style src="../css/common.css"></style>
<style src="../css/list.css"></style>
<style src="../css/dropdown.css"></style>
<style scoped>
/* 編集ボタン既存クラス上書き */
.statusbutton {
  padding: 0 8px !important;
  --v-btn-height: 26px !important;
  background-color: #69A5AF;
  color: #FFF;
}

.customize-table {
  /* 表の罫線 */
  --easy-table-row-border: none;

  /* 表の背景色 */
  --easy-table-header-background-color: #F7F7F7;

  /* フッターのpadding追加 */
  --easy-table-footer-padding: 1.5rem;

  /* フッターフォントサイズ */
  --easy-table-footer-font-size: 14px;
}
/* open button */
.toggle_switch {
    display: table;
    font-size: 20px;
    margin:0 auto;
}

.toggle_switch > input {
    display: none;
}

.toggle_switch > label {
    display: block;
    position: relative;
    width: 2.2em;
    height: 1em;
    border-radius: 1em;
    background-color: #CCCCCC;
    cursor: pointer;
}
.toggle_switch > input:checked + label {
    background-color: #69A5AF;
}
.toggle_switch > label::before {
    position: absolute;
    top: 0.05em;
    left: 0.05em;
    width: calc(1em - 0.1em);
    height: calc(1em - 0.1em);
    border-radius: calc(1em - 0.1em);
    background-color: #fff;
    transition: 0.5s;
    content: "";
}
.toggle_switch > input:checked + label::before {
    left: calc(100% - 1em + 0.05em);
}
.disable > label::before {
    background-color: #BABABA;
    pointer-events:none;
}
.disable > label{
  cursor: default;
}
</style>
<style lang="scss">

.v-dialog--fullscreen .v-overlay__content{
    width: 100% !important;
}

.v-dialog--fullscreen .v-overlay__content .v-card{
    padding: 0px !important;
}

</style>