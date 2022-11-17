<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ ('ユーザ更新') }}</div>

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
  import { mapActions, mapGetters } from "vuex";
  export default {
    data() {
      return {
        valid: true,
        customers: [],
        forms: {
          id: '',
          name: '',
          email: '',
          customer: null,
        },
        rules: {
          required: value => !!value || '必須です。',
          max_16: value => value.length <= 16 || '16文字以内です。',
          max_100: value => value.length <= 100 || '100文字以内です。',
          email: value => /.+@.+\..+/.test(value) || '正しい書式ではありません',
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
      ...mapActions('enduser', ['fetchUsers']),
      ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
      submit() {
        const validateRes = this.$refs.form.validate();
        validateRes.then(res => {
          if (!res.valid) {
            console.log("invalid!");
            return;
          }
          this.$axios.put('/api/enduser/' + this.forms.id, this.forms)
              .then(response => {
                  this.openSuccess('更新しました');
              })
              .catch(error => {
                  console.log(error);
              });
        });
      },
      getUser: function() {
        const user_id = this.$route.params.user_id;
        const user = this.getUserById(user_id);
        this.forms.id = user.id;
        this.forms.name = user.name;
        this.forms.email = user.email;
        this.forms.customer = user.customer_code;
      },
      getCustomerCodes: function() {
        this.customers = this.getCustomers.map(c => {
          return c.code;
        });
      },
    },
    computed: {
      ...mapGetters('enduser', ['getUserById']),
      ...mapGetters('customer', ['getCustomers']),
    },
    mounted() {
      this.getCustomerCodes();
      this.getUser();
    },
  }
</script>
