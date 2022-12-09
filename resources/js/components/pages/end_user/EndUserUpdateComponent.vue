<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">{{ ('アカウント更新') }}</div>

                  <div class="card-body">
                      <v-form ref="form" v-model="valid">
                          <v-text-field
                              dense
                              v-model="forms.id"
                              label="ID"
                              :rules="[rules.required]"
                              v-show="false"
                          />
                          <v-text-field
                              dense
                              v-model="forms.name"
                              label="ユーザ名"
                              :rules="[rules.required, rules.max_100]"
                          />
                          <v-text-field
                              dense
                              v-model="forms.email"
                              label="メールアドレス"
                              :rules="[rules.required, rules.email]"
                          />
                          <div class="btn-group mr-auto">
                            <v-btn color="info" @click="submit">
                              更新
                            </v-btn>
                            <router-link v-bind:to="{ name: 'enduser.list' }">
                              <button class="btn btn-success ml-1">
                                戻る
                              </button>
                            </router-link>
                          </div>
                      </v-form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>
<style src="../css/common.css"></style>
<style src="../css/input-reset.css"></style>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      valid: true,
      forms: {
        id: '',
        name: '',
        email: '',
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
                this.$router.push('/enduser');
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
    },
  },
  computed: {
    ...mapGetters('enduser', ['getUserById']),
  },
  mounted() {
    this.getUser();
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