<template>
    <v-dialog v-show="display" persistent>
      <v-card class="p-3">
        <!-- モーダルタイトル -->
        <v-card-title class="text-center modal-title"> 承認 </v-card-title>
        <!--  モーダル説明文 -->
        <v-card-text class="text-center mb-3">
          記事の承認を行います。<br />
          よろしければ「承認」ボタンを<br />
          押下してください。
        </v-card-text>
        <!-- 操作 -->
        <v-card-actions class="justify-center">
          <!-- 閉じるボタン -->
          <v-btn @click="closeAction()" type="button" class="gray-btn mx-2">閉じる</v-btn>
          <!-- 承認ボタン -->
          <v-btn @click="submitAction()" type="button" class="green-btn mx-2">承認</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    props: ["display", "closeAction", "approvalAnnounce"],
    data() {
      return {};
    },
    methods: {
      submitAction() {
        this.approvalAnnounce(this.$store.state.announce.approvalAnnounceId);
      },
    },
    mounted() {},
  };
  </script>