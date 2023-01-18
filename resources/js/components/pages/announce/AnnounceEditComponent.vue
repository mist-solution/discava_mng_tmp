
<template>
  <div>
    <h3 class="h4 mb-2 mb-sm-5 mt-2 mt-sm-5 ml-5">投稿者　の投稿記事を編集</h3>
  </div>
    <v-form ref="form" v-model="valid" class="art-flex">
      <v-card class="main-cont p-3">

            <v-text-field
              dense
              v-model="announce.title"
              :rules="[rules.required]"
              hide-details="false"
              label="タイトルを入力"
            />

            <QuillEditor
              toolbar="full"
              class="ql-editor p-0"
              v-model="contents"
              ref="myQuillEditor"
              :options="editorOption"
              :rules="[rules.required]"
              @blur="onEditorBlur($event)"
              @focus="onEditorFocus($event)"
              @change="onEditorChange($event)"
            >
            </QuillEditor>

      </v-card>
      <v-card class="main-cont mt-5 mt-sm-0 p-3">
        <v-row>
          <v-col cols="3" sm="12" class="mb-4 mb-sm-0 pb-3 pb-sm-0">
            <p class="mt-1 mt-sm-0 mb-1 font-weight-bold">掲載期間</p>
          </v-col>
          <v-col cols="9" sm="12" class="pt-3 pt-sm-2">
            <v-row align="center" class="mb-3">
              <v-col cols="3" class="pr-0 pb-0">
                <p class="mb-0">開始</p>
              </v-col>
              <v-col cols="9" class="pl-0 pb-0">
                <DatePicker
                  v-model="announce.start_date"
                  placeholder="掲載開始日"
                  :format="format"
                  :enableTimePicker="false"
                  :required="true"
                  selectText="確認"
                  cancelText="キャンセル"
                />
              </v-col>
              <v-col cols="12" class="mt-2 p-0 Date-time">
                <v-row  align="center" class="m-0 time-pick">
                  <v-col cols="3" class="p-0"></v-col>
                  <v-col cols="2" class="p-0">
                    <v-text-field
                        dense
                        hide-details="false"
                    />
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <p>時</p>
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <v-text-field
                        dense
                        hide-details="false"
                    />
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <p>分</p>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-row align="center" class="mb-3">
                <v-col cols="3" class="pr-0 pb-0">
                  <p class="mb-0">終了</p>
                </v-col>
                <v-col cols="9" class="pl-0 pb-0">

                <DatePicker
                  v-model="announce.end_date"
                  placeholder="掲載終了日"
                  :format="format"
                  :enableTimePicker="false"
                  :required="false"
                  selectText="確認"
                  cancelText="キャンセル"
                />
              </v-col>
              <v-col cols="12" class="mt-2 p-0 Date-time">
                <v-row  align="center" class="m-0 time-pick">
                  <v-col cols="3" class="p-0"></v-col>
                  <v-col cols="2" class="p-0">
                    <v-text-field
                        dense
                        hide-details="false"
                    />
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <p>時</p>
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <v-text-field
                        dense
                        hide-details="false"
                    />
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <p>分</p>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="3" sm="12" class="pt-3 pb-3 pr-0 mb-4 mb-sm-0 pt-sm-0 pb-sm-0">
            <p class="mt-2 mt-sm-4 mb-1 font-weight-bold">カテゴリー</p>
          </v-col>
          <v-col cols="9" sm="12" class="pt-3 pt-sm-2">
            <v-select
              dense
              v-model="announce.announce_category_id"
              :items="categories"
              item-value="id"
              item-title="category_name"
              :rules="[rules.required]"
              class="cat-tag"
              hide-details="false"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="3" sm="12" class="pr-0 pb-3 pb-sm-0">
            <p class=" mt-2 mt-sm-4 mb-1 font-weight-bold">サムネイル画像</p>
          </v-col>
          <v-col cols="9" sm="12" class="pt-3 pt-sm-2">
            <div class="samb-box">
              <div v-if="!dataUrl">
                <label for="image" class="samb-none"></label>
                <input type="file" id="image" accept="image/*" @change="readImage">
              </div>
              <div v-else>
                <div id="image-preview">
                    <img :src="dataUrl" v-if="dataUrl">
                </div>
                <label for="image" class="samb-on"></label>
                <input type="file" id="image" accept="image/*" @change="readImage">
              </div>
            </div>
          </v-col>
        </v-row>

        <!-- 操作エリア -->
        <v-row class="p-1 btn-gap mt-4 justify-center">
          <!-- プレビュー -->
          <v-col cols="11" class="p-0 mb-sm-0 mb-2">
            <button type="button" class="pr-0 pl-0 btn white-btn" @click="(displayAnnouncePreview = true),getQuillEditorContent(),getAnnounceDate()">プレビュー</button>
          </v-col>
        </v-row>
        <v-row class="p-1 btn-gap mt-4 justify-center mb-3">
          <!-- 更新する - ユーザに更新権限がある場合 -->
          <v-col
            v-if="update_auth_flg"
            cols="11"
            class="p-0 pb-2 mb-sm-0 mb-2"
          >
            <button
              class="btn green-btn pr-0 pl-0"
              @click="submit()"
              type="button"
            >
              更新する
            </button>
          </v-col>
          <!-- 申請する - ユーザに承認権限がある場合かつ、承認ステータス 2:承認済み以外の場合-->
          <v-col
            v-if="request_auth_flg && announce.approval_status != 2"
            cols="11"
            class="p-0 mb-sm-0 mb-2"
          >
            <button
              class="btn green-btn pr-0 pl-0"
              @click="approvalRequest(announce.id)"
              type="button"
            >
              申請する
            </button>
          </v-col>
        </v-row>

        <!-- ユーザに承認権限がある場合かつ、承認ステータス 0:下書き以外の場合 -->
        <div v-if="approval_auth_flg && announce.approval_status != 0">
          <!-- 区切り線-->
          <hr class="text-center">
          <p class="pt-3 mt-3 mb-4 font-weight-bold text-center">
            承認ステータス
          </p>
          <v-row mb="2" justify="space-around" class="p-1 btn-gap mt-0 pb-5">
            <!-- 承認する - 承認ステータス 1:承認待ちの場合 -->
            <v-col
              v-if="announce.approval_status === 1"
              cols="11"
              class="pt-sm-3 pt-0 pr-0 pl-0 pb-1"
              >
              <button
                class="btn greens-btn"
                @click="approvalAnnounce(announce.id)"
                type="button"
              >
                承認する
              </button>
            </v-col>
            <!-- 承認済み - 承認ステータス 2:承認済みの場合 -->
            <v-col
              v-if="announce.approval_status === 2"
              cols="11"
              class="pt-0 pr-0 pl-0 pb-1"
            >
              <button class="btn disable-btn">承認済み</button>
            </v-col>
            <!-- 承認ステータス 0:下書き、3:差戻し以外の場合 -->
            <v-col
              v-if="announce.approval_status != 0 && announce.approval_status != 3"
              cols="11"
              class="pt-sm-3 pt-0 pr-0 pl-0 pb-1"
            >
              <button
                  class="btn sendbacks-btn"
                  @click="(displayAnnounceReturnApprovalConfirm = true),
                    setApprovalAnnounceId(announce.id)"
                  type="button"
              >
                差し戻す
              </button>
            </v-col>
            <!-- 承認ステータス 3:差戻しの場合 -->
            <v-col
              v-if="announce.approval_status === 3"
              cols="11"
              class="pt-sm-3 pt-0 pr-0 pl-0 pb-1"
            >
              <button class="btn disable-btn">差戻し済み</button>
            </v-col>
            <!-- 承認ステータス 0:取り下げる以外の場合 -->
            <v-col
              v-if="announce.approval_status != 0"
              cols="11"
              class="pt-sm-3 pt-0 pr-0 pl-0 pb-5"
            >
              <button
                @click="approvalCancel(announce.id)"
                class="btn sendbacks-btn"
                type="button"
              >
                取り下げる
              </button>
            </v-col>
          </v-row>
        </div>
      </v-card>
    </v-form>

    <div class="ql-container">
      <p>---お知らせ詳細---</p>
      <div
        class="ql-editor"
        v-html="contents"
        @change="getQuillEditorContent()"
      >
      </div>
    </div>

    <!-- プレビュー画面モーダル -->
    <announce-preview-modal-component
      :modelValue="displayAnnouncePreview"
      @update:modelValue="displayAnnouncePreview = $event"
      :closeAction="closePreview"
      :close_flg=1
      :contents="contents"
      :start_date="announce.start_date"
      :end_date="announce.end_date"
      :username="username"
    />

    <!-- 差し戻しモーダル -->
    <announce-approval-return-confirm-modal-component
      :modelValue="displayAnnounceReturnApprovalConfirm"
      @update:modelValue="displayAnnounceReturnApprovalConfirm = $event"
      :closeAction="closeReturn"
      :approvalReturn="approvalReturn"
    />

