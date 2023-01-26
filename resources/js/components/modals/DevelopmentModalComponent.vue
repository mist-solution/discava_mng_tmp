<template>
    <v-dialog v-show="display" persistent>
      <v-card class="p-3">
        <!-- モーダルタイトル -->
        <v-card-title class="text-center modal-title">
          <v-icon color="#707070" x-large>mdi-vlc</v-icon>
        </v-card-title>
        <!--  モーダル説明文 -->
        <v-card-text class="text-center mb-3">
          ただいま開発中です。<br />
          完成までもう少々お待ちください。
        </v-card-text>
        <!-- 操作 -->
        <v-card-actions class="justify-center">
            <!-- 閉じるボタン -->
            <v-btn @click="closeAction()" class="gray-btn mx-2">閉じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    props: ["closeAction"],
    data() { return {}; },
    methods: {},
    mounted() {},
  };
  </script>