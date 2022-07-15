<template>
  <v-dialog width="auto" v-model="display" persistent>
    <v-card>
      <v-card-title> 差戻し </v-card-title>
      <v-card-text class="text-center">
        記事の差戻しを行います。<br />
        よろしければ「差戻し」ボダンを<br />
        押下してください。
        <br />
        <br />
      </v-card-text>
      <v-textarea
        outlined
        v-model="returnComment"
        name="returnComment"
        label="コメント"
      ></v-textarea>
      <v-card-actions>
        <v-btn @click="closeAction()">閉じる</v-btn>
        <v-btn color="primary" @click="submitAction()">差戻し</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: ["display", "closeAction", "approvalAnnounceProcess"],
  data() {
    return {
      returnComment: null,
    };
  },
  methods: {
    submitAction() {
      // 差戻しのコメントをstateに設定
      this.$store.dispatch("news/setApprovalReturnComment", this.returnComment);

      // 差戻す処理
      this.approvalAnnounceProcess(
        this.$store.state.news.approvalProcessKey,
        this.$store.state.news.approvalNewsId,
        this.$store.state.news.approvalNewsStatus
      );
      this.closeAction();
    },
  },
  mounted() {},
};
</script>