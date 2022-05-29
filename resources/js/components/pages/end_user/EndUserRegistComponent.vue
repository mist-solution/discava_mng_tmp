<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ ('ユーザ登録') }}</div>

                    <div class="card-body">
                        <v-form ref="form" v-model="valid">
                            <v-text-field
                                dense
                                v-model="forms.name"
                                label="ユーザID"
                                :rules="[rules.required, rules.max_16]"
                            />
                            <v-text-field
                                dense
                                v-model="forms.email"
                                label="メールアドレス"
                                :rules="[rules.required, rules.email]"
                            />
                            <v-text-field
                                dense
                                v-model="forms.password"
                                v-bind:type="toggle.type"
                                @click:append="showPassword = !showPassword"
                                :append-icon="toggle.icon"
                                label="パスワード"
                                :rules="[rules.required, rules.password]"
                            />
                            <v-text-field
                                dense
                                v-model="forms.password_confirmation"
                                v-bind:type="toggle.confType"
                                @click:append="showPwdConfirm = !showPwdConfirm"
                                :append-icon="toggle.confIcon"
                                label="パスワード確認"
                                :rules="[rules.required, rules.password]"
                            />
                            <v-select
                                dense
                                v-model="forms.customer"
                                :items="customers"
                                label="顧客"
                                :rules="[rules.required]"
                            />
                            <div class="btn-group mr-auto">
                              <v-btn
                                  color="info"
                                  @click="submit"
                              >送信</v-btn>
                              <v-btn
                                  class="ml-1"
                                  color="secondary"
                                  @click="reset"
                              >クリア</v-btn>
                              <router-link v-bind:to="{ name: 'enduser.list' }">
                                <button class="btn btn-success ml-1">一覧に戻る</button>
                              </router-link>
                            </div>
                        </v-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import { mapActions } from "vuex";
  export default {
    data() {
      return {
        valid: true,
        showPassword : false,
        showPwdConfirm : false,
        customers: [],
        forms: {
          name: '',
          email: '',
          password: '',
          password_confirmation:'',
          customer: null,
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
        }
      }
    },
    methods: {
      ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
      submit() {
        const validateRes = this.$refs.form.validate();
        validateRes.then(res => {
          if (!res.valid) {
            console.log("invalid!");
            return;
          }
          this.$axios.post('api/enduser', this.forms)
              .then(response => {
                  this.reset();
                  this.openSuccess('登録しました');
              })
              .catch(error => {
                  console.log(error);
              });
        });
      },
      getCustomers: function() {
          this.$axios.get('api/customer')
              .then(response => {
                  if (response.data && response.data.customers) {
                      this.customers = response.data.customers.map(c => {
                        return c.code;
                      });
                  }
              })
              .catch(error => {
                  console.log(error);
              });
      },
      // 入力内容と検証エラーをリセットするメソッド
      reset() {
        this.$refs.form.reset();
        this.forms.customer = null;
      },
    },
    computed: {
      toggle () {
        const icon = this.showPassword ? 'mdi-eye' : 'mdi-eye-off'
        const type = this.showPassword ? 'text' : 'password'
        const confIcon = this.showPwdConfirm ? 'mdi-eye' : 'mdi-eye-off'
        const confType = this.showPwdConfirm ? 'text' : 'password'
        return { icon, type, confIcon, confType }
      }
    },
    mounted() {
        this.getCustomers();
    },
  }
</script>
