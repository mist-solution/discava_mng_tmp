<!-- App.vue -->
<template>
  <v-app clas="vue-app">
    <side-bar />
    <sp-side-bar />
    <v-main>
      <header-component />
      <!-- アプリケーションに適切なgutterを提供 -->
      <v-container class="p-0" fluid>
        <!-- vue-routerを使用する場合 -->
        <router-view></router-view>
        <snackbar />
      </v-container>
    </v-main>

    <v-footer app class="footer">
        <p class="m-0">
        DISCaVa MATE のご利用ありがとうございます。
      </p>
    </v-footer>
  </v-app>
</template>
<script>
import SideBar from "./SideBar.vue";
import SpSideBar from "./SpSideBar.vue";
import HeaderComponent from "./HeaderComponent.vue";
import Snackbar from "./Snackbar.vue";
export default {
  components: {
    SideBar,
    HeaderComponent,
    Snackbar,
    SpSideBar
  },
};
</script>

<style scoped>
/* フッター */
.footer {
  position: relative !important;
  justify-content: end !important;
  z-index: 998 !important;
  background-color: #F7F7F7;
  color: #707070;
  width: 100% !important;
  left: 0 !important;
}
@media (max-width: 600px) {
  .footer {
    font-size: 10px !important;
  }
}
</style>