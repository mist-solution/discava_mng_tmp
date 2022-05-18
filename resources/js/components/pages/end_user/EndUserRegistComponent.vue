<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ ('ユーザ登録') }}</div>

                    <div class="card-body">
                        <v-form
                            ref="form"
                            v-model="valid"
                        >
                            <v-text-field
                                v-model="forms.user_id"
                                label="ユーザID"
                                :rules="[rules.required, rules.max_16]"
                            />

                            <v-text-field
                                v-model="forms.email"
                                label="メールアドレス"
                                :rules="[rules.required, rules.email]"
                            />

                            <v-text-field
                                v-model="forms.password"
                                v-bind:type="toggle.type"
                                @click:append="showPassword = !showPassword"
                                :append-icon="toggle.icon"
                                label="パスワード"
                                :rules="[rules.required, rules.password]"
                            />

                            <v-text-field
                                v-model="forms.password_confirmation"
                                v-bind:type="toggle.confType"
                                @click:append="showPwdConfirm = !showPwdConfirm"
                                :append-icon="toggle.confIcon"
                                label="パスワード確認"
                                :rules="[rules.required, rules.password]"
                            />

                            <v-select
                                v-model="forms.customer"
                                label="顧客"
                                :items="constant.SELECTS"
                                item-text=company_name
                                item-value=code
                                :rules="[rules.required]"
                            ></v-select>

                            <v-btn
                                :disabled="!valid"
                                color="success"
                                @click="submit"
                            >送信</v-btn>
                        </v-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        valid: true,
        showPassword : false,
        showPwdConfirm : false,
        constant: {
          SELECTS: [],
        },
        forms: {
          user_id: '',
          email: '',
          password: '',
          password_confirmation:'',
          customer: '',
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
      submit() {
        console.log("submit!")
        console.log(JSON.stringify(this.forms, null, 2))
      },
      getCustomers: function() {
          this.$axios.get('api/customer')
              .then(response => {
                  console.log(JSON.stringify(response.data, null, 2));
                  this.options = response.data.customers;
              })
              .catch(error => {
                  console.log(error);
              });
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
