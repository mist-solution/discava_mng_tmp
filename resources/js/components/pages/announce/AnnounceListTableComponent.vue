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
  <v-row v-show="!loading && getAnnounceLength() == 0">
    <v-col>
      お知らせがありません。
    </v-col>
  </v-row> -->

  <!-- searchフォーム -->
  <!-- <v-row class="pt-5 align-center justify-start">
    <v-col
      sm="4"
      cols="6"
      class="d-flex justify-sm-end justify-start"
    >
      <form class="searchform-list">
        <input
          class="searchform search-box"
          type="search"
          placeholder="検索"
          aria-label="Search"
          maxlength="30"
          hide-details="false"
          v-model="searchText"
          @change="getClientItemsLength()"
        />
        <button type="button" class="serch-btn"><v-icon>mdi-magnify</v-icon></button>
      </form>
    </v-col>
  </v-row> -->
  <!-- エラーメッセージ -->
  <validation-errors :errors="validationErrors" v-if="validationErrors" class="allCheckOprErrMsg"/>
  <v-row>
    <v-col class="pt-0">
      <EasyDataTable
        v-if="reset"
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
        :rowsPerPage="rowsPerPage"
        class="announce-table"
        :hide-footer="true"
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
              class="w-100 my-2 action-select manychoice"
            ></v-select>
            <button
              class="green-btn_noTransform mx-2 px-3 py-2"
              type="button"
              @click="allCheckedItemOperate()|allCheckOprErr()"
            >
              実行
            </button>
          </div>
        </template>

        <!-- サムネイル画像 + タイトル + プレビュー -->
        <template #item-title="item">
          <div class="headtitle-left">
            <v-row class="d-flex">
              <!-- プレビュー画像 -->
              <v-col cols="4">
                <div class="my-4 py-4 detaTable-header_img">
                  <img
                    v-if="item.thumbnail_img_path"
                    :src="item.thumbnail_img_path"
                    class="thumbnail-image"
                  >
                  <img
                    v-if="!item.thumbnail_img_path"
                    src="/images/samb-none-image.jpg"
                    class="thumbnail-image"
                  >
                </div>
              </v-col>
              <!-- タイトル - 編集権限あり -->
              <v-col cols="5" class="detaTable-header_title ml-2" v-if="item.title.length < 21">
                <router-link
                  v-if="update_auth_flg"
                  :to="{ name: 'announce.edit', params: { announceId: item.id } }"
                  class="announce-title-font"
                >
                <!-- <p v-if="!inReleaseFlg(item)" class="announce-check_publish_msg">※このお知らせは公開期間を過ぎています。</p> -->
                  {{ item.title }}
                </router-link>
                <!-- タイトル - 編集権限なし -->
                <div v-if="!update_auth_flg" class="announce-title-font_disable">
                  {{ item.title }}
                </div>
                <!-- カテゴリー -->
                <p class="mb-0 announce-category-font category_on" v-if="item.announce_category_id">
                  カテゴリー：{{ item.announce_categories.category_name }}
                </p>
                <p class="mb-0 announce-category-font category_off" v-if="item.announce_category_id">
                  {{ item.announce_categories.category_name }}
                </p>
              </v-col>
              <!-- タイトル - 編集権限あり -->
              <v-col cols="5" class="detaTable-header_title ml-2" v-if="item.title.length > 20">
                <router-link
                  v-if="update_auth_flg"
                  :to="{ name: 'announce.edit', params: { announceId: item.id } }"
                  class="announce-title-font"
                >
                  {{ item.title.slice(0,20) }}...
                </router-link>
                <!-- タイトル - 編集権限なし -->
                <div v-if="!update_auth_flg" class="announce-title-font_disable">
                  {{ item.title.slice(0,20) }}...
                </div>
                <!-- カテゴリー -->
                <p class="mb-0 announce-category-font" v-if="item.announce_category_id">
                  カテゴリー：{{ item.announce_categories.category_name }}
                </p>
              </v-col>
              <!-- プレビュー -->
              <v-col cols="1" class="detaTable-header_preview">
                <button
                  @click="(displayAnnouncePreview = true),
                  setPreviewInfo(item.start_date,item.end_date,item.contents,item.title,item.announce_categories.category_name)"
                  type="button"
                  disabled
                >
                  <v-icon color="grey" large>mdi-eye</v-icon>
                  <p class="mb-0" style="color:grey">プレビュー</p>
                </button>
              </v-col>
            </v-row>
          </div>
        </template>
        <!-- 投稿日 -->
        <template #item-created_at="item">
          <p class="mb-0 detaTable-header-width-mid">
            {{ timestampFormat(item.created_at) }}
          </p>
        </template>
        <!-- 更新日時 -->
        <template #item-updated_at="item">
          <p class="mb-0 detaTable-header-width-mid">
            {{ timestampFormat(item.updated_at) }}
          </p>
        </template>
        <!-- ステータス - 「全ての投稿」タブにのみ表示 -->
        <template #item-open_status="item">
          <!-- 承認ステータス -->
          <p
            v-if="$store.state.announce.displayAnnounceStatus == null"
            class="mb-1"
            :class="getApprovalStatusColor(item.approval_status)"
          >
            {{ getApprovalStatus(item.approval_status) }}
          </p>
          <!-- 公開期間 -->
          <p class="mb-0" :class='[inReleaseFlg(item) ? "text-inReleaseFlg detaTable-header-width-mid" : "detaTable-header-width-mid"]'>
            {{ inReleaseFlg(item)  ? "公開中" : "公開期間外" }}
          </p>
        </template>
        <!-- 操作ボタン -->
        <template #item-actions="item">
          <div class="text-center d-flex">
            <br>
            <v-menu>
              <template v-slot:activator="{ props }" v-if="update_auth_flg">
                <button
                  v-bind="props"
                  icon
                  class="my-3"
                  type="button"
                >
                  <v-icon class="announce_action-btn" color="#69a5af">mdi-dots-horizontal</v-icon>
                </button>
              </template>
              <v-list
              >
              <v-list-item>
                  <v-list-item-title>
                    <div
                      v-if="update_auth_flg"
                      @click="toEditPage(item.id)" role="button"
                    >
                      編集
                    </div>
                  </v-list-item-title>
                </v-list-item>
                <v-list-item v-if="update_auth_flg && item.approval_status === 3">
                  <v-list-item-title>
                    <div 
                      @click="(displayAnnounceRemandComment = true),
                      setRemandComment(item.remand_comment)"
                        role="button">
                      差戻しコメント
                    </div>
                  </v-list-item-title>
                </v-list-item>
                <v-list-item disabled>
                  <v-list-item-title>
                    <div 
                      @click="(displayAnnouncePreview = true),
                        setPreviewInfo(item.start_date,item.end_date,item.contents,item.title,item.announce_categories.category_name)" role="button">
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
        </template>
      </EasyDataTable>
    </v-col>
  </v-row>

  <!-- <v-row
    v-for="item in announce"
    :key="item.id"
    dense
    v-show="!loading && getAnnounceLength() != 0"
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
                        @click.stop="(displayAnnounceDeleteConfirm = true), setDeleteAnnounceId(item.id)"
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
    :title="title"
    :category="category"
    :flg="flg"
  />

  <!-- 差戻しコメント画面モーダル -->
  <announce-remand-comment-modal-component
    :modelValue="displayAnnounceRemandComment"
    @update:modelValue="displayAnnounceRemandComment = $event"
    :closeAction="closeRemandComment"
    :remand_comment="remand_comment"
  />

  <!-- <v-row class="mt-3">
    <announce-list-table-pagination />
  </v-row> -->
