<!-- App.vue -->
<template>
  <v-app>
    <v-app-bar app>
      <header-component />
    </v-app-bar>
    <side-bar />
    <v-main>
      <!-- アプリケーションに適切なgutterを提供 -->
      <v-container fluid>
        <!-- vue-routerを使用する場合 -->
        <router-view></router-view>
        <snackbar />
      </v-container>
    </v-main>

    <v-footer app>
      <!-- -->
    </v-footer>
  </v-app>
</template>
<script>
import SideBar from "./SideBar.vue";
import HeaderComponent from "./HeaderComponent.vue";
import Snackbar from "./Snackbar.vue";
export default {
  components: {
    SideBar,
    HeaderComponent,
    Snackbar,
  },
};
</script>
