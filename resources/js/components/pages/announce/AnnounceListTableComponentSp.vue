<template>
  <back-to-top-component />

  <v-row>
    <v-col class="pt-0">
      <EasyDataTable
        ref="dataTable"
        v-model:items-selected="selected"
        :headers="headers"
        :items="announce"
        table-class-name="customize-table"
        :theme-color="themeColor"
        alternating
        buttons-pagination
        :search-field="searchField"
  			:search-value="searchText"
        dense
      >
        <template #loading>
          <v-progress-linear
            indeterminate
            class="mx-auto"
            color="primary"
          />
        </template>

        <!-- ヘッダー行に一括操作を追加 -->
        <template v-slot:header-title="{ }" v-if="update_auth_flg"> 
          <div class="d-flex align-center w-100">
            <v-select
              outlined
              :items="items2"
              item-title="text"
              item-value="id"
              label="一括操作"
              solo
              bg-color="white"
              @update:modelValue="operateidChange"
              class="w-100 my-2 action-select"
            ></v-select>
            <button
              class="green-btn mx-2 px-3 py-2"
              type="button"
              @click="allCheckedItemOperate()"
            >
              実行
            </button>
          </div>
        </template>

        <!-- サムネイル画像 + タイトル -->
        <template #item-title="item">
          <div class="headtitle-left">
            <v-row>

              <!-- タイトル -->
              <v-col cols="7" class="detaTable-header_title my-3">
                <!-- タイトル - 編集権限あり -->
                <router-link
                  v-if="update_auth_flg"
                  :to="{ name: 'announce.edit', params: { announceId: item.id } }"
                  class="announce-title-font"
                >
                  {{ item.title }}
                </router-link>
                <!-- タイトル - 編集権限なし -->
                <div v-if="!update_auth_flg" class="announce-title-font_disable">
                  {{ item.title }}
                </div>
                <!-- カテゴリー -->
                <p class="mb-0 announce-category-font">
                  カテゴリー：{{ item.announce_categories.category_name }}
                </p>
              </v-col>

              <v-col cols="3" class="detaTable-header_title text-center">
                <!-- 承認ステータス -->
                <p
                  v-if="$store.state.announce.displayAnnounceStatus == null"
                  class="mb-1"
                  :class="getApprovalStatusColor(item.approval_status)"
                >
                  {{ getApprovalStatus(item.approval_status) }}
                </p>
              </v-col>

              <!-- 操作 -->
              <v-col cols="2" class="detaTable-header_title">
                <div class="text-center d-flex">
                <v-menu>
                  <template v-slot:activator="{ props }" v-if="update_auth_flg">
                    <button
                      v-bind="props"
                      icon
                      color="#616161"
                      size="x-small"
                      class="my-3"
                      type="button"
                    >
                      <v-icon x-large>mdi-dots-horizontal</v-icon>
                    </button>
                  </template>
                  <v-list>
                    <v-list-item>
                        <v-list-item-title>
                          <div  v-if="update_auth_flg">
                            <router-link
                              class="text-white"
                              :to="{ name: 'announce.edit', params: { announceId: item.id } }"
                            >
                              編集
                            </router-link>
                          </div>
                        </v-list-item-title>
                      </v-list-item>
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
                            @click="(displayAnnounceRequestConfirm = true),
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
                            @click="(displayAnnounceApprovalConfirm = true),
                              setApprovalAnnounceId(item.id)"
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
                            @click="(displayAnnounceReturnApprovalConfirm = true),
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
                            @click="(displayAnnounceCancelConfirm = true),
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
                            @click="(displayAnnounceDeleteConfirm = true),
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
              </v-col>

            </v-row>
          </div>
        </template>
      </EasyDataTable>
    </v-col>
  </v-row>

  <!-- 申請モーダル -->
  <announce-approval-request-confirm-modal-component
    :modelValue="displayAnnounceRequestConfirm"
    @update:modelValue="displayAnnounceRequestConfirm = $event"
    :closeAction="closeRequest"
    :approvalRequest="approvalRequest"
  />

  <!-- 承認モーダル -->
  <announce-approval-confirm-modal-component
    :modelValue="displayAnnounceApprovalConfirm"
    @update:modelValue="displayAnnounceApprovalConfirm = $event"
    :closeAction="closeApproval"
    :approvalAnnounce="approvalAnnounce"
  />

  <!-- 差し戻しモーダル -->
  <announce-approval-return-confirm-modal-component
    :modelValue="displayAnnounceReturnApprovalConfirm"
    @update:modelValue="displayAnnounceReturnApprovalConfirm = $event"
    :closeAction="closeReturn"
    :approvalReturn="approvalReturn"
  />

  <!-- 取り下げモーダル -->
  <announce-approval-cancel-confirm-modal-component
    :modelValue="displayAnnounceCancelConfirm"
    @update:modelValue="displayAnnounceCancelConfirm = $event"
    :closeAction="closeCancel"
    :approvalCancel="approvalCancel"
  />

  <!-- 削除モーダル -->
  <announce-delete-confirm-modal-component
    :modelValue="displayAnnounceDeleteConfirm"
    @update:modelValue="displayAnnounceDeleteConfirm = $event"
    :closeAction="closeAction"
    :deleteAnnounce="deleteAnnounce"
  />

  <!-- プレビュー画面モーダル -->
  <announce-preview-modal-component
    :modelValue="displayAnnouncePreview"
    @update:modelValue="displayAnnouncePreview = $event"
    :closeAction="closePreview"
    :contents="contents"
    :start_date="start_date"
    :end_date="end_date"
    :username="username"
  />

  <!-- <v-row class="mt-3">
    <announce-list-table-pagination />
  </v-row> -->
