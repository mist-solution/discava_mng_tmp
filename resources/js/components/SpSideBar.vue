<template>
  <div class="sp_sidebar">
    <v-app-bar
     dark app
     :color = color
     :height = header_height>
     <div v-if="shopSelection" class="company_name">
        {{companyName}} - {{shopSelection.shop_name}}
     </div>
    <v-tab class="shop_choice">
      <v-img
        src="/images/user-icon/icon.png"
        max-height="42"
        max-width="42"
        contain>
      <v-select
        :items="usershops"
        item-value="shop_id"
        item-title="shop_name"
        @update:modelValue="onShopSelectionChange"
      ><template v-slot:append-item>
          <v-list-item @click="logout" class="whiteline">
            <v-list-content>
              <v-list-title style="color: white;">
                ログアウト
              </v-list-title>
            </v-list-content>
          </v-list-item>
        </template>
      </v-select>
      </v-img>
    </v-tab>
    <input id="navi" type="checkbox" @click="heightchange()"/>
      <label for="navi" v-bind:class="{'bento-active':header_height == 1500}">
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
    <div class="bento_menu" v-bind:class="{'bento_menu_active':header_height == 1500}">
      <v-list nav dense>
        <div v-for="item in items" :key="item.id">
          <v-list-item
            tile
            :prepend-icon="item.icon"
            :title="item.title"
            link
            color="#3990e7"
            :to="{ name: item.linkTo }"
            :disabled="item.disabled"
            @click="reset(),heightchange()"
          ></v-list-item>
        </div>
        <div>
          <v-list-item
            tile
            prepend-icon="mdi-tab"
            title="WEBサイトへ"
            link
            color="#3990e7"
            :href="shopSelection.website_url"
            :disabled="false"
            @click="heightchange()"
            target="_blank"
            rel="noopener"
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
        { id: 1, title: "投稿管理", icon: "mdi-bullhorn-variant-outline", linkTo: "announce.list", disabled: false, },
        { id: 2, title: "ギャラリー管理", icon: "mdi-image-outline", linkTo: "", disabled: true, },
        { id: 3, title: "アクセス情報", icon: "mdi-chart-bar", linkTo: "", disabled: true, },
        { id: 4, title: "アカウント管理", icon: "mdi-account", linkTo: "enduser.list", disabled: false, },
        { id: 5, title: "契約情報", icon: "mdi-file-document-edit-outline", linkTo: "", disabled: true, },
        { id: 6, title: "サイト更新依頼", icon: "mdi-refresh", linkTo: "", disabled: true, },
      ],
      right: null,
      company_name: '',
      shopSelection: null,
      header_height:"54",
      color:"white",
      shopSelection: [],
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

    heightchange: function(){
      if(this.header_height == "54"){
        this.header_height = "1500";
        this.color = "#F8FFFD";
      }else if(this.header_height == "1500"){
        this.header_height = "54";
        this.color = "white";
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
    // モバイル判定
    moblieFlg() {
      return window.matchMedia &&
        window.matchMedia('(max-device-width: 640px)').matches ?
        true : false
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
          if(this.customer.company_name.length > 11){
            if(this.moblieFlg()){
              this.customer.company_name = this.customer.company_name.slice(0,10) + "..."
            }
          }
          return this.customer.company_name;
        }
      }
    },
  },
  async mounted() {
    let shopselect = await this.getShopSelection();
    this.shopSelection = shopselect;
    if(this.shopSelection.shop_name.length > 9){
      if(this.moblieFlg()){
        this.shopSelection.shop_name = this.shopSelection.shop_name.slice(0,8) + "..."
      }
    }
  },
  async created() {
    await this.fetchShopUsersWithLogout();
    await this.fetchCustomerBySession();
  },
};
</script>

<!-- 共通CSS -->
<style src="../components/pages/css/spsidebar.css"></style>

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
  color: #707070;
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
  background-color: #F8FFFD;
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

.bento_menu_active > .v-list{
  width: 230px !important;
  background-color: #F8FFFD;
}
</style>