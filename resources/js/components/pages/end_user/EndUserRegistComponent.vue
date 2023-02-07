<template>
  <v-container class="pt-0 max-cont">
    <div>
      <title-component
        name = "アカウント登録"
      />
    </div>
    <!-- エラーメッセージ -->
    <validation-errors :errors="validationErrors" v-if="validationErrors"/>
    <div class="p-0">
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
                :rules="[rules.required, rules.max_16]"
                hide-details="false"
                autocomplete="off"
              />
            </v-col>
          </v-row>
          <v-row align-sm="center" class="mb-4">
            <v-col cols="12" sm="2" class="pr-0 pb-0 pb-sm-3">
              <p class="mb-0">メールアドレス</p>
            </v-col>
            <v-col cols="12" sm="10" class="pt-1 pt-sm-3">
              <v-text-field
                dense
                v-model="forms.email"
                :rules="[rules.required, rules.email]"
                hide-details="false"
                autocomplete="off"
              />
            </v-col>
          </v-row>
          <v-row align-sm="center">
            <v-col cols="12" sm="2" class="pr-0 pb-0 pb-sm-3">
              <p class="mb-0 mb-sm-8">パスワード</p>
            </v-col>
            <v-col cols="12" sm="10" class="pt-1 pt-sm-3">
              <v-text-field
                dense
                v-model="forms.password"
                v-bind:type="toggle.type"
                @click:append="showPassword = !showPassword"
                :append-icon="toggle.icon"
                :rules="[rules.required, rules.max_72]"
                hide-details="false"
                autocomplete="new-password"
                required
              />
              <p class="text-caption mt-2 mb-2">半角英数字及び記号（「-」「_」「%」「$」「#」）を含む、12文字以上を入力してください</p>
            </v-col>
          </v-row>
          <v-row align-sm="center">
            <v-col cols="12" sm="2" class="pr-0 pb-0 pb-sm-3">
              <p class="mb-0 mb-sm-10">パスワード確認</p>
            </v-col>
            <v-col cols="12" sm="10" class="pt-1 pt-sm-3">
              <v-text-field
                dense
                v-model="forms.password_confirmation"
                v-bind:type="toggle.confType"
                @click:append="showPwdConfirm = !showPwdConfirm"
                :append-icon="toggle.confIcon"
                :rules="[rules.required, rules.max_72]"
                hide-details="false"
                autocomplete="new-password"
                required
              />
              <p class="text-caption mt-2">確認の為もう一度入力</p>
            </v-col>
          </v-row>
          <v-row align-xs="center">
            <v-col cols="12" class="mt-5 pr-0 pb-0">
              <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">権限グループ</p>
            </v-col>
            <!-- {{ "========" + JSON.stringify(shopList) }} -->

            <v-col v-for="shop in this.forms.shopList" cols="12" class="pt-sm-3 pb-0 pb-sm-3">
              <v-row align-sm="center shop-auth">
                <v-col cols="2" class="pr-0">
                  <p class="mb-0 pb-0">{{ shop.shop_name }}</p>
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
<!--
            <v-col cols="12" class="pt-sm-3 pb-0 pb-sm-3">
              <v-row align-sm="center shop-auth">
                <v-col cols="2" class="pr-0">
                  <p class="mb-0 pb-0">本社</p>
                </v-col>
                <v-col cols="10" class="pt-sm-3 shop-sel">
                  <v-select
                    :items="authoritySet"
                    item-value="id"
                    item-title="name"
                    hide-details="false"
                  />
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="12" class="pt-sm-3 pb-0">
              <v-row align-sm="center shop-auth">
                <v-col cols="2" class="pr-0">
                  <p class="mb-0 pb-0">高松支店</p>
                </v-col>
                <v-col cols="10" class="pt-sm-3 shop-sel">
                  <v-select
                    :items="authoritySet"
                    item-value="id"
                    item-title="name"
                    hide-details="false"
                  />
                </v-col>
              </v-row>
            </v-col>
-->
          </v-row>
        </div>
        <!-- ToDo:権限は要検討 -->
        <v-row justify="center" class="mt-4 btn-list">
          <v-col cols="12" sm="3" class="p-0 m-2">
            <v-btn class="green-btn" @click.prevent="submit">
              アカウント追加
            </v-btn>
          </v-col>
