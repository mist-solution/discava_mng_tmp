<template>
  <back-to-top-component />
  <v-container>
    <v-card-title class="ml-2" width="80%">
      <h3 class="h4">お知らせ詳細・削除</h3>
      <div class="btn-group ml-auto">
        <router-link v-bind:to="{ name: 'announce.list' }">
          <button class="btn btn-success mr-2">戻る</button>
        </router-link>
        <router-link v-bind:to="{ name: 'announce.list' }">
          <button class="btn btn-success mr-2">編集</button>
        </router-link>
        <button
          class="btn btn-success mr-2"
          @click.stop="displayAnnounceDeleteConfirm = true"
        >
          削除
        </button>
      </div>
    </v-card-title>
    <v-card>
      <v-row>
        <v-col class="mt-3">
          <v-card-title>タイトル：{{ this.AnnounceDetail.title }}</v-card-title>
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
    <!-- 削除モーダル -->
    <announce-delete-confirm-modal-component
      :display="displayAnnounceDeleteConfirm"
      :closeAction="closeAction"
      :deleteAnnounce="deleteAnnounce"
    />
  </v-container>
</template>

<script>
import BackToTopComponent from "../../BackToTopComponent.vue";
import { mapActions } from "vuex";
import AnnounceDeleteConfirmModalComponent from "../../modals/AnnounceDeleteConfirmModalComponent.vue";

export default {
  components: {
    BackToTopComponent,
    AnnounceDeleteConfirmModalComponent,
  },
  props: {
    announceId: String,
  },
  data: function () {
    return {
      AnnounceDetail: {},
      AnnounceDetailCategory: null,
      displayAnnounceDeleteConfirm: false,
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
      this.displayAnnounceDeleteConfirm = false;
    },

    getAnnounceDetail() {
      axios.get("/api/announce/" + this.announceId).then((res) => {
        this.AnnounceDetail = res.data;
        if (this.AnnounceDetail == 1) {
          this.openError("このお知らせは削除されています");
          this.$router.push({ name: "announce.list" });
          return;
        } else {
          // ダイアログに渡せるため、本記事のIDをstoreに設定
          this.$store.dispatch("announce/setDeleteAnnounceId", this.AnnounceDetail.id);
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

    //削除処理
    deleteAnnounce(announceId) {
      axios.delete("/api/announce/" + announceId).then((res) => {});
      this.$router.push({ name: "announce.list" });
    },
  },
  mounted() {
    this.getAnnounceDetail();
    this.getAnnounceDetailCategory();
  },
};
</script>