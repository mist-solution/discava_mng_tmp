<template>
    <v-dialog v-show="display" persistent>
      <v-card>
        <!-- モーダルタイトル -->
        <v-card-title class="text-center modal-title"> 並び順 </v-card-title>
        <!--  モーダル説明文 -->
        <v-card-text class="text-center mb-3">
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
        <!-- 操作 -->
        <v-card-actions class="justify-center">
          <!-- 閉じるボタン -->
          <v-btn @click="closeAction()" class="gray-btn mx-2">閉じる</v-btn>
          <!-- 並べ替えるボタン -->
          <v-btn color="primary" @click="submitAction()" class="red-btn mx-2">並べ替える</v-btn>
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
        sorts: [
          "登録日の昇順",
          "登録日の降順",
          "更新日の昇順",
          "更新日の降順",
          "タイトルの昇順",
          "タイトルの降順",
        ],
      };
    },
    methods: {
      submitAction() {
        let sort = null;
        if (this.select) {
          switch (this.select) {
            case "登録日の昇順":
              sort = "created_at";
              break;
            case "登録日の降順":
              sort = "created_at_desc";
              break;
            case "更新日の昇順":
              sort = "updated_at";
              break;
            case "更新日の降順":
              sort = "updated_at_desc";
              break;
            case "タイトルの昇順":
              sort = "title";
              break;
            case "タイトルの降順":
              sort = "title_desc";
              break;
            default:
              sort = "id";
              break;
          }
          this.$store.dispatch("news/setDisplaySort", sort);
          this.closeAction();
        }
      },
    },
    mounted() {},
  };
  </script>