<template>
  <div class="v-container pt-0">
            <div>
              <title-component
                name = "アカウント更新"
              />
            </div>
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
                                  :rules="[rules.required, rules.max_100]"
                                  hide-details="false"

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

                              />
                            </v-col>
                          </v-row>
                          <v-text-field
                              dense
                              v-model="forms.id"
                              label="ID"
                              :rules="[rules.required]"
                              v-show="false"
                          />
                          <v-row align-xs="center">
                            <v-col cols="12" class="mt-5 pr-0 pb-0">
                              <p class="text-subtitle-1 mb-0 pb-0 font-weight-bold">権限グループ</p>
                            </v-col>
                            <v-col cols="12" class="pt-sm-3 pb-0 pb-sm-3">
                              <v-row align-sm="center shop-auth">
                                <v-col cols="2" class="pr-0">
                                  <p class="mb-0 pb-0">A店</p>
                                </v-col>
                                <v-col cols="10" class="pt-sm-3 shop-sel">
                                  <v-select
                                    v-bind:items="authority"
                                    hide-details="false"
                                  />
                                </v-col>
                              </v-row>
                            </v-col>
                            <v-col cols="12" class="pt-sm-3 pb-0">
                              <v-row align-sm="center shop-auth">
                                <v-col cols="2" class="pr-0">
                                  <p class="mb-0 pb-0">B店</p>
                                </v-col>
                                <v-col cols="10" class="pt-sm-3 shop-sel">
                                  <v-select
                                    v-bind:items="authority"
                                    hide-details="false"
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
          </div>
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
      },
      authority: [
      '管理者',
      '投稿者',
      '閲覧者',
      '該当なし'
      ],
    }
  },
  components: {
        TitleComponent
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