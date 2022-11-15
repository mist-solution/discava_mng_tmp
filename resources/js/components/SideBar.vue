<template>
  <v-navigation-drawer temporary v-model='this.$store.state.sidebar.open'>
    <v-list v-for="item in items" :key="item.id" nav dense>
      <div v-if="item.group">
        <v-list v-for="submenu in  item.submenus" :key="submenu.id" nav dense>
          <v-list-group v-bind:key="submenu.title">
            <v-list-item link v-bind:to="{ name: submenu.linkTo }" v-bind:disabled="submenu.disabled">
              <v-list-item-icon>
                <v-icon>{{ submenu.icon }}</v-icon>
              </v-list-item-icon>
              <v-list-item-title>TRUE:{{ submenu.title }}</v-list-item-title>
            </v-list-item>
          </v-list-group>
        </v-list>
      </div>
      <div v-else>
        <v-list-item link v-bind:to="{ name: item.linkTo }" v-bind:disabled="item.disabled">
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item>
      </div>
    </v-list>
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
        { id: 4, title: "アカウント管理", icon: "mdi-folder", linkTo: "",             disabled: false, group: true, 
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