<!--
          <v-btn class="ml-1" color="secondary" @click="reset">
            クリア
          </v-btn>
-->
          <v-col cols="12" sm="3" class="p-0 m-2">
            <router-link v-bind:to="{ name: 'enduser.list' }">
              <button class="btn btn-success m-0 p-0">
                戻る
              </button>
            </router-link>
          </v-col>
        </v-row>
      </v-form>
    </div>
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
  data() {
    return {
      valid: true,
      showPassword : false,
      showPwdConfirm : false,
      forms: {
        name: '',
        email: '',
        password: '',
        password_confirmation:'',
        shopList: null,
      },
      rules: {
        required: value => !!value || '必須です。',
        max_16: value => value.length <= 16 || '16文字以内です。',
        max_72: value => value.length <= 72 || '72文字以内です。',
        email: value => /.+@.+\..+/.test(value) || '正しい書式ではありません',
        password: value => /^(?=.*[A-Za-z])(?=.*\d)(?=.*[-_%$#])[A-Za-z\d-_%$#]{12,72}$/.test(value) || '12文字以上。半角英数字、ﾊｲﾌﾝ、ｱﾝﾀﾞｰﾊﾞｰが使えます。',
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
    ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
    ...mapActions('enduser', ['fetchUsers']),
    ...mapActions('authoritySet', ['fetchAllAuthoritySetDisplay']),
    ...mapActions('shop', ['fetchShops']),
    submit() {
      // 必須項目を取得
      const validateItem = {
        name: this.forms.name,
        email: this.forms.email,
        password:this.forms.password,
        password_confirmation:this.forms.password_confirmation,
        shopList:this.forms.shopList,
      };
      let shopListModel = true;
      let passwordCheck = false;

      if (validateItem.shopList[0].model == "none" && validateItem.shopList[1].model == "none"){
        shopListModel = false;
       
      }
      if (validateItem.password != "" && validateItem.password == validateItem.password_confirmation){
        passwordCheck = true;
      }
      const validateRes = this.$refs.form.validate();
      validateRes.then(res => {
        if (!res.valid || shopListModel == false || passwordCheck == false) {
          // 必須項目を検証する
          axios.post('/api/enduser/registValidation', validateItem )
          .then(response => {
              console.log(response);
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
        }
        console.log(this.forms);
        this.$axios.post('/api/enduser', this.forms)
        .then(response => {
          this.reset();
          this.openSuccess('登録しました');
          this.$router.push('/enduser');
//          this.fetchUsers();
          // バリデーションのメッセージを初期化する
          this.$store.dispatch("enduser/setEndUserErrorMessages", "");
        })
        .catch(error => {
          console.log(error);
        });
      });
    },
    // 入力内容と検証エラーをリセットするメソッド
    reset() {
      this.$refs.form.reset();
//      this.forms.customer = null;
    },
//    getCustomerCodes: function() {
//      this.customers = this.getCustomers.map(c => {
//        return c.id;
//      });
//    },
  },
  // 顧客はログインユーザの顧客IDのため不要、一方で店舗一覧を出して権限(店舗ユーザ)を設定したい。
  computed: {
    ...mapGetters('customer', ['getCustomers']),
    ...mapGetters('authoritySet', ['getAuthoritySetDisplay']),
    ...mapGetters('shop', ['getShops']),
    ...mapState({
      validationErrors: state => state.enduser.endUserErrorMessages
    }),
    toggle () {
      const icon = this.showPassword ? 'mdi-eye' : 'mdi-eye-off'
      const type = this.showPassword ? 'text' : 'password'
      const confIcon = this.showPwdConfirm ? 'mdi-eye' : 'mdi-eye-off'
      const confType = this.showPwdConfirm ? 'text' : 'password'
      return { icon, type, confIcon, confType }
    }
  },
  async mounted() {
//    this.getCustomerCodes();
    await this.fetchAllAuthoritySetDisplay();
    this.authoritySet = this.getAuthoritySetDisplay;
    await this.fetchShops();
    this.forms.shopList = this.getShops;
    this.forms.shopList.forEach(function(value){
      value.model = 'none';
    });
  },
}
</script>

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
</style>