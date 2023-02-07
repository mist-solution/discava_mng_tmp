<template>
    <v-dialog v-show="display" persistent>
      <v-card class="p-3">
        <!-- モーダルタイトル -->
        <v-card-title class="text-center modal-title"> 否認 </v-card-title>
        <!--  モーダル説明文 -->
        <v-card-text class="text-center mb-3">
          記事の否認を行います。<br />
          よろしければ「否認」ボタンを<br />
          押下してください。
        </v-card-text>
        <!-- 操作 -->
        <v-card-actions class="justify-center">
          <!-- 閉じるボタン -->
          <v-btn @click="closeAction()" class="gray-btn mx-2">閉じる</v-btn>
          <!-- 承認ボタン -->
          <v-btn color="primary" @click="submitAction()" class="green-btn mx-2">否認</v-btn>
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
          this.$store.state.announce.approvalProcessKey,
          this.$store.state.announce.approvalAnnounceId,
          this.$store.state.announce.approvalAnnounceStatus
        );
        this.closeAction();
      },
    },
    mounted() {},
  };
  </script>