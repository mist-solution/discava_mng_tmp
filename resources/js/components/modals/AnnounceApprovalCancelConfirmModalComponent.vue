<template>
    <v-dialog v-show="display" persistent>
      <v-card class="p-3">
        <!-- モーダルタイトル -->
        <v-card-title class="text-center modal-title"> 取り下げ </v-card-title>
        <!--  モーダル説明文 -->
        <v-card-text class="text-center mb-3">
          記事の取り下げを行います。<br />
          よろしければ「取り下げ」ボタンを<br />
          押下してください。
        </v-card-text>
        <!-- 取り下げコメント -->
        <!-- <v-textarea
          outlined
          v-model="returnComment"
          name="returnComment"
          label="取り下げコメント"
          class="mx-md-4 mb-4"
        >
        </v-textarea> -->
        <!-- 操作 -->
        <v-card-actions class="justify-center">
          <!-- 閉じるボタン -->
          <v-btn @click="closeAction()" class="gray-btn mx-2">閉じる</v-btn>
          <!-- 取り下げボタン -->
          <v-btn @click="submitAction()" class="green-btn mx-2">取り下げ</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    props: ["display", "closeAction", "approvalCancel"],
    data() {
      return {
        returnComment: null,
      };
    },
    methods: {
      submitAction() {
        // 取り下げのコメントをstateに設定
        this.$store.dispatch("announce/setApprovalReturnComment", this.returnComment);
  
        // 取り下げる処理
        this.approvalCancel(
          this.$store.state.announce.approvalAnnounceId,
          this.$store.state.announce.approvalAnnounceStatus
        );

        this.closeAction();
      },
    },
    mounted() {},
  };
  </script>