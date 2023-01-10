<template>
    <v-dialog v-show="display" persistent>
      <v-card class="p-3">
        <!-- モーダルタイトル -->
        <v-card-title class="text-center modal-title"> 一括承認 </v-card-title>
        <!--  モーダル説明文 -->
        <v-card-text class="text-center mb-3">
          選択した記事の一括承認を行います。<br />
          内容を確認して「承認」ボタンを押下してください。
        </v-card-text>
        <!-- お知らせの件数 -->
        <v-card-actions>
          <v-card-text> 承認するお知らせ </v-card-text>
          <v-card-text>
            {{ $store.state.news.displayCheckedItems.length }}
          </v-card-text>
          <v-card-text> 件 </v-card-text>
        </v-card-actions>
        <!-- 操作 -->
        <v-card-actions  class="justify-center">
          <!-- 閉じるボタン -->
          <v-btn @click="closeAction()" class="gray-btn mx-2">閉じる</v-btn>
          <!-- 承認ボタン -->
          <v-btn @click="submitAction()" class="red-btn mx-2">承認</v-btn>
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
      closeChecked(checkUpdated) {
        if (checkUpdated == this.$store.state.news.displayCheckedItems.length) {
        }
        this.closeAction();
      },
  
      submitAction() {
        let getSelectItems = this.$store.state.news.displayCheckedItems;
        let step = getSelectItems.length;
        let checkUpdated = 0;
        for (var i = 0; i < step; i++) {
          const newsId = getSelectItems[i];
          axios.get("/api/announce/" + newsId).then((res) => {
            this.announce = res.data;
          });
          axios.put("/api/announce/" + newsId, this.announce).then((res) => {
            checkUpdated = checkUpdated + 1;
            this.closeChecked(checkUpdated);
          });
        }
      },
    },
    mounted() {},
  };
  </script>