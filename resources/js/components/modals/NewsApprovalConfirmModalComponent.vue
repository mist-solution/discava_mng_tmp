<template>
    <v-dialog width="auto" v-show="display" persistent>
      <v-card>
        <v-card-title> 承認 </v-card-title>
        <v-card-text class="text-center">
          記事の承認を行います。<br />
          よろしければ「承認」ボダンを<br />
          押下してください。
          <br />
          <br />
        </v-card-text>
        <v-card-actions>
          <v-btn @click="closeAction()">閉じる</v-btn>
          <v-btn color="primary" @click="submitAction()">承認</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    props: ["display", "closeAction", "approvalAnnounceProcess"],
    data() {
      return {};
    },
    methods: {
      submitAction() {
        this.approvalAnnounceProcess(
          this.$store.state.news.approvalProcessKey,
          this.$store.state.news.approvalNewsId,
          this.$store.state.news.approvalNewsStatus
        );
        this.closeAction();
        window.location.reload();
      },
    },
    mounted() {},
  };
  </script>