</template>

<style src="../css/common.css"></style>
<style scoped>
.accept-stat{
  border-top:1px solid rgba(0,0,0,0.5);
}
</style>

<script>
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import { mapGetters, mapActions } from "vuex";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';
import AnnouncePreviewModalComponent from "../../modals/AnnouncePreviewModalComponent.vue";
import AnnounceApprovalReturnConfirmModalComponent from "../../modals/AnnounceApprovalReturnConfirmModalComponent.vue";

export default {
  components: {
    QuillEditor,
    DatePicker,
    'vue-ctk-date-time-picker': VueCtkDateTimePicker,
    AnnouncePreviewModalComponent,
    AnnounceApprovalReturnConfirmModalComponent,
  },
  props: {
    announceId: String,
  },
  data() {
    return {
      contents: null,
      start_date: null,
      value: null,
      announce: {},
      dataUrl: null,
      file: null,
      rules: {
        required: value => !!value || '必須です。',
      },
      image: [],
      approval_auth_flg: null,
      request_auth_flg: null,
      update_auth_flg: null,
      displayAnnouncePreview: false,
      displayAnnounceReturnApprovalConfirm: false,
      username: null,
    };
  },
  methods: {
    ...mapActions('announceCategory', ['fetchCategories']),
    ...mapActions('announce', ['getAnnounce']),
    ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
    ...mapActions('authority', ['fetchAllAuthority']),
    ...mapActions('enduser', ['getUserInfo']),
    submit() {
      // リッチテキストのhtmlを取得
      const html = this.$refs.myQuillEditor.getHTML();
      this.announce.contents = html;

      const validateRes = this.$refs.form.validate();
      console.log('localStorage');
      console.log(localStorage);
      console.log(localStorage.getItem('auth'));
      validateRes.then(res => {
        if (!res.valid) {
          console.log("invalid!");
          return;
        }
        const postData = {
          title: this.announce.title,
          announce_category_id: this.announce.announce_category_id,
          start_date: moment(this.announce.start_date).format("yyyy-MM-DD"),
          end_date: moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy-MM-DD") : '',
          contents: this.announce.contents,
        }
        this.$axios.put('/api/announce/' + this.announce.id + '/update', postData)
          .then(response => {
            this.openSuccess('更新しました');
            // お知らせ一覧画面に遷移
            this.$router.push({ name: 'announce.list' })
          })
          .catch(error => {
            console.log(error);
          });
      });
    },
    readImage() {
      const inputImage = document.getElementById('image');
      if (inputImage.files.length === 0) {
        return;
      }

      this.file = inputImage.files[0];
      const reader = new FileReader();
      reader.onload = (e) => {
        this.dataUrl = e.target.result;
      }
      reader.readAsDataURL(this.file);
    },
    onEditorBlur(editor) {
      console.log("editor blur!", editor);
    },
    onEditorFocus(editor) {
      console.log("editor focus!", editor);
    },
    onEditorReady(editor) {
      console.log("editor ready!", editor);
    },
    onEditorChange() {},

    // リッチテキストのhtmlを取得
    getQuillEditorContent() {
      const html = this.$refs.myQuillEditor.getHTML();
      this.contents = html;
    },

    // 掲載期間を取得
    getAnnounceDate() {
      const start = moment(this.announce.start_date).isValid() ? moment(this.announce.start_date).format("yyyy/MM/DD HH:mm") : '';
      const end = moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy/MM/DD HH:mm") : '';
      this.announce.start_date = start;
      this.announce.end_date = end;
      this.username = this.username;
      },

    // プレビュー画面を閉じる
    closePreview(){
      this.displayAnnouncePreview = false;
    },

    format(date) {
      return moment(date).format('yyyy/MM/DD');
    },

    // 差戻し確認ダイアログに渡すIDをstoreに設定
      setApprovalAnnounceId(id) {
      let announceId = id;
      this.$store.dispatch("announce/setApprovalAnnounceId", announceId);
    },
    // 差戻しモーダルを閉じる
    closeReturn() {
      this.displayAnnounceReturnApprovalConfirm = false;
    },

    // 申請処理
    approvalRequest(announceId) {
      axios.put("/api/announce/" + announceId + "/request")
      .then((res) => {});
      window.location.reload();
    },
    // 承認処理
    approvalAnnounce(announce) {
      axios.post("/api/announce/" + announce + "/approval")
      .then((res) => {});
      window.location.reload();
    },
    // 差戻し処理
    approvalReturn(announceId) {
      axios.put("/api/announce/" + announceId + "/return", {
          announce: this.announce,
          approvalReturnComment:
          this.$store.state.announce.approvalReturnComment,
      })
      .then((res) => {});
      window.location.reload();
    },
    // 取り下げ処理
    approvalCancel(announceId) {
      axios.put("/api/announce/" + announceId + "/cansel").then((res) => {});
      window.location.reload();
    },
  },
  computed: {
    ...mapGetters("announceCategory", ["getCategories"]),
    editor() {
      return this.$refs.myQuillEditor.quill;
    },
    categories: {
      get() {
        return this.getCategories;
      }
    },
  },
  async mounted() {
    this.announce = await this.getAnnounce(this.announceId);
    this.$refs.myQuillEditor.pasteHTML(this.announce.contents);
    // ユーザの権限セットを取得
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.approval_auth_flg = authority.approval_auth_flg;
      this.request_auth_flg = authority.request_auth_flg;
      this.update_auth_flg = authority.update_auth_flg;
    }
    let name = await this.getUserInfo();
    if(name){
        this.username = name.name;
    }
  },
  created() {
    this.fetchCategories();
  },
};

</script>

<style lang="scss">
.edit_container {
  width: auto;
}

.ql-container {
  height: 200px;
}

.ql-editor h2 {
  border: none;
}

.v-dialog--fullscreen .v-overlay__content{
    width: 100% !important;
}

.v-dialog--fullscreen .v-overlay__content .v-card{
    padding: 0px !important;
}

.accept-stat{
  border-top:1px solid rgba(0,0,0,0.5);
}
</style>
