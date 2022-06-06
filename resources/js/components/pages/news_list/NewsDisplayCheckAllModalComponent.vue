<template>
  <v-dialog v-model="display" persistent>
    <v-card>
      <v-card-title> 一括承認 </v-card-title>
      <v-card-text>
        選択したきじの一括承認を行います。内容を確認して「承認」ボタンを押下してください。
      </v-card-text>
      <v-card-actions>
        <v-card-text> {{ this.selected.length }}件</v-card-text>
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
    return {
      selected: [],
    };
  },
  methods: {
    submitAction() {
      if (this.select) {
        this.$store.dispatch("news/setDisplayLimit", this.select);
        this.closeAction();
      }
    },
  },
  mounted() {},
};
</script>