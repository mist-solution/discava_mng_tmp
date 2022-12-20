<template>
  <v-container class="pt-0 max-cont">
    <div>
      <title-component
        name = "アカウント登録"
      />
    </div>
    <div class="p-0">
      <v-form ref="form" v-model="valid">
        <div class="card main-cont pr-md-12 pl-md-12 pr-5 pl-5 pt-6 pb-10">
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
                :rules="[rules.required, rules.password]"
                hide-details="false"
                autocomplete="new-password"
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
                :rules="[rules.required, rules.password]"
                hide-details="false"
                autocomplete="new-password"
              />
              <p class="text-caption mt-2">確認の為もう一度入力</p>
            </v-col>
          </v-row>
          <v-row align-xs="center">
            <v-col cols="12" class="mt-5 pr-0 pb-0">
              <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">権限グループ</p>
            </v-col>
            <v-col cols="12" class="pt-sm-3 pb-0 pb-sm-3">
              <v-row align-sm="center shop-auth">
                <v-col cols="2" class="pr-0">
                  <p class="mb-0 pb-0">本社</p>
                </v-col>
                <v-col cols="10" class="pt-sm-3 shop-sel">
                  <v-select
                    v-bind:items="authoritySet"
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
                    v-bind:items="authoritySet"
                    hide-details="false"
                  />
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </div>
        <!-- ToDo:権限は要検討 -->
        <v-row justify="center" class="mt-4 btn-list">
          <v-col cols="12" sm="3" class="p-0 m-2">
            <v-btn class="green-btn" @click="submit">
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

<script>
import { mapActions, mapGetters } from "vuex";
import TitleComponent from "../../common/TitleComponent.vue"

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
      },
      rules: {
        required: value => !!value || '必須です。',
        max_16: value => value.length <= 16 || '16文字以内です。',
        max_100: value => value.length <= 100 || '100文字以内です。',
        email: value => /.+@.+\..+/.test(value) || '正しい書式ではありません',
        password: value => /^[\w-]{8,72}$/.test(value) || '8文字以上。半角英数字、ﾊｲﾌﾝ、ｱﾝﾀﾞｰﾊﾞｰが使えます',
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
  },
  methods: {
    ...mapActions('enduser', ['fetchUsers']),
    ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
    ...mapActions('authoritySet', ['fetchAllAuthoritySet']),
    submit() {
      const validateRes = this.$refs.form.validate();
      validateRes.then(res => {
        if (!res.valid) {
          console.log("invalid!");
          return;
        }
        this.$axios.post('/api/enduser', this.forms)
        .then(response => {
          this.reset();
          this.openSuccess('登録しました');
          this.$router.push('/enduser');
//          this.fetchUsers();
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
    getCustomerCodes: function() {
      this.customers = this.getCustomers.map(c => {
        return c.id;
      });
    },
  },
  // 顧客はログインユーザの顧客IDのため不要、一方で店舗一覧を出して権限(店舗ユーザ)を設定したい。
  computed: {
    ...mapGetters('customer', ['getCustomers']),
    ...mapGetters('authoritySet', ['getCustomers']),
    ...mapGetters('authoritySet', ['getAuthoritySet']),
    toggle () {
      const icon = this.showPassword ? 'mdi-eye' : 'mdi-eye-off'
      const type = this.showPassword ? 'text' : 'password'
      const confIcon = this.showPwdConfirm ? 'mdi-eye' : 'mdi-eye-off'
      const confType = this.showPwdConfirm ? 'text' : 'password'
      return { icon, type, confIcon, confType }
    }
  },
  mounted() {
    this.getCustomerCodes();
    this.fetchAllAuthoritySet();
    this.authoritySet = this.getAuthoritySet;
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