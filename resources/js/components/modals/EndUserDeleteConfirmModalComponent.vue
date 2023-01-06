<template>
    <v-dialog
      :modelValue="display"
      @update:modelValue="$emit('update:display', $event)"
      persistent
    >
      <v-card>
        <v-card-title> 削除 </v-card-title>
        <v-card-text class="text-center">
          アカウントの削除を行います。<br />
          よろしければ「削除」ボダンを<br />
          押下してください。
          <br />
          <br />
        </v-card-text>
        <v-card-actions>
          <v-btn @click="closeAction()">閉じる</v-btn>
          <v-btn color="primary" @click="submitAction()">削除</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    props: ["display", "closeAction", "deleteUser"],
    data() {
      return {};
    },
    methods: {
      submitAction() {
        this.deleteUser(this.$store.state.enduser.deleteUserId);
        this.closeAction();
        window.location.reload();
      },
    },
    mounted() {},
  };
  </script>