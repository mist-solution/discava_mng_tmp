
<template>
    <div>
      <h3 class="h4 mb-2 mb-sm-5 mt-2 mt-sm-5">投稿者　の投稿記事を編集</h3>
    </div>
      <v-form ref="form" v-model="valid" class="art-flex">
        <v-card class="main-cont p-3">

              <v-text-field
                dense
                v-model="announce.title"
                :rules="[rules.required]"
                hide-details="false"
              />

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

        </v-card>
        <v-card class="main-cont mt-5 mt-sm-0 p-3">
          <p class="mb-1 font-weight-bold">掲載期間</p>
            <v-row align="center" class="mb-3 justify-end">
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
              <v-col cols="11" class="mt-2 p-0 Date-time">
                <v-row  align="center" class="justify-end m-0">
                  <v-col cols="3" class="p-0">
                    <v-text-field
                        dense
                        hide-details="false"
                    />
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <p>時</p>
                  </v-col>
                  <v-col cols="3" class="p-0">
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
            <v-row align="center">
                <v-col cols="3" class="pr-0">
                  <p class="mb-0">終了</p>
                </v-col>
                <v-col cols="9" class="pl-0">

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
          <p class="mt-4 mb-1 font-weight-bold">カテゴリー</p>

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
          <p class="mt-4 mb-1 font-weight-bold">サムネイル画像</p>

            <div class="samb-box">

            </div>


          <v-row mb="2" justify="end">
            <button class="btn btn-success mr-2" @click="getQuillEditorContent()">プレビュー</button>
            <button class="btn btn-success mr-2" @click="submit">更新</button>
          </v-row>
        </v-card>
      </v-form>
      <div class="ql-container">
        <p>---お知らせ詳細---</p>
        <div
          class="ql-editor"
          v-html="contents"
          @change="getQuillEditorContent()"
        ></div>
      </div>
</template>
<style src="../css/common.css"></style>
<style scoped>
  .art-flex{
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    row-gap:16px;
  }
  .art-flex .main-cont:nth-child(1){
    width:78%;
  }
  .art-flex .main-cont:nth-child(2){
    width:20%;
    min-width: 180px;
  }
  .art-flex p{
    font-size:.85rem;
    margin:0;
  }

  @media (max-width: 1090.99px){
    .art-flex .main-cont:nth-child(1){
        width:95%;
      }
      .art-flex .main-cont:nth-child(2){
        width:20%;
        min-width: 180px;
      }
  }
  @media (max-width: 599.99px){
    .art-flex .main-cont:nth-child(1){
        width:95%;
      }
      .art-flex .main-cont:nth-child(2){
        width:95%;
      }
  }
  .samb-box{
    aspect-ratio: 16 / 9;
    width:100%;
  }
  .Date-time .v-input{
    border:solid 1px rgba(0,0,0,0.6);
    border-radius: 7px;
  }
  .Date-time .v-input--density-default .v-field--variant-filled {
    --v-input-control-height: 24px;
  }
  .Date-time p{
    text-align: center;
  }
</style>
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
