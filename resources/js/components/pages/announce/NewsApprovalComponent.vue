<template>
  <back-to-top-component />
  <v-container>
    <v-card-title class="ml-2" width="80%">
      <h3 class="h4">お知らせ承認</h3>
      <div class="btn-group ml-auto">
        <router-link v-bind:to="{ name: 'announce.list' }">
          <button class="btn btn-success mr-2">戻る</button>
        </router-link>
        <button
          class="btn btn-success mr-2"
          @click.stop="
            (displayNewsApprovalRejectConfirm = true),
              setApprovalAnnounce(
                'reject',
                this.AnnounceDetail.id,
                this.AnnounceDetail.approval_status
              )
          "
        >
          否認
        </button>
        <button
          class="btn btn-success mr-2"
          @click.stop="
            (displayNewsApprovalReturnConfirm = true),
              setApprovalAnnounce(
                'return',
                this.AnnounceDetail.id,
                this.AnnounceDetail.approval_status
              )
          "
        >
          差戻し
        </button>
        <button
          class="btn btn-success mr-2"
          @click.stop="
            (displayNewsApprovalConfirm = true),
              setApprovalAnnounce(
                'approval',
                this.AnnounceDetail.id,
                this.AnnounceDetail.approval_status
              )
          "
        >
          承認
        </button>
      </div>
    </v-card-title>
    <v-card>
      <v-row>
        <v-col class="mt-3">
          <v-card-title>タイトル：{{ this.AnnounceDetail.title }}</v-card-title>
          <v-card-title
            >承認ステータス（実装確認用）：{{
              this.AnnounceDetail.approval_status
            }}
          </v-card-title>
          <v-card-title>
            差戻しのコメント（実装確認用）：{{
              this.AnnounceDetail.remand_comment
            }}
          </v-card-title>
          <v-img
            :src="this.AnnounceDetail.imageUrl"
            height="125"
            width="175"
            class="bg-grey-lighten-2"
          ></v-img>
          <v-card-subtitle
            >カテゴリ： {{ this.AnnounceDetailCategory }}</v-card-subtitle
          >
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-card-text>本文：{{ this.AnnounceDetail.contents }}</v-card-text>
        </v-col>
      </v-row>
    </v-card>
    <!-- 承認モーダル -->
    <news-approval-confirm-modal-component
      :display="displayNewsApprovalConfirm"
      :closeAction="closeAction"
      :approvalAnnounceProcess="approvalAnnounceProcess"
    />

    <!-- 差戻しモーダル -->
    <news-approval-return-confirm-modal-component
      :display="displayNewsApprovalReturnConfirm"
      :closeAction="closeAction"
      :approvalAnnounceProcess="approvalAnnounceProcess"
    />

    <!-- 否認モーダル -->
    <news-approval-reject-confirm-modal-component
      :display="displayNewsApprovalRejectConfirm"
      :closeAction="closeAction"
      :approvalAnnounceProcess="approvalAnnounceProcess"
    />
  </v-container>
</template>

<script>
import BackToTopComponent from "../../BackToTopComponent.vue";
import { mapActions } from "vuex";
import NewsApprovalConfirmModalComponent from "../../modals/NewsApprovalConfirmModalComponent.vue";
import NewsApprovalReturnConfirmModalComponent from "../../modals/NewsApprovalReturnConfirmModalComponent.vue";
import NewsApprovalRejectConfirmModalComponent from "../../modals/NewsApprovalRejectConfirmModalComponent.vue";

