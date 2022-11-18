
<template>
  <v-card>
    <v-card-title class="ml-2" width="80%">
      <h3 class="h4">お知らせ登録</h3>
      <v-row mb="2" justify="end">
        <button class="btn btn-success mr-2" @click="getQuillEditorContent()">プレビュー</button>
        <button class="btn btn-success mr-2" @click="submit">承認申請</button>
      </v-row>
    </v-card-title>
    <v-container class="grey lighten-5">
      <v-form ref="form" v-model="valid">
        <v-row>
          <v-col>
            <v-text-field
              dense
              v-model="announce.title"
              label="タイトル"
              :rules="[rules.required]"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="6">
            <v-select
              dense
              v-model="announce.announce_category_id"
              :items="categories"
              label="カテゴリ"
              item-value="id"
              item-title="category_name"
              :rules="[rules.required]"
            />
            {{categories}}
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="6">
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
        </v-row>
        <v-row>
          <v-col cols="12" md="6">
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
        </v-row>
        <v-row>
          <v-col>
            <QuillEditor
              toolbar="full"
              class="ql-editor"
              v-model="contents"
              ref="myQuillEditor"
              :options="editorOption"
              :rules="[rules.required]"
              @blur="onEditorBlur($event)"
              @focus="onEditorFocus($event)"
              @change="onEditorChange($event)"
            >
            </QuillEditor>
          </v-col>
        </v-row>
      </v-form>
      <div class="ql-container">
        <p>---お知らせ詳細---</p>
        <div
          class="ql-editor"
          v-html="contents"
          @change="getQuillEditorContent()"
        ></div>
      </div>
    </v-container>
  </v-card>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';

export default {
  components: {
    QuillEditor,
    DatePicker,
  },
  data() {
    return {
      contents: null,
      start_date: null,
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
        this.$axios.post('/api/announce', postData)
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

    format(date) {
      return moment(date).format('yyyy/MM/DD');
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
</style>
