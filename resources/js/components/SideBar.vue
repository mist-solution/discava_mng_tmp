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

    <v-select
      dense
      v-model="shopSelect"
      :items="usershops"
      item-value="id"
      item-title="shop_name"
    ></v-select>

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
import { mapGetters, mapActions } from "vuex";

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
    };
  },
  methods: {
    ...mapActions('shopUser', ['fetchShopUsers']),
    ...mapActions('shopUser', ['fetchShopSelect']),

    getShopSelect() {
      console.log("sidebar mounted.");

      const shopuser = this.getShopSelectData();
      this.shopSelect = {};
      // 本当は設定したい。
      // this.shopSelect.shop_id = shopuser.shop_id;
      // this.shopSelect.shop_name = shopuser.shop_name;
      this.shopSelect.shop_id = 1;
      this.shopSelect.shop_name = "本社";
      console.log(this.shopSelect.shop_id);
      console.log(this.shopSelect.shop_name);


    },

  },
  computed: {
    ...mapGetters("shopUser", ["shopUsers", "getShopSelectData"]),
    usershops: {
      get() {
        return this.shopUsers;
      }
    },
  },
  mounted() {
    this.getShopSelect();
  },
  created() {
    this.fetchShopUsers();
    this.fetchShopSelect();
  },
};
</script>