<template>
  <div class="pc_sidebar">
    <v-navigation-drawer
      v-model="drawer"
      :rail="rail"
      permanent
    >

      <v-container class="mt-5">
        <div v-if="!rail" class="logo">
          <v-row>
            <v-col align="center">
              DISCaVa MATE
            </v-col>
          </v-row>
        </div>

        <v-row>
          <v-col align="center">
            <v-img
              src="/images/user-icon/kkrn_icon_user_11.png"
              max-height="96"
              max-width="96"
              contain>
            </v-img>
          </v-col>
        </v-row>

        <div v-if="!rail">
          <v-row>
            <v-col align="center">
            {{ companyName }}
            </v-col>
          </v-row>
        </div>
        <div v-if="rail">
          <v-row>
            <v-col align="center">
            {{ shopSelection.shop_name }}
            </v-col>
          </v-row>
        </div>
      </v-container>
      <div class="shopsel">
        <div v-if="!rail" class="shopsel_max">
          <v-select
            dense
            solo
            v-model="shopSelection"
            :items="usershops"
            item-value="shop_id"
            item-title="shop_name"
            @update:modelValue="onShopSelectionChange"
          >
          <template v-slot:append-item>
            <v-divider class="mb-2" style="color: white;"></v-divider>
            <v-list-item @click="logout">
              <v-list-content>
                <v-list-title style="color: white;">
                  ログアウト
                </v-list-title>
              </v-list-content>
            </v-list-item>
          </template>
          </v-select>
        </div>
        <div v-if="rail" class="shopsel_min">
          <v-select
            dense
            solo
            :items="usershops"
            item-value="shop_id"
            item-title="shop_name"
            @update:modelValue="onShopSelectionChange"
          >
          <template v-slot:append-item>
            <v-divider class="mb-2" style="color: white;"></v-divider>
            <v-list-item @click="logout">
              <v-list-content>
                <v-list-title style="color: white;">
                  ログアウト
                </v-list-title>
              </v-list-content>
            </v-list-item>
          </template></v-select>
        </div>
      </div>

      <!-- メニュー -->
      <div class="sidebar_list sidebar_list-margin-top">
        <v-list nav dense>

          <div v-for="item in items" :key="item.id">

            <v-list-group
              v-if="item.group"
              :value="item.title"
            >
              <template v-slot:activator="{ props }">
                <v-list-item
                  tile
                  v-bind="props"
                  :prepend-icon="item.icon"
                  :title="item.title"
                  :disabled="item.disabled"
                  color="blue lighten-5"
                ></v-list-item>
              </template>
              <v-list-item
                tile
                v-for="submenu in item.submenus"
                :key="submenu.id"
                :title="submenu.title"
                link
                :to="{ name: submenu.linkTo }"
                :disabled="submenu.disabled"
              ></v-list-item>
            </v-list-group>

            <v-list-item
              tile
              v-else
              :prepend-icon="item.icon"
              :title="item.title"
              link
              :to="{ name: item.linkTo }"
              :disabled="item.disabled"
              color="blue lighten-5"
            ></v-list-item>
          </div>
      </v-list>
    </div>

    <v-btn
      variant="text"
      icon="mdi-arrow-collapse"
      @click.stop="rail = !rail"
    ></v-btn>

    </v-navigation-drawer>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      drawer: true,
      items: [
        { id: 1, title: "投稿管理", icon: "mdi-bullhorn-variant-outline", linkTo: "announce.list", disabled: false, group: false, },
        { id: 2, title: "ギャラリー管理", icon: "mdi-image-outline", linkTo: "", disabled: true, group: false, },
        { id: 3, title: "アクセス情報", icon: "mdi-chart-bar", linkTo: "", disabled: true, group: false, },
        { id: 4, title: "アカウント管理", icon: "mdi-account", linkTo: "enduser.list", disabled: false, group: false, },
/*
        { id: 4, title: "アカウント管理", icon: "mdi-account", linkTo: "enduser.list", disabled: false, group: true,
          submenus: [
            { id: 401, title: "アカウント一覧", linkTo: "enduser.list", disabled: false, },
            { id: 402, title: "アカウント登録", linkTo: "enduser.register", disabled: false, },
          ],
        },
*/
        { id: 5, title: "契約情報", icon: "mdi-file-document-edit-outline", linkTo: "", disabled: true, group: false, },
        { id: 6, title: "サイト更新依頼", icon: "mdi-refresh", linkTo: "", disabled: true, group: false, },
        { id: 7, title: "WEBサイトへ", icon: "mdi-tab", linkTo: "", disabled: true, group: false, },
      ],
      right: null,
      drawer: true,
      rail: false,
      company_name: '',
      shopSelection: null,
    };
  },
  methods: {
    ...mapActions('shopUser', ['fetchShopUsersWithLogout','getShopSelection']),
    ...mapActions('sidebar', ['fetchCustomerBySession']),

    onShopSelectionChange: function(id) {
      // 選択したIDを取得
      const postData = {
        shop_id: id,
      };

      if(id == "logout") {
        this.$axios.post("/logout")
          .then(response => {
            localStorage.removeItem("auth");
            window.location.href = "/login"
          })
          .catch(error => {
            console.log(error);
          });
      } else {
        this.$axios.put('/api/changeshop', postData)
          .then(response => {
            // 表示している画面を強制リロード
            this.$router.go({path: this.$router.currentRoute.path, force: true});
          })
          .catch(error => {
            console.log(error);
          });
      }
    },

    logout(){
      this.$axios.post("/logout")
        .then(response => {
          localStorage.removeItem("auth");
          window.location.href = "/login"
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
  computed: {
    ...mapGetters("shopUser", ["shopUsers"]),
    ...mapGetters("sidebar", ["customer"]),
    usershops: {
      get() {
        return this.shopUsers;
      }
    },
    companyName: {
      get() {
        if(this.customer != null){
          return this.customer.company_name;
        }
      }
    },
  },
  async mounted() {
    let shopselect = await this.getShopSelection();
    this.shopSelection = shopselect;
  },
  async created() {
    await this.fetchShopUsersWithLogout();
    await this.fetchCustomerBySession();
  },
};
</script>

<!-- 共通CSS -->
<style src="../components/pages/css/sidebar.css"></style>

<!-- 固有CSS -->
<style scoped>

.logo{
  font-weight:  900;
}

@media (max-width: 900px){
    .pc_sidebar{
        display: none;
    }
}
/* 店舗選択リストとメニューの間隔を開ける */
.sidebar_list-margin-top {
  margin-top: 2rem;
}


</style>