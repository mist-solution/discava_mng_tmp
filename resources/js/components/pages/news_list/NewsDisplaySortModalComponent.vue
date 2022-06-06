<template>
  <v-dialog v-model="display" persistent>
    <v-card>
      <v-card-title> 並び順 </v-card-title>
      <v-card-text>
        並び順を指定し、「並べ替える」ボタンを押下してください。
      </v-card-text>
      <v-card-actions>
        <v-select
          v-model="select"
          :items="sorts"
          item-text="value"
          item-value="key"
          :rules="[(v) => !!v || 'Item is required']"
          label="並び順"
          placeholder="並び順を選択してください。"
          required
        ></v-select>
      </v-card-actions>
      {{ this.select }}
      <v-card-actions>
        <v-btn @click="closeAction()">閉じる</v-btn>
        <v-btn color="primary" @click="submitAction()">並べ替える</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: ["display", "closeAction"],
  data() {
    return {
      select: null,
      sorts: ["ID", "ステータス"],
    };
  },
  methods: {
    submitAction() {
      if (this.select) {
        switch (this.select) {
          case "ID":
            this.select = "id";
            break;
          case "ステータス":
            this.select = "approval_status";
            break;
          default:
            this.select = "id";
            break;
        }
        this.$store.dispatch("news/setDisplaySort", this.select);
        this.closeAction();
      }
    },
  },
  mounted() {},
};
</script>