export default {
  components: {
    BackToTopComponent,
    NewsApprovalConfirmModalComponent,
    NewsApprovalReturnConfirmModalComponent,
    NewsApprovalRejectConfirmModalComponent,
  },
  props: {
    announceId: String,
  },
  data: function () {
    return {
      AnnounceDetail: {},
      AnnounceDetailCategory: null,
      displayNewsApprovalConfirm: false,
      displayNewsApprovalReturnConfirm: false,
      displayNewsApprovalRejectConfirm: false,
    };
  },
  methods: {
    ...mapActions("snackbar", [
      "openSuccess",
      "openWarning",
      "openError",
      "closeSnackbar",
    ]),

    closeAction() {
      this.displayNewsApprovalConfirm = false;
      this.displayNewsApprovalReturnConfirm = false;
      this.displayNewsApprovalRejectConfirm = false;
      // this.$router.push({ name: "announce.list" });
    },

    getAnnounceDetail() {
      axios.get("/api/announce/" + this.announceId).then((res) => {
        this.AnnounceDetail = res.data;
        if (this.AnnounceDetail == 1) {
          this.openError("このお知らせは削除されています");
          this.$router.push({ name: "announce.list" });
          return;
        } else if (this.AnnounceDetail == 9) {
          this.openError("対象が否認しました。");
          this.$router.push({ name: "announce.list" });
          return;
        }
      });
    },

    getAnnounceDetailCategory() {
      axios.get("/api/announceCategory/").then((res) => {
        this.AnnounceDetailCategory = res.data.announceCategorys;
        let categoryKey = this.AnnounceDetail.announce_category_id;
        let arrayLength = this.AnnounceDetailCategory.length;
        let i = 0;
        if (categoryKey) {
          for (i = 0; i < arrayLength; i++) {
            if (categoryKey == res.data.announceCategorys[i].code) {
              this.AnnounceDetailCategory =
                res.data.announceCategorys[i].category;
            }
          }
        } else {
          this.AnnounceDetailCategory = "";
        }
      });
    },

    // 承認・差戻し確認ダイアログに渡せるため、ID、ステータスをstoreに設定
    setApprovalAnnounce(value, id, approval_status) {
      let announceId = id;
      let announceStatus = approval_status;
      let approvalProcessKey = value;
      this.$store.dispatch("news/setApprovalProcessKey", approvalProcessKey);
      this.$store.dispatch("news/setApprovalNewsId", announceId);
      this.$store.dispatch("news/setApprovalNewsStatus", announceStatus);
    },

    // 承認・差戻し・否認処理
    approvalAnnounceProcess(processKey, id, status) {
      let approvalProcessKey = processKey;
      let announceId = id;
      let announceStatus = status;

      switch (approvalProcessKey) {
        case "approval":
          if (announceStatus == "9") {
            this.openError("否認されたお知らせが承認できません。");
          } else if (announceStatus == "1") {
            this.openError("すでに承認されました。");
          } else {
            axios
              .put(
                "/api/announce/" + announceId + "/" + "approval",
                this.announce
              )
              .then((res) => {
                window.location.reload();
                this.openSuccess("承認しました。");
              });
          }
          break;
        case "return":
          if (announceStatus == "9") {
            this.openError("否認されたお知らせが差戻されません。");
          } else if (announceStatus == "1") {
            this.openError("承認されたお知らせが差戻されません。");
          } else {
            axios
              .put("/api/announce/" + announceId + "/" + "return", {
                announce: this.announce,
                approvalReturnComment:
                  this.$store.state.news.approvalReturnComment,
              })
              .then((res) => {
                window.location.reload();
                this.openSuccess("差戻しました。");
              });
          }
          break;
        case "reject":
          if (announceStatus == "9") {
            this.openError("すでに否認されました。");
          } else if (announceStatus == "1") {
            this.openError("承認されたお知らせが否認できません。");
          } else {
            axios
              .put(
                "/api/announce/" + announceId + "/" + "reject",
                this.announce
              )
              .then((res) => {
                window.location.reload();
                this.openSuccess("否認しました。");
              });
          }
          break;
        default:
          break;
      }
    },
  },
  watch: {},
  mounted() {
    this.getAnnounceDetail();
    this.getAnnounceDetailCategory();
  },
};
</script>