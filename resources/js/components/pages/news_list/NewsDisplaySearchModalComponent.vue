<template>
  <v-dialog v-model="display" persistent>
    <v-card>
      <v-card-title> 検索 </v-card-title>
      <v-card-text>
        検索条件を入力し、「検索」ボタンを押下してください。
      </v-card-text>

      <v-container>
        <v-row>
          <v-col cols="12" md="6">
            <v-select
              v-model="select"
              :items="items"
              :rules="[(v) => !!v || 'Item is required']"
              label="登録者名"
              required
            ></v-select>
          </v-col>

          <v-col cols="12" md="6">
            <v-select
              v-model="select"
              :items="items"
              :rules="[(v) => !!v || 'Item is required']"
              label="更新者名"
              required
            ></v-select>
          </v-col>

          <v-col cols="12" md="6">
            <v-select
              v-model="select"
              :items="items"
              :rules="[(v) => !!v || 'Item is required']"
              label="カテゴリー"
              required
            ></v-select>
          </v-col>
        </v-row>
      </v-container>
      <v-card-actions>
        <v-btn @click="closeAction()">閉じる</v-btn>
        <v-btn color="primary" @click="submitAction()">検索</v-btn>
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