</template>

<script>
import { mapActions } from "vuex";

import AnnounceListTablePagination from "./AnnounceListTablePagination.vue";
import BackToTopComponent from "../../BackToTopComponent.vue";
import { mergeProps,ref,computed } from "vue";
import AnnounceDeleteConfirmModalComponent from "../../modals/AnnounceDeleteConfirmModalComponent.vue";
import AnnounceApprovalConfirmModalComponent from "../../modals/AnnounceApprovalConfirmModalComponent.vue";
import AnnounceApprovalReturnConfirmModalComponent from "../../modals/AnnounceApprovalReturnConfirmModalComponent.vue";
import AnnounceApprovalRequestConfirmModalComponent from "../../modals/AnnounceApprovalRequestConfirmModalComponent.vue"
import AnnounceApprovalCancelConfirmModalComponent from "../../modals/AnnounceApprovalCancelConfirmModalComponent.vue"
import AnnouncePreviewModalComponent from "../../modals/AnnouncePreviewModalComponent.vue"
import moment from 'moment';

export default {
  components: {
    AnnounceListTablePagination,
    BackToTopComponent,
    AnnounceDeleteConfirmModalComponent,
    AnnounceApprovalConfirmModalComponent,
    AnnounceApprovalReturnConfirmModalComponent,
    AnnounceApprovalRequestConfirmModalComponent,
    AnnounceApprovalCancelConfirmModalComponent,
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
      items2: [ 
        {id: 1, text: "一括承認" },
        {id: 2, text: "一括削除" }
      ],

      headers: [
        { text: '', value: 'title' },
        // { text: '投稿日', value: 'created_at', sortable: true},
        // { text: '最終更新', value: 'updated_at', sortable: true },
        // { text: '投稿者', value: 'add_account.name' },
        // { text: 'ステータス', value: 'open_status' },
        // { text: '操作', value: 'actions' },
      ],
      test: [],
      announce: [],
      loading: false,
      displayAnnounceRequestConfirm: false,
      displayAnnounceApprovalConfirm: false,
      displayAnnounceReturnApprovalConfirm: false,
      displayAnnounceCancelConfirm: false,
      displayAnnounceDeleteConfirm: false,
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
      searchField: "title",
      searchText: "",
      dataTable: [],
      clientItemsLength: null,
      operate_id: null,
    };
  },
  computed: {
    displayLimit() {
      return this.$store.state.announce.displayLimit;
    },
    displaySort() {
      return this.$store.state.announce.displaySort;
    },
    displayAnnounceStatus() {
      return this.$store.state.announce.displayAnnounceStatus;
    },
    displayAnnounceAddAccount() {
      return this.$store.state.announce.displayAnnounceAddAccount;
    },
    displaySearchAddDateBegin() {
      return this.$store.state.announce.displaySearchAddDateBegin;
    },
    displaySearchAddDateEnd() {
      return this.$store.state.announce.displaySearchAddDateEnd;
    },
    displaySearchUpdDateBegin() {
      return this.$store.state.announce.displaySearchUpdDateBegin;
    },
    displaySearchUpdDateEnd() {
      return this.$store.state.announce.displaySearchUpdDateEnd;
    },
    displaySearchAnnounceCol() {
      return this.$store.state.announce.displaySearchAnnounceCol;
    },
    displaySearchAnnounce() {
      return this.$store.state.announce.displaySearchAnnounce;
    },
    displaySearchCategory() {
      return this.$store.state.announce.displaySearchCategory;
    },
    displayPage() {
      return this.$store.state.announce.displayPage;
    },
  },
  watch: {
    displayLimit() {
      this.getAnnounceList();
    },
    displaySort() {
      this.getAnnounceList();
    },
    displayAnnounceStatus() {
      this.getAnnounceList();
    },
    displayAnnounceAddAccount() {
      this.getAnnounceList();
    },
    displaySearchAddDateBegin() {
      this.getAnnounceList();
    },
    displaySearchAddDateEnd() {
      this.getAnnounceList();
    },
    displaySearchUpdDateBegin() {
      this.getAnnounceList();
    },
    displaySearchUpdDateEnd() {
      this.getAnnounceList();
    },
    displaySearchAnnounceCol() {
      this.getAnnounceList();
    },
    displaySearchAnnounce() {
      this.getAnnounceList();
    },
    displaySearchCategory() {
      this.getAnnounceList();
    },
    displayPage() {
      this.getAnnounceList();
    },
  },
  methods: {
    ...mapActions('authority', ['fetchAllAuthority']),
    ...mapActions('enduser', ['getUserInfo']),
    mergeProps,
    // モーダルを閉じる
    closeRequest() {
      this.displayAnnounceRequestConfirm = false;
    },
    closeApproval() {
      this.displayAnnounceApprovalConfirm = false;
    },
    closeReturn() {
      this.displayAnnounceReturnApprovalConfirm = false;
    },
    closeCancel() {
      this.displayAnnounceCancelConfirm = false;
    },
    closeAction() {
      this.displayAnnounceDeleteConfirm = false;
      // window.location.reload();
    },
    closePreview(){
      this.displayAnnouncePreview = false;
    },
    
    getAnnounceList() {
      this.loading = true;
      axios
        .get("/api/announce", {
          params: {
            limit:
              this.$store.state.announce.displayLimit,
            offset:
              this.$store.state.announce.displayLimit * (this.$store.state.announce.displayPage - 1),
            sort:
              this.$store.state.announce.displaySort,
            announceStatus:
              this.$store.state.announce.displayAnnounceStatus,
            announceAddAccount:
              this.$store.state.announce.displayAnnounceAddAccount,
            searchAddDateBegin:
              this.$store.state.announce.displaySearchAddDateBegin,
            searchAddDateEnd:
              this.$store.state.announce.displaySearchAddDateEnd,
            searchUpdDateBegin:
              this.$store.state.announce.displaySearchUpdDateBegin,
            searchUpdDateEnd:
              this.$store.state.announce.displaySearchUpdDateEnd,
            searchAnnounceCol:
              this.$store.state.announce.displaySearchAnnounceCol,
            searchAnnounce:
              this.$store.state.announce.displaySearchAnnounce,
            searchCategory:
              this.$store.state.announce.displaySearchCategory,
          },
        })
        .then((res) => {
          this.announce = res.data.anounce;
          this.$store.dispatch("announce/setTotalCount", res.data.count);
          this.loading = false;
          this.getItems2List();
        });
    },

    getAnnounceLength() {
      if (!this.announce) {
        return 0;
      }
      console.log(this.announce.length)
      return this.announce.length;
    },

    // 承認ステータスフォーマット
    approvalStatusFormat(announceApprovalStatus) {
      let approvalStatus = '';
      let step = this.approvalStatusArray.length;
      for (var i = 0; i < step; i++) {
        const approvalStatusValue = this.approvalStatusArray[i].value;
        if (approvalStatusValue == announceApprovalStatus) {
          approvalStatus = this.approvalStatusArray[i].status;
        }
      }
      return approvalStatus;
    },

    getListItems() {
      let listsItemKey = this.$store.state.announce.displayListsItemKey;

      // 承認済みタブ
      if (listsItemKey == "checkedLists") {
        this.listItems = [
          {
            title: "詳細を確認",
            link: "announce.detail",
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
            link: "announce.detail",
          },
          { title: "承認する", link: "announce.approval" },
          { title: "差し戻す", link: "announce.approval" },
        ];
        this.menuDeleteAnnounce = [{ title: "削除" }];

      // 全ての投稿タブ
      } else if (listsItemKey == "allLists") {
        this.listItems = [
          {
            title: "詳細を確認",
            link: "announce.detail",
          },
          { title: "共有リンクをコピー" },
          { title: "公開停止" },
        ];
        this.menuDeleteAnnounce = [{ title: "削除" }];
      }

    },

    // 選択した記事をstoreに設定
    setSelectItems() {
      this.$store.dispatch("announce/setDisplayCheckedItems", this.select);
    },

    // 削除確認ダイアログに渡せるため、IDをstoreに設定
    setDeleteAnnounceId(id) {
      let announceId = id;
      this.$store.dispatch("announce/setDeleteAnnounceId", announceId);
    },
    // 承認確認ダイアログに渡せるため、IDをstoreに設定
    setApprovalAnnounceId(id) {
      let announceId = id;
      this.$store.dispatch("announce/setApprovalAnnounceId", announceId);
    },

    // 承認確認ダイアログに渡せるため、IDをstoreに設定
    setApprovalAnnounceId(id) {
      let announceId = id;
      this.$store.dispatch("announce/setApprovalAnnounceId", announceId);
    },

    // お知らせIDをstoreに設定
    setAnnounceId(id) {
      this.$store.dispatch("announce/setAnnounceId", id);
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
          this.$store.state.announce.approvalReturnComment,
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

    getClientItemsLength(){
      this.dataTable = this.$refs.dataTable.clientItemsLength;
    },

    operateidChange: function(id) {
      const postData = {
        id: id,
      };
      this.operate_id = id;
    },

    allCheckedItemOperate(){
      if(this.operate_id == '1'){
        for(var i = 0;i < this.selected.length; i++){
          if(this.selected[i].approval_status == 1){
            axios.post("/api/announce/" + this.selected[i].id + "/approval").then((res) => {});
          }
        }
        window.location.reload();
      }else if(this.operate_id == '2'){
        for(var i = 0;i < this.selected.length; i++){
          axios.delete("/api/announce/" + this.selected[i].id).then((res) => {});
        }
        window.location.reload();
      }else{
        //「承認か削除を選んでください」的なモーダルを出す処理が必要か…？
      }
      console.log(this.selected)
    },

    inReleaseFlg(announce) {
      // 公開期間中 or 公開期間外判定してbooleanで返す
      var now = moment();
      let start = moment(announce.start_date)
      let end = moment(announce.end_date)
      return now.isBetween(start, end)
    },

    //一括承認を表示する/非表示にする
    getItems2List(){
      if(this.approval_auth_flg){
        if(this.items2.length == 2){
          if(this.$store.state.announce.displayAnnounceStatus == 3 || this.$store.state.announce.displayAnnounceStatus == 0){
            this.items2 = this.items2.slice(1);
          }
        }else if(this.items2.length == 1){
          if(this.$store.state.announce.displayAnnounceStatus == 1 || this.$store.state.announce.displayAnnounceStatus == 2){
            this.items2 = [ 
              {id: 1, text: "一括承認" },
              {id: 2, text: "一括削除" }
            ]
          }
        }
      }
    },

    // 承認ステータスに応じて文字を返す
    getApprovalStatus(status) {
      if (status === 0) {
        // 0:下書きの場合
        return "下書き"
      } else if (status === 1) {
        // 1:承認待ちの場合
        return "承認待ち"
      } else if (status === 2) {
        // 2:承認済みの場合
        return "承認済み"
      } else if (status === 3) {
        // 3:差戻しの場合
        return "差戻し"
      }
    },

    // 承認ステータスに応じて文字色を返す
    getApprovalStatusColor(status) {
      if (status === 0) {
        // 0:下書きの場合
        return "stastus-font__grey"
      } else if (status === 1) {
        // 1:承認待ちの場合
        return "stastus-font__orange"
      } else if (status === 2) {
        // 2:承認済みの場合
        return "stastus-font__green"
      } else if (status === 3) {
        // 3:差戻しの場合
        return "stastus-font__red"
      }
    }
  },
  async mounted() {
    this.getAnnounceList();
    this.setSelectItems();
    this.getListItems();
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.delete_auth_flg = authority.delete_auth_flg;
      this.update_auth_flg = authority.update_auth_flg;
      this.create_auth_flg = authority.create_auth_flg;
      this.approval_auth_flg = authority.approval_auth_flg;
      this.request_auth_flg = authority.request_auth_flg;
      if(!this.approval_auth_flg){
        this.items2 = this.items2.slice(1);
      }else{
        this.allCheckedItemOperate()
      }
    }
    let name = await this.getUserInfo();
    if(name){
        this.username = name.name;
    }
    this.dataTable = this.$store.state.announce.totalCount

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

  /* ヘッダーカラー */
  --easy-table-header-font-color: #707070;

  /* アイテムフォントカラー */
  --easy-table-body-row-font-color: #707070;
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


/* 検索フォーム */
.searchform-list {
  position: relative;
  max-width: 300px;
}

.searchform-list > .search-box {
  padding: 10px 30px 10px 8px;
  border-radius: 8px;
  width: 180px;
  background-color:  #f1eeeee4;
}

@media (max-width: 599.99px){
.searchform-list > .search-box{
    width: 150px;
  }
}


.searchform-list > .serch-btn {
  height:50px;
  position:absolute;
  top:-2px;
  background:none;
  color:#666;
  border:none;
  font-size:14px;
  right: 10px;
}

</style>
<style lang="scss">

.v-dialog--fullscreen .v-overlay__content{
    width: 100% !important;
}

.v-dialog--fullscreen .v-overlay__content .v-card{
    padding: 0px !important;
}

// 公開期間中の場合、フォントのウェイトを上げる
.text-inReleaseFlg {
  font-weight: 600;
}

// タイトル、カテゴリーのフォント設定
.announce-title-font {
  font-weight: 600;
  font-size: 1rem;
  color: #69A5AF;
  transition: .4s !important;
  white-space: pre-line;
}
.announce-title-font:hover {
  transition: .4s;
  color: #69A5AF;
  opacity: .6 !important;
}
.announce-title-font_disable {
  font-weight: 600;
  font-size: 1rem;
  color: #666;
  white-space: pre-line;
}
.announce-category-font {
  font-size: 0.75rem;
}

.vue3-easy-data-table__header th.sortable.none .sortType-icon {
  opacity: 1 !important;
}
.vue3-easy-data-table__header th.sortable .sortType-icon {
  margin-top: -6px !important;
}
.vue3-easy-data-table__header th.sortable.desc .sortType-icon {
  margin-top: 5px !important;
}

.thumbnail-image {
  height: 5rem;
  width: auto;
}

// お知らせテーブル サムネイルをSPで非表示にする
@media (max-width: 599.99px){
  .thumbnail-image {
    display: none;
  }
}

.detaTable-header_title {
  align-content: center;
  align-items: center;
  display: grid;
}

// ヘッダーの背景色消す&ホバー時の背景色を薄く
.customize-table {
  --easy-table-body-row-hover-background-color: rgba(238, 238, 238, .1);
  --easy-table-header-background-color: #ffffff !important;
}
thead {
  border-bottom: 1px solid #eee;
}

// 一括処理のセレクトボックス
.action-select .v-field--variant-filled  {
  border: #eee 1px solid !important;
  border-radius: 8px;
  height: 56px;
}

// テーブルのスクロールを消す
.vue3-easy-data-table__main {
  overflow: visible !important;
}

// 外枠を消す
.vue3-easy-data-table {
  border: none !important;
}

// テーブルヘッダーセンタリング
.vue3-easy-data-table__header th .header.direction-left {
  justify-content: center !important;
}

// テーブル要素センタリング
// テーブル要素センタリング、色指定
.vue3-easy-data-table__body td.direction-left {
  text-align: center !important;
  color: #707070 !important;
}

// テーブル要素タイトルのみ左寄せ
.headtitle-left {
  text-align: left !important;
}

// 承認ステータス用のフォントカラー
// 承認待ち
.stastus-font__orange {
  color: orange;
  font-weight: 600;
}
// 差戻し
.stastus-font__red {
  color: #D32F2F;
  font-weight: 600;
}
// 承認済み
.stastus-font__green {
  color: #69A5AF;
  font-weight: 600;
}
// 下書き
.stastus-font__grey {
  color: grey;
  font-weight: 600;
}
</style>