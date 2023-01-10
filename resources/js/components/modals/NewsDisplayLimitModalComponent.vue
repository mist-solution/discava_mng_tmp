<template>
  <v-dialog v-show="display" persistent>
    <v-card>
      <!-- モーダルタイトル -->
      <v-card-title class="text-center modal-title"> 表示件数 </v-card-title>
      <!--  モーダル説明文 -->
      <v-card-text class="text-center mb-3">
        表示件数を指定し、「決定」ボタンを押下してください。
      </v-card-text>
      <!-- 表示件数 -->
      <v-card-actions>
        <v-select
          v-model="select"
          :items="items"
          :rules="[(v) => !!v || 'Item is required']"
          label="表示件数"
          required
        ></v-select>
      </v-card-actions>
      <!-- 操作 -->
      <v-card-actions class="justify-center">
        <!-- 閉じるボタン -->
        <v-btn @click="closeAction()" class="gray-btn mx-2">閉じる</v-btn>
        <!-- 決定ボタン -->
        <v-btn @click="submitAction()" class="red-btn mx-2">決定</v-btn>
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