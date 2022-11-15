<template>
  <v-navigation-drawer temporary v-model='this.$store.state.sidebar.open'>
    <v-list v-for="item in items" :key="item.id" nav dense>
      <v-list-item link v-bind:to="{ name: item.linkTo }" {{ item.disabled }}>
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        <v-list-item-title>{{ item.title }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>
<script>
export default {
  data() {
    return {
      drawer: true,
      items: [
        { id: 1,  title: "投稿管理",        icon: "mdi-folder",  linkTo: "news.list",   disabled: "", },
        { id: 2,  title: "ギャラリー管理",  icon: "mdi-folder",  linkTo: "",             disabled: "disabled", },
        { id: 3,  title: "アクセス情報",    icon: "mdi-folder",  linkTo: "",             disabled: "disabled", },
        { id: 4,  title: "アカウント管理",  icon: "mdi-folder",  linkTo: "",             disabled: "", },
//          submenu: [
//          { id: 401,  title: "アカウント一覧",  icon: "mdi-folder",  linkTo: "enduser.list", disabled: "", },
//          { id: 402,  title: "アカウント一覧",  icon: "mdi-folder",  linkTo: "enduser.register", disabled: "", },
//          ] },
        { id: 5,  title: "契約情報",        icon: "mdi-folder",  linkTo: "",             disabled: "disabled", },
        { id: 6,  title: "サイト更新依頼",  icon: "mdi-folder",  linkTo: "",             disabled: "disabled", },
        { id: 7,  title: "WEBサイトへ",     icon: "mdi-folder",  linkTo: "",             disabled: "disabled", },
      ],
      right: null,
    };
  },
};
</script>