<template>
    <v-dialog v-show="display" persistent>
      <v-card class="p-3">
        <!-- モーダルタイトル -->
        <v-card-title class="text-center modal-title"> 削除 </v-card-title>
        <!--  モーダル説明文 -->
        <v-card-text class="text-center mb-3">
          記事の削除を行います。<br />
          よろしければ「削除」ボタンを<br />
          押下してください。
        </v-card-text>
        <!-- 操作 -->
        <v-card-actions class="justify-center">
          <!-- 閉じるボタン -->
          <v-btn @click="closeAction()" class="gray-btn mx-2">閉じる</v-btn>
          <!-- 承認ボタン -->
          <v-btn @click="submitAction()" class="red-btn mx-2">削除</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    props: ["display", "closeAction", "deleteAnnounce"],
    data() {
      return {};
    },
    methods: {
      submitAction() {
        this.deleteAnnounce(this.$store.state.announce.deleteAnnounceId);
        this.closeAction();
        window.location.reload();
      },
    },
    mounted() {},
  };
  </script>