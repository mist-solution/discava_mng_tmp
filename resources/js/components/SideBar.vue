<template>
  <v-navigation-drawer temporary v-model='this.$store.state.sidebar.open'>
    <v-list v-for="item in items" :key="item.id" nav dense>
      <v-list-item link v-bind:to="{ name: item.linkTo }">
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
        {
          id: 1,
          title: "お知らせ一覧",
          icon: "mdi-folder",
          linkTo: "news.list",
        },
        { id: 2, title: "ギャラリー管理", icon: "mdi-folder", linkTo: "" },
        { id: 3, title: "ユーザ一覧", icon: "mdi-folder", linkTo: "enduser.list" },
      ],
      right: null,
    };
  },
};
</script>