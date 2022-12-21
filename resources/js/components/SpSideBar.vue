<template>
  <div class="sp_sidebar">
    <v-app-bar
     dark app
     color = "white"
     :height = header_height>
     <div v-if="shopSelection" class="company_name">
        {{companyName}} - {{shopSelection.shop_name}}
     </div>
    <v-tab class="shop_choice">
      <v-img
        src="/images/user-icon/kkrn_icon_user_11.png"
        max-height="54"
        max-width="54"
        contain>
      <v-select
        :items="usershops"
        item-value="shop_id"
        item-title="shop_name"
        @update:modelValue="onShopSelectionChange"
      ></v-select>
      </v-img>
    </v-tab>
    <input id="navi" type="checkbox" @click="heightchange()"/>
      <label for="navi" v-bind:class="{'bento-active':header_height == 1000}">
        <div class="dots"></div>
        <div class="dots"></div>
        <div class="dots"></div>
        <div class="dots"></div>
        <div class="dots"></div>
        <div class="dots"></div>
        <div class="dots"></div>
        <div class="dots"></div>
        <div class="dots"></div>
      </label>
    <div class="bento_menu" v-bind:class="{'bento_menu_active':header_height == 1000}">
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
                @click="heightchange()"
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
              @click="heightchange()"
            ></v-list-item>
          </div>
      </v-list>
    </div>
    </v-app-bar>
  </div>
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
      company_name: '',
      shopSelection: null,
      header_height:"54",
    };
  },
  methods: {
    ...mapActions('shopUser', ['fetchShopUsersWithLogout','getShopSelection']),
    ...mapActions('sidebar', ['fetchCustomerBySession']),

    onShopSelectionChange: function(id) {
      console.log("onShopSelectionChange");
      // 選択したIDを取得
      console.log({ id });
      const postData = {
        shop_id: id,
      };

      if(id == "logout") {
        this.$axios.post("/logout")
          .then(response => {
            console.log(response);
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

    heightchange: function(){
        console.log(this.header_height)
      if(this.header_height == "54"){
        this.header_height = "1000"
      }else if(this.header_height == "1000"){
        this.header_height = "54"
      }
    }
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
    console.log("sidebar mounted.");
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

<style scoped>

.sp_sidebar label .dots:nth-of-type(3n+2) {
    margin: 0 4px;
}
.sp_sidebar label .dots:nth-of-type(2) {
    transform-origin: top;
}
.sp_sidebar label .dots:nth-of-type(4) {
    transform-origin: left;
}
.sp_sidebar label .dots:nth-of-type(6) {
    transform-origin: right;
}
.sp_sidebar label .dots:nth-of-type(8) {
    transform-origin: bottom;
}

.sp_sidebar #navi {
    display: none;
}
.sp_sidebar label.bento-active {
    transform: rotate(225deg);
}
.sp_sidebar label.bento-active .dots:nth-of-type(1) {
    filter: opacity(0);
}
.sp_sidebar label.bento-active .dots:nth-of-type(2) {
    transform: scaleY(4.75);
}
.sp_sidebar label.bento-active .dots:nth-of-type(3) {
    filter: opacity(0);
}
.sp_sidebar label.bento-active .dots:nth-of-type(4) {
    transform: scaleX(4.75);
}
.sp_sidebar label.bento-active .dots:nth-of-type(5) {
    filter: opacity(0);
}
.sp_sidebar label.bento-active .dots:nth-of-type(6) {
    transform: scaleX(4.75);
}
.sp_sidebar label.bento-active .dots:nth-of-type(7) {
    filter: opacity(0);
}
.sp_sidebar label.bento-active .dots:nth-of-type(8) {
    transform: scaleY(4.75);
}
.sp_sidebar label.bento-active .dots:nth-of-type(9) {
    filter: opacity(0);
}

.sp_sidebar .bento_menu.bento_menu_active{
  opacity: 1;
  visibility: visible;
}

.sp_sidebar label {
    cursor: pointer;
    position: fixed;
    top: 14px;
    right: 14px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-content: space-between;
    width: 26px;
    height: 26px;
    transition: .5s;
}
.sp_sidebar label .dots {
    width: 6px;
    height: 6px;
    background-color: black;
    transition: .5s;
}
label {
    cursor: pointer;
    position: fixed;
    top: 32px;
    right: 32px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-content: space-between;
    width: 26px;
    height: 26px;
    transition: .5s;
}


.sp_sidebar .shop_choice ::before{
  visibility: hidden;
}

.sp_sidebar .v-btn--size-default{
  padding: 0px !important;
}

.sp_sidebar .company_name{
  position: fixed;
  left: 15px;
}

.sp_sidebar .v-tab{
  min-width: 0px !important;
}

.sp_sidebar .shop_choice{
  position: fixed;
  right: 50px;
}

.bento_menu {
  position: fixed;
  display: flex;
  flex-direction: column;
  align-items: center;
  z-index: 1010;
  top: 54px;
  left: 0;
  width: 100vw;
  height: 100vh;
  margin: 0;
  padding: 0;
  background-color: white;
  opacity: 0;
  visibility: hidden;
  transition: all .5s ease-out;
  will-change: opacity, visibility;
}

.bento_menu .v-list-item--density-default{
  min-height: 62px;
}

@media (min-width: 901px){
    .sp_sidebar{
        display: none;
    }
}

</style>