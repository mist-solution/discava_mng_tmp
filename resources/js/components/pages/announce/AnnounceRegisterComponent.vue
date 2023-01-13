
<template>
  <div>
    <div>
      <h3 class="h4 mb-2 mb-sm-5 mt-2 mt-sm-5 ml-5">新規投稿</h3>
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
                        v-model="end_hour.hour"
                    />
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <p>時</p>
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <v-text-field
                        dense
                        hide-details="false"
                        v-model="end_hour.hour"
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

          <v-row mb="2" justify="space-around" class="p-1 btn-gap mt-4">
            <v-col cols="11" class="pt-0 px-0">
              <button class="pr-0 pl-0 btn white-btn" @click="(displayAnnouncePreview = true),getQuillEditorContent(),getAnnounceDate()">プレビュー</button>
            </v-col>
            <v-col cols="11" class="pt-0 px-0">
              <button class="btn green-btn pr-0 pl-0" @click="submit">下書き保存</button>
            </v-col>
            <v-col cols="11" class="pt-0 px-0">
              <button class="btn green-btn" @click="submit">登録する</button>
            </v-col>
        </v-row>
      </v-card>
    </v-form>

    <!--- プレビュー -->
    <div class="ql-container">
      <p>---お知らせ詳細---</p>
      <div
        class="ql-editor"
        v-html="contents"
        @change="getQuillEditorContent()"
      ></div>
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
</template>

<style src="../css/common.css"></style>

<script>
import { mapGetters, mapActions } from "vuex";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';
import AnnouncePreviewModalComponent from "../../modals/AnnouncePreviewModalComponent.vue"

export default {
  
  components: {
    QuillEditor,
    DatePicker,
    AnnouncePreviewModalComponent,
  },
  data() {
    return {
      contents: null,
      start_date: null,
      dataUrl: null,
      file: null,
      approval_auth_flg: null,
      request_auth_flg: null,
      displayAnnouncePreview: false,
      username: null,
      announce: {
        title: null,
        announce_category_id: null,
        start_date: null,
        end_date: null,
        contents: null,
      },
      rules: {
        required: value => !!value || '必須です。',
      },
    };
  },
  methods: {
    ...mapActions('announceCategory', ['fetchCategories']),
    ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
    ...mapActions('authority', ['fetchAllAuthority']),
    ...mapActions('enduser', ['getUserInfo']),
    submit() {
      // リッチテキストのhtmlを取得
      const html = this.$refs.myQuillEditor.getHTML();
      this.announce.contents = html;

      const validateRes = this.$refs.form.validate();
      validateRes.then(res => {
        if (!res.valid) {
          console.log("invalid!");
          return;
        }
        let formData = new FormData();
        const item = {
          title: this.announce.title,
          announce_category_id: this.announce.announce_category_id,
          start_date: moment(this.announce.start_date).format("yyyy-MM-DD"),
          end_date: moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy-MM-DD") : '',
          contents: this.announce.contents,
          thumbnail_file_name: this.announce.thumbnail_file ? this.announce.thumbnail_file["0"].name : null,
        };
        formData.append("announce", JSON.stringify(item));

        if (this.announce.thumbnail_file) {
          formData.append("thumbnail_file", this.announce.thumbnail_file["0"]);
        } else {
          formData.append("thumbnail_file", {});
        }
        console.log(formData)

        const config = {
          headers: {
            "Content-type": "multipart/form-data",
          },
        };

        // axios.post('/api/announce', formData, config)
        axios.post('/api/announce', formData, { headers: { "Content-type": "multipart/form-data", }})
          .then(response => {
            this.openSuccess('登録しました');
            // お知らせ一覧画面に遷移
            this.$router.push({ name: 'news.list' })
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

    click() {
      console.log("click!");
      console.log(this.announce.thumbnail_file);
      console.log(this.announce.thumbnail_file["0"].name);
    },

    format(date) {
      return moment(date).format('yyyy/MM/DD');
    },

    closePreview(){
      this.displayAnnouncePreview = false;
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
  created() {
    this.fetchCategories();
  },
  async mounted() {
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.approval_auth_flg = authority.approval_auth_flg;
      this.request_auth_flg = authority.request_auth_flg;
    }
    let name = await this.getUserInfo();
    if(name){
        this.username = name.name;
    }
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

</style>