</template>

<script>
import { mapActions, mapState } from "vuex";

import AnnounceListTablePagination from "./AnnounceListTablePagination.vue";
import BackToTopComponent from "../../BackToTopComponent.vue";
import {inject, mergeProps } from "vue";
import AnnounceDeleteConfirmModalComponent from "../../modals/AnnounceDeleteConfirmModalComponent.vue";
import AnnounceApprovalConfirmModalComponent from "../../modals/AnnounceApprovalConfirmModalComponent.vue";
import AnnounceApprovalReturnConfirmModalComponent from "../../modals/AnnounceApprovalReturnConfirmModalComponent.vue";
import AnnounceApprovalRequestConfirmModalComponent from "../../modals/AnnounceApprovalRequestConfirmModalComponent.vue"
import AnnounceApprovalCancelConfirmModalComponent from "../../modals/AnnounceApprovalCancelConfirmModalComponent.vue"
import AnnounceRemandCommentModalComponent from "../../modals/AnnounceRemandCommentModalComponent.vue"
import AnnouncePreviewModalComponent from "../../modals/AnnouncePreviewModalComponent.vue"
import moment from 'moment';
import ValidationErrors from "../../ValidationErrors.vue";

export default {
  components: {
    AnnounceListTablePagination,
    BackToTopComponent,
    AnnounceDeleteConfirmModalComponent,
    AnnounceApprovalConfirmModalComponent,
    AnnounceApprovalReturnConfirmModalComponent,
    AnnounceApprovalRequestConfirmModalComponent,
    AnnounceApprovalCancelConfirmModalComponent,
    AnnounceRemandCommentModalComponent,
    AnnouncePreviewModalComponent,
    ValidationErrors,

  },
  data() {
    return {
      selected: [],
      he: [
        { text: 'タイトル', value: 'title'},
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
        { text: '', value: 'imageUrl', sortable: false},
        { text: '', value: 'title'},
        { text: '投稿日', value: 'created_at', sortable: true},
        { text: '最終更新', value: 'updated_at', sortable: true},
        { text: '投稿者', value: 'add_account.name'},
        { text: 'ステータス', value: 'open_status'},
        { text: '操作', value: 'actions'},
        { text: '', value: 'button', sortable: false},
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
      displayAnnounceRemandComment: false,
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
      title: null,
      category: null,
      remand_comment: null,
      username: null,
      searchField: "title",
      searchText: "",
      dataTable: [],
      clientItemsLength: null,
      operate_id: null,
      rowsPerPage: 25,
      reset: true,
      flg: false,
      PageLastIndex: null,
      LastPage: null,
      totalcount :null,
    };
  },
  computed: {
    ...mapState({
      validationErrors: state => state.announce.announceErrorMessages
    }),
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
    displaySearchRelease() {
      return this.$store.state.announce.displaySearchRelease;
    },
    displayPage() {
      return this.$store.state.announce.displayPage;
    },
  },
  watch: {
    displayLimit() {
      this.rowsPerPage = this.$store.state.announce.displayLimit;
      this.getAnnounceList();
      this.PageLastIndex = Math.ceil(this.totalcount/this.rowsPerPage)
      this.$emit("LastPageChange",this.PageLastIndex,this.totalcount)
      this.reset = false;
      this.$nextTick(() => (this.reset = true));
    },
    displaySort() {
      this.getAnnounceList();
    },
    displayAnnounceStatus() {
      this.getAnnounceList();
      setTimeout(() => {
        this.PageLastIndex = Math.ceil(this.totalcount/this.rowsPerPage)
        this.$emit("LastPageChange",this.PageLastIndex,this.totalcount)
      }, 1000);
    },
    displayAnnounceAddAccount() {
      this.getAnnounceList();
      setTimeout(() => {
        this.PageLastIndex = Math.ceil(this.totalcount/this.rowsPerPage)
        this.$emit("LastPageChange",this.PageLastIndex,this.totalcount)
      }, 1000);
    },
    displaySearchAddDateBegin() {
      this.getAnnounceList();
      setTimeout(() => {
        this.PageLastIndex = Math.ceil(this.totalcount/this.rowsPerPage)
        this.$emit("LastPageChange",this.PageLastIndex,this.totalcount)
      }, 1000);
    },
    displaySearchAddDateEnd() {
      this.getAnnounceList();
    },
    displaySearchUpdDateBegin() {
      this.getAnnounceList();
      setTimeout(() => {
        this.PageLastIndex = Math.ceil(this.totalcount/this.rowsPerPage)
        this.$emit("LastPageChange",this.PageLastIndex,this.totalcount)
      }, 1000);
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
      setTimeout(() => {
        this.PageLastIndex = Math.ceil(this.totalcount/this.rowsPerPage)
        this.$emit("LastPageChange",this.PageLastIndex,this.totalcount)
      }, 1000);
    },
    displaySearchRelease() {
      this.getAnnounceList();
      setTimeout(() => {
        this.PageLastIndex = Math.ceil(this.totalcount/this.rowsPerPage)
        this.$emit("LastPageChange",this.PageLastIndex,this.totalcount)
      }, 1000);
    },
    displayPage() {
      this.page = this.$store.state.announce.displayPage;
      this.$refs.dataTable.updatePage(this.page);
      this.getAnnounceList();
    },
  },
  methods: {
    ...mapActions('authority', ['fetchAllAuthority']),
    ...mapActions('enduser', ['getUserInfo']),
    ...mapActions('announceCategory', ['fetchCategories']),
    ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
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
    closeRemandComment(){
      this.displayAnnounceRemandComment = false;
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
            searchRelease:
              this.$store.state.announce.displaySearchRelease,
          },
        })
        .then((res) => {
          this.announce = res.data.anounce;
          this.$store.dispatch("announce/setTotalCount", res.data.count);
          this.totalcount = res.data.count
          this.loading = false;
          this.getItems2List();
        });
    },

    getAnnounceLength() {
      if (!this.announce) {
        return 0;
      }
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
      .then((res) => {
        this.openSuccess('申請しました')
        // スナックバーの表示時間が経ってから実行
        setTimeout(() => {
          this.closeAction();
          this.getAnnounceList();
          this.nullPageCheck();
        }, 1000);
      });
    },

    // 承認処理
    approvalAnnounce(announce) {
      axios.post("/api/announce/" + announce + "/approval")
      .then((res) => {
        this.openSuccess('承認しました')
        // スナックバーの表示時間が経ってから実行
        setTimeout(() => {
          this.closeAction();
          this.getAnnounceList();
          this.nullPageCheck();
        }, 1000);
      });
    },

    // 差戻し処理
    approvalReturn(announceId) {
      axios.put("/api/announce/" + announceId + "/return", {
          announce: this.announce,
          approvalReturnComment:
          this.$store.state.announce.approvalReturnComment,
      }).then((res) => {
        this.openSuccess('差戻しました')
        // スナックバーの表示時間が経ってから実行
        setTimeout(() => {
          this.closeAction();
          this.getAnnounceList();
          this.nullPageCheck();
        }, 1000);
      });
    },

    // 取り下げ処理
    approvalCancel(announceId) {
      axios.put("/api/announce/" + announceId + "/cansel").then((res) => {
        this.openSuccess('取り下げました')
        // スナックバーの表示時間が経ってから実行
        setTimeout(() => {
          this.closeAction();
          this.getAnnounceList();
          this.nullPageCheck();
        }, 800);
      });
    },

    // 削除処理
    deleteAnnounce(announceId) {
      axios.delete("/api/announce/" + announceId).then((res) => {
        this.openSuccess('削除しました')
        // スナックバーの表示時間が経ってから実行
        setTimeout(() => {
          this.closeAction();
          this.getAnnounceList();
          this.nullPageCheck();
        }, 1000);
      });
    },

    timestampFormat(timestamp) {
      const date = new Date(timestamp);
      const dayjs = inject("dayjs");
        return dayjs(timestamp).format("YYYY/MM/DD");
      // return (
      //   date.getFullYear().toString() +
      //   "-" +
      //   (date.getMonth() + 1).toString().padStart(2, "0") +
      //   "-" +
      //   date.getDate().toString().padStart(2, "0")
      // );
    },

    //プレビュー画面に必要な情報をセット
    setPreviewInfo(start_date,end_date,contents,title,category){
      if(start_date != null){
        this.start_date = start_date.slice(0,-3)
      }
      if(end_date != null){
        this.end_date = end_date.slice(0,-3)
      }
      this.contents = contents
      this.title = title
      this.category = category
    },

    //差戻しコメント画面に必要な情報をセット
    setRemandComment(remand_comment){
      if(remand_comment != null){
        this.remand_comment = remand_comment
      }else{
        this.remand_comment = "無し"
      }
    },

    //検索件数
    getClientItemsLength(){
      this.dataTable = this.$refs.dataTable.clientItemsLength;
    },

    operateidChange: function(id) {
      const postData = {
        id: id,
      };
      this.operate_id = id;
    },

    //一括操作
    allCheckedItemOperate(){
      if(this.selected.length != 0){
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
      }
    },
    // 一括操作を実行する場合、エラーメッセージの表示
    allCheckOprErr(){
      // 承認か削除かを未選択の場合。
      if(this.operate_id == null){
        var errMsg = ["操作内容を選択してください。"];
        this.$store.dispatch("announce/setAnnounceErrorMessages", errMsg);
      
      // お知らせ未選択の場合 。
      }else if(this.selected.length == 0){
        if(this.operate_id == '1'){
          var errMsg = ["承認対象の記事を選択してください。"];
          this.$store.dispatch("announce/setAnnounceErrorMessages", errMsg);
        }else if(this.operate_id == '2'){
          var errMsg = ["削除対象の記事を選択してください。"];
          this.$store.dispatch("announce/setAnnounceErrorMessages", errMsg);
        }
      }
    },

    inReleaseFlg(announce) {
      // 公開期間中 or 公開期間外判定してbooleanで返す
      var now = moment();
      let start = moment(announce.start_date).isValid() ? moment(announce.start_date) : null;
      let end = moment(announce.end_date).isValid() ? moment(announce.end_date) : null;
      if (now.isBetween(start, end)){
        return true;
      } else if (start < now && !end){
        return true;
      } else {
        return false;
      }
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
    },


    // 編集ページへ画面遷移
    toEditPage(id) {
      this.$router.push({name: 'announce.edit', params: { announceId: id }})
    },

    //操作後、操作したページにお知らせが無くなった場合に1ページ戻る
    nullPageCheck(){
      if(this.$refs.dataTable.currentPageFirstIndex == this.$refs.dataTable.currentPageLastIndex){
        this.$refs.dataTable.updatePage(this.$refs.dataTable.currentPaginationNumber - 1);
      }
    }
  },
  async mounted() {
     // エラーメッセージ初期化
    this.$store.dispatch("announce/setAnnounceErrorMessages", "");

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
    // 権限が「閲覧者」の場合、「操作」カラムを非表示
    if(authority.authority_set_id == 3){
      var headerRemove = this.headers;
      var toRemove = "操作";
      headerRemove.forEach(function(value, index, array){
        if (value.text == toRemove){
          headerRemove.splice(index, 1);
        }
      });
      this.headers = headerRemove;
    }
    let name = await this.getUserInfo();
    if(name){
        this.username = name.name;
    }
    this.dataTable = this.$store.state.announce.totalCount
    let a = this.$refs.dataTable.clientItemsLength;
    this.PageLastIndex = this.$refs.dataTable.maxPaginationNumber;
    this.$emit("LastPageChange",this.PageLastIndex,a)
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

// .announce-check_publish_msg{
//   font-size: 12px;
//   color: #D32F2F;
//   margin-bottom: 0.2rem;
// }

@media(max-width:1380px){
  .thumbnail-image {
    height: 2rem;
    width: auto;
  }

  .category_on{
    display: none;
  }
}

@media(max-width:1279.9px){

  .detaTable-header_preview > button{
   display: none;
  }
}

@media(min-width:1379.9px){
  .category_off{
    display: none;
  }

}

/* @media(max-width:1067.9px){

  .detaTable-header_preview > button{
   display: none;
  }

  .thumbnail-image {
    height: 2rem;
    width: auto;
  }

} */


.detaTable-header_title {
  display: grid;
  width: 15vw !important;
}

.detaTable-header_img {
  width: 10.7vw !important;
}

.detaTable-header_preview {
  display: grid;
  margin-left: 1rem;
  width: 5vw !important;
}

.detaTable-header_preview > button > p {
  color: #69A5AF;
  font-size: .5rem;
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
.announce-table .vue3-easy-data-table__main {
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
  font-weight: 400 !important;
  font-size: 16px !important;
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
  color: #94CAB1;
  font-weight: 600;
}
// 下書き
.stastus-font__grey {
  color: grey;
  font-weight: 600;
}

// 操作ボタンのアイコンサイズ
.announce_action-btn {
  font-size: 1.5rem;
}

.announce-edit_btn {
  cursor: pointer;
}

.detaTable-header_preview{
  visibility:hidden; 
}

.vue3-easy-data-table__main > table > tbody > tr:hover > .direction-left > 
.headtitle-left > .v-row > .detaTable-header_preview{
  visibility: visible !important;
}

// 一括操作エラーメッセージ
.allCheckOprErrMsg{
  width: 100%;
}
.allCheckOprErrMsg>ul{
  --bs-alert-bg: #ffffff !important;
}

.detaTable-header-width-mid{
  width: 6vw !important;
}
</style>