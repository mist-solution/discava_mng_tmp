<template>
  <v-container class="max-cont pt-0">
            <div>
              <title-component
                name = "アカウント更新"
              />
            </div>
            <!-- エラーメッセージ -->
            <validation-errors :errors="validationErrors" v-if="validationErrors"/>
                    <v-form ref="form" v-model="valid">
                      <div class="card main-cont pr-md-12 pl-md-12 pr-5 pl-5 pt-6 pb-10 auth-re text-gray">
                          <v-row align-sm="center" class="mb-4">
                            <v-col cols="12" sm="2" class="pr-0 pb-0 pb-sm-3">
                              <p class="mb-0">ユーザ名</p>
                            </v-col>
                            <v-col cols="12" sm="10" class="pt-1 pt-sm-3">
                              <v-text-field
                                  dense
                                  v-model="forms.name"
                                  :rules="[rules.required, rules.max_100]"
                                  hide-details="false"
                              />
                            </v-col>
                            <v-col cols="12" sm="2" class="pr-0 pb-0 pb-sm-3">
                              <p class="mb-0">メールアドレス</p>
                            </v-col>
                            <v-col cols="12" sm="10" class="pt-1 pt-sm-3">
                              <v-text-field
                                  dense
                                  v-model="forms.email"
                                  :rules="[rules.required, rules.email]"
                                  hide-details="false"
                              />
                            </v-col>
                            <v-col cols="12" sm="10" class="pt-1 pt-sm-3">
                              <v-text-field
                                  dense
                                  v-model="forms.id"
                                  label="ID"
                                  :rules="[rules.required]"
                                  v-show="false"
                              />
                            </v-col>
                            <v-col cols="12" class="mt-1 pr-0 pb-0">
                              <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">権限グループ</p>
                            </v-col>
                            <v-col v-for="shop in this.forms.shopList" cols="12" class="pt-sm-3 pb-0 pb-sm-3">
                              <v-row align-sm="center shop-auth shop-sp-show">
                                <v-col cols="4" sm="4" md="2" lg="2" class="pr-0">
                                  <p class="mb-0 pb-0 shop-name-show">{{ shop.shop_name }}</p>
                                </v-col>
                                <v-col cols="10" class="pt-sm-3 shop-sel">
                                  <v-select
                                    :items="authoritySet"
                                    item-value="id"
                                    item-title="name"
                                    :rules="[rules.required]"
                                    hide-details="false"
                                    v-model="shop.model"
                                  />
                                </v-col>
                              </v-row>
                            </v-col>                          
                          </v-row>
                      </div>
                      <v-row justify="center" class="mt-4 btn-list">
                        <v-col cols="12" sm="3" class="p-0 m-2">
                          <v-btn class="green-btn" @click="submit">
                            更新
                          </v-btn>
                        </v-col>
                        <v-col cols="12" sm="3" class="p-0 m-2">
                          <router-link v-bind:to="{ name: 'enduser.list' }">
                            <button class="btn btn-success">
                              戻る
                            </button>
                          </router-link>
                        </v-col>
                      </v-row>
                      </v-form>
  </v-container>
</template>
<style src="../css/common.css"></style>
<style src="../css/input-reset.css"></style>
<style src="../css/dropdown.css"></style>
<script>
import { mapActions, mapGetters, mapState } from "vuex";
import TitleComponent from "../../common/TitleComponent.vue";
import ValidationErrors from "../../ValidationErrors.vue";

