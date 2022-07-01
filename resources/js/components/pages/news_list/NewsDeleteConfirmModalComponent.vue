<template>
  <v-dialog v-model="display" persistent>
    <v-card>
      <v-card-title> 削除 </v-card-title>
      <v-card-text class="text-center">
        記事の削除を行います。<br />
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
  props: ["display", "closeAction", "deleteAnnounce"],
  data() {
    return {};
  },
  methods: {
    submitAction() {
      console.log(this.$store.state.news.deleteNewsId);
      this.deleteAnnounce(this.$store.state.news.deleteNewsId);
      this.closeAction();
    },
  },
  mounted() {},
};
</script>