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
            </v-container>
        </v-main>

        <v-footer app>
            <!-- -->
        </v-footer>
    </v-app>
</template>
<script>
import SideBar from "./SideBar.vue"
import HeaderComponent from "./HeaderComponent.vue"
export default {
    data () {
      return {
        items: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard' },
          { title: 'Photos', icon: 'mdi-image' },
          { title: 'About', icon: 'mdi-help-box' },
        ],
        right: null,
      }
    },
   components: {
       SideBar,
       HeaderComponent,
   }
};
</script>