export default {
  props: {
    userId: String,
  },
  data() {
    return {
      valid: true,
      forms: {
        id: '',
        name: '',
        email: '',
        shopList: null,
        shopUser: null
      },
      rules: {
        required: value => !!value || '必須です。',
        max_16: value => value.length <= 16 || '16文字以内です。',
        max_100: value => value.length <= 100 || '100文字以内です。',
        email: value => /^[a-zA-Z0-9_!#$%&'*+/=?`{|}~^.-]+@[a-zA-Z0-9.-]+$/.test(value) || '正しい書式ではありません',
      },
      errors: {
        checlbox: false,
      },
      messages: {
        checkbox: null,
      },
      authoritySet: [],
    }
  },
  components: {
        TitleComponent,
        ValidationErrors,
      },
  methods: {
    ...mapActions('enduser', ['getUserById']),
    ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
    ...mapActions('authoritySet', ['fetchAllAuthoritySetDisplay']),
    ...mapActions('shop', ['fetchShops', 'fetchShopUsers']),

    submit() {
      const validateRes = this.$refs.form.validate();
      // 必須項目を取得
      const validateItem = {
        id: this.forms.id,
        name: this.forms.name,
        email: this.forms.email,
        shopList: this.forms.shopList,
      };

      // let shopListModel = true;
      // if (validateItem.shopList[0].model == "none" && validateItem.shopList[1].model == "none"){
      //   shopListModel = false;
      // }
      validateRes.then(res => {
        // if (!res.valid || shopListModel == false) {
          // 必須項目を検証する
          axios.post('/api/enduser/updateValidation', validateItem )
          .then(response => {
              console.log(response);
              this.$axios.put('/api/enduser/' + this.forms.id, this.forms)
              .then(response => {
                  this.openSuccess('更新しました');
                  this.$router.push('/enduser');
                  // バリデーションのメッセージを初期化する
                  this.$store.dispatch("enduser/setEndUserErrorMessages", "");
              })
              .catch(error => {
                  console.log(error);
              });
          })
          .catch(error => {
            if (error.response.status !== 422) {
              console.error(error);
            } else {
              this.$store.dispatch("enduser/setEndUserErrorMessages", error.response.data.errors);
            }
          });
          console.log("invalid!");
          return;
        // }
      });
    },
//    getUser: function() {
//      const user_id = this.$route.params.user_id;
//      const user = this.getUserById(user_id);
//      this.forms.id = user.id;
//      this.forms.name = user.name;
//      this.forms.email = user.email;
//    },
  },
  computed: {
    ...mapGetters('customer', ['getCustomers']),
    ...mapGetters('authoritySet', ['getAuthoritySetDisplay']),
    ...mapGetters('shop', ['getShops', 'getShopUsers']),
    ...mapState({
      validationErrors: state => state.enduser.endUserErrorMessages
    }),
  },
  async mounted() {
//    this.getUser();
    // バリデーションのメッセージを初期化する
    this.$store.dispatch("enduser/setEndUserErrorMessages", "");

    this.forms = await this.getUserById(this.userId);
    //    this.getCustomerCodes();
    await this.fetchAllAuthoritySetDisplay();
    this.authoritySet = this.getAuthoritySetDisplay;
    await this.fetchShops();
    this.forms.shopList = this.getShops;
    await this.fetchShopUsers(this.userId);
    this.forms.shopUser = this.getShopUsers;
    let list = this.getShops;
    let user = this.getShopUsers;
    list.map(function(value){
      // 権限なし店舗があった場合
      value['model'] = "none";
      user.map(function(value2){
        if (value['id'] == value2['shop_id']) {
          // alert("一致！")
          value['model'] = value2['authority_set_id'];
        }
        else{
          
        }
      })
    })

  },
}
</script>

<!-- 共通CSS -->
<style src="../css/common.css"></style>
<style src="../css/sidebar.css"></style>
<style src="../css/dropdown.css"></style>

<style scoped>

@media (min-width: 600px){
  .btn-list > div{
      max-width:150px;
      min-width: 150px;
  }
  .green-btn,
  .btn-success{
    width:100%;
  }
}
.shop-auth{
align-items: center;
}
.btn-list > div{
text-align: center;;
}
.green-btn,
.btn-success{
width:150px;
height:40px;
font-weight: 600;
}
.btn-success{
background:#fff;
color:#69A5AF;
border:solid 3px #69A5AF;
}
.btn:hover{
opacity: .8;
background:#fff;
color:#69A5AF;
border:solid 3px #69A5AF;
}
.green-btn:hover{
height: 40px;
}

/* 権限グループ名(6文字改行) */
.shop-name-show{
  width: 6rem;
}
</style>