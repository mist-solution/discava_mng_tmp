<template>
    <v-dialog v-show="display" persistent>
      <v-card class="p-3">
        <!-- モーダルタイトル -->
        <v-card-title class="text-center modal-title"> 差戻し </v-card-title>
        <!--  モーダル説明文 -->
        <v-card-text class="text-center mb-3">
          記事の差戻しを行います。<br />
          よろしければ「差戻し」ボタンを<br />
          押下してください。
        </v-card-text>
        <!-- 差戻しコメント -->
        <v-textarea
          outlined
          v-model="returnComment"
          name="returnComment"
          label="差戻しコメント"
          class="mx-md-4 mb-4"
        >
        </v-textarea>
        <!-- 操作 -->
        <v-card-actions class="justify-center">
          <!-- 閉じるボタン -->
          <v-btn @click="closeAction()" class="gray-btn mx-2">閉じる</v-btn>
          <!-- 差戻しボタン -->
          <v-btn @click="submitAction()" class="green-btn mx-2">差戻し</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    props: ["display", "closeAction", "approvalReturn"],
    data() {
      return {
        returnComment: null,
      };
    },
    methods: {
      submitAction() {
        // 差戻しのコメントをstateに設定
        this.$store.dispatch("announce/setApprovalReturnComment", this.returnComment);
  
        // 差戻す処理
        this.approvalReturn(
          this.$store.state.announce.approvalAnnounceId,
          this.$store.state.announce.approvalAnnounceStatus
        );
        this.closeAction();
      },
    },
    mounted() {},
  };
  </script>