<template>
  <v-dialog v-model="display" persistent>
    <v-card>
      <v-card-title> 一括承認 </v-card-title>
      <v-card-text>
        選択したきじの一括承認を行います。内容を確認して「承認」ボタンを押下してください。
      </v-card-text>
      <v-card-actions>
        <v-card-text> 承認するお知らせ </v-card-text>
        <v-card-text>
          {{ $store.state.news.displayCheckedItems.length }}
        </v-card-text>
        <v-card-text> 件 </v-card-text>
      </v-card-actions>
      <v-card-actions>
        <v-btn @click="closeAction()">閉じる</v-btn>
        <v-btn color="primary" @click="submitAction()">承認</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: ["display", "closeAction"],
  data() {
    return {};
  },
  methods: {
    submitAction() {
      let getSelectItems = this.$store.state.news.displayCheckedItems;
      for (var i = 0; i < getSelectItems.length; i++) {
        const NewsId = getSelectItems[i];
        axios.get("/api/announce/" + NewsId).then((res) => {
          this.announce = res.data;
        });

        axios.put("/api/announce/" + NewsId, this.announce).then((res) => {
          console.log(this.$router);
        });
      }
      this.closeAction();
    },
  },
  mounted() {},
};
</script>