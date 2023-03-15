<template>
  <div class="pc_sidebar">
    <v-navigation-drawer
      v-model="drawer"
      :rail="rail"
      permanent
      class="text-gray"
    >

      <v-container class="mt-5">
        <div v-if="!rail" class="logo">
          <v-row>
            <v-col align="center">
              DISCaVa MATE
            </v-col>
          </v-row>
        </div>
        
        <div v-if="!rail">
        <v-row>
          <v-col align="center">
            <v-img
              src="/images/user-icon/icon.png"
              max-height="96"
              max-width="96"
              contain>
            </v-img>
          </v-col>
        </v-row>
        </div>

        <div v-if="rail" class="min_icon">
        <v-row>
          <v-col align="center">
            <v-img
              src="/images/user-icon/icon.png"
              max-height="96"
              max-width="96"
              contain>
            </v-img>
          </v-col>
        </v-row>
        </div>

        <div v-if="!rail">
          <v-row>
            <v-col class="conpanyname-font" align="center">
            {{ companyName }}
            </v-col>
          </v-row>
        </div>
        <div v-if="rail" class="min_select">
          <v-row>
            <v-col align="center"  v-bind:class="{'longname':shopSelection.shop_name.length > 3}">
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
            :class="[{'short_Range':range <= 3},{'middle_Range': range > 3 },
            {'long_Range':range > 6}]"
          >
          <template v-slot:append-item>
            <v-list-item @click="logout" class="whiteline">
              <v-list-content>
                <v-list-title class="logout_button">
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
            <v-list-item @click="logout" class="whiteline">
              <v-list-content>
                <v-list-title class="logout_button">
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
            <v-list-item
              @click="reset"
              tile
              :prepend-icon="item.icon"
              :title="item.title"
              link
              :to="{ name: item.linkTo }"
              :disabled="item.disabled"

            ></v-list-item>
          </div>
          <div>
            <v-list-item
              tile
              prepend-icon="mdi-tab"
              title="WEBサイトへ"
              link
              :href="shopSelection.website_url"
              :disabled="false"
              target="_blank"
              rel="noopener"
              ></v-list-item>
          </div>
      </v-list>
    </div>

    <div class="sidebar_bottom">
      <v-btn
        class="rail_toggle"
        variant="text"
        icon="mdi-arrow-collapse"
        @click.stop="rail = !rail"
      ></v-btn>

      <div class="userID" v-if="!rail">
        {{ username }}でログイン中
      </div>
    </div>

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
        { id: 1, title: "投稿管理", icon: "mdi-bullhorn-variant-outline", linkTo: "announce.list", disabled: false,},
        { id: 2, title: "ギャラリー管理", icon: "mdi-image-outline", linkTo: "", disabled: true,},
        { id: 3, title: "アクセス情報", icon: "mdi-chart-bar", linkTo: "", disabled: true,},
        { id: 4, title: "アカウント管理", icon: "mdi-account", linkTo: "enduser.list", disabled: false,},
        { id: 5, title: "契約情報", icon: "mdi-file-document-edit-outline", linkTo: "", disabled: true,},
        { id: 6, title: "サイト更新依頼", icon: "mdi-refresh", linkTo: "", disabled: true,},
      ],
      right: null,
      drawer: true,
      rail: false,
      company_name: '',
      shopSelection: [],
      range: null,
      username: null,
    };
  },
  methods: {
    ...mapActions('shopUser', ['fetchShopUsersWithLogout','getShopSelection']),
    ...mapActions('sidebar', ['fetchCustomerBySession']),
    ...mapActions('enduser', ['getUserInfo']),

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
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      this.$axios.post("/logout", { _token: csrfToken })
        .then(response => {
          localStorage.removeItem("auth");
          window.location.href = "/login"
        })
        .catch(error => {
          console.log(error);
        });
    },
    reset(){
      this.$store.dispatch("announce/setDisplayAnnounceStatus", null);
      this.$store.dispatch("announce/setDisplaySearchAddDateBegin", null);
      this.$store.dispatch("announce/setDisplaySearchAddDateEnd", null);
      this.$store.dispatch("announce/setDisplaySearchUpdDateBegin", null);
      this.$store.dispatch("announce/setDisplaySearchUpdDateEnd", null);
      this.$store.dispatch("announce/setDisplaySearchCategory", null);
      this.$store.dispatch("announce/setDisplayAnnounceAddAccount", null);
      this.$store.dispatch("announce/setDisplaySearchRelease", null);
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
    this.range = this.shopSelection.shop_name.length
    let name = await this.getUserInfo();
    if(name){
        this.username = name.name;
    }
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
  font-size: 1.2rem;
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

.conpanyname-font {
  font-size: 1.1rem;
}

</style>