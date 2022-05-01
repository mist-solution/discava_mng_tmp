<template>
  <v-dialog v-model="display" persistent>
    <v-card>
      <v-card-title> 表示件数 </v-card-title>
      <v-card-text>
        表示件数を指定し、「決定」ボタンを押下してください。
      </v-card-text>
      <v-card-actions>
        <v-select
          v-model="select"
          :items="items"
          :rules="[(v) => !!v || 'Item is required']"
          label="表示件数"
          required
        ></v-select>
      </v-card-actions>
      <v-card-actions>
        <v-btn @click="closeAction()">閉じる</v-btn>
        <v-btn color="primary" @click="submitAction()">決定</v-btn>
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
      items: [10, 20, 30, 40, 50],
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