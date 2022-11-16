<template>
  <v-navigation-drawer temporary v-model='this.$store.state.sidebar.open'>
    <v-list nav dense>
      <v-list-item v-for="item in items" :key="item.id" link :to="{ name: item.linkTo }" >

<!--
        <v-list-group v-if="item.group" :value="true">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </template>
          <v-list-item v-for="submenu in item.submenus" v-bind:key="submenu.id" link v-bind:to="{ name: submenu.linkTo }" v-bind:disabled="submenu.disabled" v-show="true">
            <v-list-item-icon>
              <v-icon>{{ submenu.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ submenu.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      <div v-else>
-->
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>

<!--
    <v-list v-for="item in items" :key="item.id" nav dense>
      <div v-if="item.group">
        <v-list-group :value="true">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </template>
          <v-list-item v-for="submenu in item.submenus" v-bind:key="submenu.id" link v-bind:to="{ name: submenu.linkTo }" v-bind:disabled="submenu.disabled" v-show="true">
            <v-list-item-icon>
              <v-icon>{{ submenu.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ submenu.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </div>
      <div v-else>
        <v-list-item link v-bind:to="{ name: item.linkTo }" v-bind:disabled="item.disabled">
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </div>
    </v-list>
-->
</v-navigation-drawer>
</template>

<script>
export default {
  data() {
    return {
      drawer: true,
      items: [
        { id: 1, title: "投稿管理",       icon: "mdi-folder", linkTo: "news.list",   disabled: false, group: false, },
        { id: 2, title: "ギャラリー管理", icon: "mdi-folder", linkTo: "",             disabled: true, group: false, },
        { id: 3, title: "アクセス情報",   icon: "mdi-folder", linkTo: "",             disabled: true, group: false, },
        { id: 4, title: "アカウント管理", icon: "mdi-folder", linkTo: "enduser.list", disabled: false, group: true, 
          submenus: [
            { id: 401, title: "アカウント一覧", icon: "mdi-folder", linkTo: "enduser.list", disabled: false, },
            { id: 402, title: "アカウント登録", icon: "mdi-folder", linkTo: "enduser.register", disabled: false, },
          ],
        },
        { id: 5, title: "契約情報",       icon: "mdi-folder", linkTo: "",             disabled: true, group: false, },
        { id: 6, title: "サイト更新依頼", icon: "mdi-folder", linkTo: "",             disabled: true, group: false, },
        { id: 7, title: "WEBサイトへ",    icon: "mdi-folder", linkTo: "",             disabled: true, group: false, },
      ],
      right: null,
    };
  },
};
</script>