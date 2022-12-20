<template>
    <div class="sp_sidebar">
    <v-app-bar
     dark app
     color = "white"
     height = "54">
     <input id="navi" type="checkbox" />
      <label for="navi">
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
<style src="../components/pages/css/sidebar.css"></style>

<style scoped>

.sp_sidebar #navi {
    display: none;
}
.sp_sidebar #navi:checked ~ label {
    transform: rotate(225deg);
}
.sp_sidebar #navi:checked ~ label .dots:nth-of-type(1) {
    filter: opacity(0);
}
.sp_sidebar #navi:checked ~ label .dots:nth-of-type(2) {
    transform: scaleY(4.75);
}
.sp_sidebar #navi:checked ~ label .dots:nth-of-type(3) {
    filter: opacity(0);
}
.sp_sidebar #navi:checked ~ label .dots:nth-of-type(4) {
    transform: scaleX(4.75);
}
.sp_sidebar #navi:checked ~ label .dots:nth-of-type(5) {
    filter: opacity(0);
}
.sp_sidebar #navi:checked ~ label .dots:nth-of-type(6) {
    transform: scaleX(4.75);
}
.sp_sidebar #navi:checked ~ label .dots:nth-of-type(7) {
    filter: opacity(0);
}
.sp_sidebar #navi:checked ~ label .dots:nth-of-type(8) {
    transform: scaleY(4.75);
}
.sp_sidebar #navi:checked ~ label .dots:nth-of-type(9) {
    filter: opacity(0);
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
label .dots {
    width: 6px;
    height: 6px;
    background-color: black;
    transition: .5s;
}
label .dots:nth-of-type(3n+2) {
    margin: 0 4px;
}
label .dots:nth-of-type(2) {
    transform-origin: top;
}
label .dots:nth-of-type(4) {
    transform-origin: left;
}
label .dots:nth-of-type(6) {
    transform-origin: right;
}
label .dots:nth-of-type(8) {
    transform-origin: bottom;
}

#navi {
    display: none;
}
#navi:checked ~ label {
    transform: rotate(225deg);
}
#navi:checked ~ label .dots:nth-of-type(1) {
    filter: opacity(0);
}
#navi:checked ~ label .dots:nth-of-type(2) {
    transform: scaleY(4.75);
}
#navi:checked ~ label .dots:nth-of-type(3) {
    filter: opacity(0);
}
#navi:checked ~ label .dots:nth-of-type(4) {
    transform: scaleX(4.75);
}
#navi:checked ~ label .dots:nth-of-type(5) {
    filter: opacity(0);
}
#navi:checked ~ label .dots:nth-of-type(6) {
    transform: scaleX(4.75);
}
#navi:checked ~ label .dots:nth-of-type(7) {
    filter: opacity(0);
}
#navi:checked ~ label .dots:nth-of-type(8) {
    transform: scaleY(4.75);
}
#navi:checked ~ label .dots:nth-of-type(9) {
    filter: opacity(0);
}

@media (min-width: 901px){
    .sp_sidebar{
        display: none;
    }
}

</style>