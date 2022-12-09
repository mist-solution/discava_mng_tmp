
<template>
  <v-card>
    <v-container class="grey lighten-5">
      <v-form ref="form" v-model="valid">
        <v-row>
            掲載期間
        </v-row>
        <v-row>
          <v-col cols="1" md="1">
            開始
          </v-col>  
          <v-col cols="3" md="3">
            <DatePicker
              v-model="announce.start_date"
              placeholder="掲載開始日"
              :format="format"
              :enableTimePicker="false"
              :required="true"
              selectText="確認"
              cancelText="キャンセル"
              locale="ja"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <DatePicker hourPicker
              :format="format"
              :required="true"
              selectText="確認"
              cancelText="キャンセル"
              locale="ja"
            />
          </v-col>
          <v-col cols="1">
            時
          </v-col>
          <v-col>
            <DatePicker minutePicker
              :format="format"
              :required="true"
              selectText="確認"
              cancelText="キャンセル"
              locale="ja"
            />
          </v-col>
          <v-col cols="1">
            分
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="1" md="1">
            終了
          </v-col>  
          <v-col cols="3" md="3">
            <DatePicker
              v-model="announce.end_date"
              placeholder="掲載終了日"
              :format="format"
              :enableTimePicker="false"
              :required="false"
              selectText="確認"
              cancelText="キャンセル"
              locale="ja"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <DatePicker hourPicker
              :format="format"
              :required="true"
              selectText="確認"
              cancelText="キャンセル"
              locale="ja"
            />
          </v-col>
          <v-col cols="1">
            時
          </v-col>
          <v-col>
            <DatePicker minutePicker
              :format="format"
              :required="true"
              selectText="確認"
              cancelText="キャンセル"
              locale="ja"
            />
          </v-col>
          <v-col cols="1">
            分
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
          </v-col>
        </v-row>
      </v-form>
    </v-container>
    <v-card-title class="ml-2" width="80%">
      <v-row mb="2" justify="end">
        <button class="btn btn-success mr-2" @click="getQuillEditorContent()">プレビュー</button>
        <button class="btn btn-success mr-2" @click="submit">更新</button>
      </v-row>
    </v-card-title>
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
  props: {
    announceId: String,
  },
  data() {
    return {
      contents: null,
      start_date: null,
      announce: {},
      rules: {
        required: value => !!value || '必須です。',
      },
    };
  },
  methods: {
    ...mapActions('announceCategory', ['fetchCategories']),
    ...mapActions('announce', ['getAnnounce']),
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
        this.$axios.put('/api/announce/' + this.announce.id + '/update', postData)
          .then(response => {
            this.openSuccess('更新しました');
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
  async mounted() {
    this.announce = await this.getAnnounce(this.announceId);
    this.$refs.myQuillEditor.pasteHTML(this.announce.contents);
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
