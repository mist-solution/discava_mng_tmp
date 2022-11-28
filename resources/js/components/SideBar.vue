<template>
  <v-navigation-drawer temporary v-model='this.$store.state.sidebar.open'>

    <v-row>
      <v-col align="center">
        <v-img
          src="/images/icon_user_beige.png"
          max-height="96"
          max-width="96"
          contain>
        </v-img>
      </v-col>
    </v-row>

    <v-select v-model="shopSelect">
      <option
        v-for="shop in shops"
        :value="shop.id"
        :key="shop.id"
      >
        {{ shop.label }}
      </option>
    </v-select>

    <v-list nav dense>

      <div v-for="item in items" :key="item.id">

        <v-list-group
          v-if="item.group"
          :value="item.title"
        >
          <template v-slot:activator="{ props }">
            <v-list-item
              v-bind="props"
              :prepend-icon="item.icon"
              :title="item.title"
              :disabled="item.disabled"
            ></v-list-item>
          </template>
          <v-list-item
            v-for="submenu in item.submenus"
            :key="submenu.id"
            :title="submenu.title"
            link
            :to="{ name: submenu.linkTo }"
            :disabled="submenu.disabled"
          ></v-list-item>
        </v-list-group>
        
        <v-list-item
          v-else
          :prepend-icon="item.icon"
          :title="item.title"
          link
          :to="{ name: item.linkTo }"
          :disabled="item.disabled"
        ></v-list-item>
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
        { id: 1, title: "投稿管理", icon: "mdi-bullhorn-variant-outline", linkTo: "news.list", disabled: false, group: false, },
        { id: 2, title: "ギャラリー管理", icon: "mdi-image-outline", linkTo: "", disabled: true, group: false, },
        { id: 3, title: "アクセス情報", icon: "mdi-chart-bar", linkTo: "", disabled: true, group: false, },
        { id: 4, title: "アカウント管理", icon: "mdi-account", linkTo: "enduser.list", disabled: false, group: true, 
          submenus: [
            { id: 401, title: "アカウント一覧", linkTo: "enduser.list", disabled: false, },
            { id: 402, title: "アカウント登録", linkTo: "enduser.register", disabled: false, },
          ],
        },
        { id: 5, title: "契約情報", icon: "mdi-file-document-edit-outline", linkTo: "", disabled: true, group: false, },
        { id: 6, title: "サイト更新依頼", icon: "mdi-refresh", linkTo: "", disabled: true, group: false, },
        { id: 7, title: "WEBサイトへ", icon: "mdi-tab", linkTo: "", disabled: true, group: false, },
      ],
      right: null,
      shops: [
        { id: 1, label: "本社" },
        { id: 2, label: "高松支社" },
      ],
      shopSelect: "本社",
    };
  },
};
</script>