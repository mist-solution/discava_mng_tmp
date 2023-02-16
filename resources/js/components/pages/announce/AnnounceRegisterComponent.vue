
<template>
  <div>
    <div class="edit-title">
      <h3 class="h4 my-5 text-gray font-weight-bold">新規投稿</h3>
      <!-- エラーメッセージ -->
      <validation-errors :errors="validationErrors" v-if="validationErrors"/>
    </div>
    <v-form ref="form" v-model="valid" class="art-flex">
      <v-card class="main-cont p-3">
        <v-text-field
          class="text-gray"
          dense
          v-model="announce.title"
          :rules="[rules.required]"
          hide-details="false"
          placeholder="タイトルを入力"
        />
        <QuillEditor
          class="ql-editor p-0"
          v-model="contents"
          ref="myQuillEditor"
        >
        </QuillEditor>

        <!-- 添付ファイルのドラッグ＆ドロップ -->
        <!-- ドラッグ＆ドロップでのファイル複数指定に対応のため dragover.prevent でイベントを無くす -->
        <div class="p-3" @dragover.prevent="over" @dragleave.prevent="leave" @drop.prevent="upload($event)">
            <!-- 添付ファイルをここにドラッグ＆ドロップ または -->
            <!-- ファイルを追加 -->
            <v-btn
                class="button-text"
                depressed
                small
                elevation=1
                @click="selectfile()"
            >
            ファイル選択
            </v-btn>
            <input id="file_input" type="file" accept="image/*" hidden multiple @change.prevent="addfile()">
        </div>
        <div class="p-3">
          <EasyDataTable
            v-if="attachments.length > 0"
            :headers="headers"
            :items="attachments"
            :rows-per-page="100"
            hide-footer
            dense
            no-data-text=""
          >
            <template #item-action="item">
              <!-- 削除ボタン -->
              <v-btn
                x-small
                dark
                elevation=0
                @click="deletefile(item)"
              >
                <v-icon>mdi-trash-can-outline</v-icon>
              </v-btn>
            </template>
          </EasyDataTable>
        </div>
      </v-card>
      <v-card class="main-cont mt-5 mt-sm-0 p-3">
        <v-row>
          <v-col cols="3" sm="12" class="mb-4 mb-sm-0 pb-3 pb-sm-0">
            <p class="mt-1 mt-sm-0 mb-1 font-weight-bold text-gray">掲載期間</p>
          </v-col>
          <v-col cols="9" sm="12" class="pt-3 pt-sm-2">
            <v-row align="center" class="mb-3">
              <v-col cols="3" class="pr-0 pb-0">
                <p class="mb-0 text-gray">開始</p>
              </v-col>
              <v-col cols="9" class="pl-0 pb-0">
                <DatePicker
                  v-model="announce.start_date"
                  placeholder="掲載開始日"
                  :format="format"
                  :preview-format="previewFormat"
                  :required="isRequired ? ['rules.required'] : []"
                  selectText="確認"
                  cancelText="キャンセル"
                />
              </v-col>
              <v-col cols="12" class="mt-2 p-0 Date-time">
                <v-row  align="center" class="m-0 time-pick">
                  <v-col cols="3" class="p-0"></v-col>
                  <v-col cols="2" class="p-0">
                    <label class="ml-2">{{getStartHours}}</label>
                    <!-- <v-text-field
                        dense
                        hide-details="false"
                    /> -->
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <p class="text-gray">時</p>
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <label class="ml-2">{{getStartMins}}</label>
                    <!-- <v-text-field
                        dense
                        hide-details="false"
                    /> -->
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <p class="text-gray">分</p>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-row align="center" class="mb-3">
                <v-col cols="3" class="pr-0 pb-0">
                  <p class="mb-0 text-gray">終了</p>
                </v-col>
                <v-col cols="9" class="pl-0 pb-0">

                <DatePicker
                  v-model="announce.end_date"
                  placeholder="掲載終了日"
                  :format="format"
                  :preview-format="previewFormat"
                  :required="false"
                  selectText="確認"
                  cancelText="キャンセル"
                />
              </v-col>
              <v-col cols="12" class="mt-2 p-0 Date-time">
                <v-row  align="center" class="m-0 time-pick">
                  <v-col cols="3" class="p-0"></v-col>
                  <v-col cols="2" class="p-0">
                    <label class="ml-2">{{getEndHours}}</label>
                    <!-- <v-text-field
                        dense
                        hide-details="false"
                    /> -->
                  </v-col>
                  <v-col cols="2" class="p-0 text-gray">
                    <p>時</p>
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <label class="ml-2">{{getEndMins}}</label>
                    <!-- <v-text-field
                        dense
                        hide-details="false"
                    /> -->
                  </v-col>
                  <v-col cols="2" class="p-0 text-gray">
                    <p>分</p>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="3" sm="12" class="pt-3 pb-3 pr-0 mb-4 mb-sm-0 pt-sm-0 pb-sm-0">
            <p class="mt-2 mt-sm-4 mb-1 font-weight-bold text-gray">カテゴリー</p>
          </v-col>
          <v-col cols="9" sm="12" class="pt-3 pt-sm-2">
            <v-select
              dense
              v-model="announce.announce_category_id"
              :items="categories"
              item-value="id"
              item-title="category_name"
              class="cat-tag"
              hide-details="false"
              :rules="isRequired ? ['rules.required'] : []"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="3" sm="12" class="pr-0 pb-3 pb-sm-0">
            <p class=" mt-2 mt-sm-4 mb-1 font-weight-bold text-gray">サムネイル画像</p>
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
        <v-row mb="2" justify="space-around" class="p-1 btn-gap mt-4">
          <v-col cols="11" class="pt-0 px-0">
            <button class="pr-0 pl-0 btn white-btn" @click="(displayAnnouncePreview = true),getQuillEditorContent(),getAnnounceDate()">
              プレビュー
            </button>
          </v-col>
          <v-col cols="11" class="pt-0 px-0">
            <button class="btn green-btn pr-0 pl-0" @click="submit(2)">下書き保存</button>
          </v-col>
          <v-col cols="11" class="pt-0 px-0">
            <button class="btn green-btn" @click="submit(1)">登録する</button>
          </v-col>
        </v-row>
      </v-card>
    </v-form>

    <!--- プレビュー -->
    <!--- <div class="ql-container">
      <p>---お知らせ詳細---</p>
      <div
        class="ql-editor"
        v-html="contents"
        @change="getQuillEditorContent()"
      ></div>
    </div> -->
  </div>

  <!-- プレビュー画面モーダル -->
  <announce-preview-modal-component
    :modelValue="displayAnnouncePreview"
    @update:modelValue="displayAnnouncePreview = $event"
    :closeAction="closePreview"
    :contents="contents"
    :start_date="announce.start_date"
    :end_date="announce.end_date"
    :username="username"
  />
</template>

<style src="../css/common.css"></style>

<script>
import { mapGetters, mapActions, mapState } from "vuex";
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';
import AnnouncePreviewModalComponent from "../../modals/AnnouncePreviewModalComponent.vue"
import ValidationErrors from "../../ValidationErrors.vue";

export default {
  
  components: {
    DatePicker,
    AnnouncePreviewModalComponent,
    ValidationErrors,
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
      attachments: [],
      rules: {
        required: value => !!value || '必須です。',
      },
      headers: [
          { text: 'ファイル名', value: 'name', align: 'left', class: 'no-wrap', sortable: false },
          { text: '', value: 'action', align: 'right', class: 'action', sortable: false },
      ],
      isRequired: false,
    };
  },
  methods: {
    ...mapActions('announceCategory', ['fetchCategories']),
    ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
    ...mapActions('authority', ['fetchAllAuthority']),
    ...mapActions('enduser', ['getUserInfo']),
    submit(registFlg) {
      // リッチテキストのhtmlを取得
      const html = this.$refs.myQuillEditor.getHTML();
      this.announce.contents = html;

      if (this.announce.contents === "<p><br></p>"){
        this.announce.contents = null
      }

      // 検証項目
      const validateItem = {
        title: this.announce.title,
        announce_category_id: this.announce.announce_category_id,
        start_date: moment(this.announce.start_date).isValid() ? moment(this.announce.start_date).format("yyyy/MM/DD HH:mm:00") : null,
        end_date: moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy/MM/DD HH:mm:59") : null,
        contents: this.announce.contents,
        thumbnail_file_name: this.file ? this.file.name : null,
      };

      // 下書き保存と登録する場合による、必須項目をTrueにする
      if(registFlg == 1){
        this.isRequired = true;
      }else if(registFlg == 2){
        this.isRequired = false
      }
      
      // 必須項目を検証する
      const validateRes = this.$refs.form.validate();
      validateRes.then(res => {
        console.log(res);
          if(registFlg == 1) {
            // 必須項目を検証する
            axios.post('/api/announce/registValidation',validateItem )
            .then(response => {
              let formData = new FormData();
              const item = {
                title: encodeURIComponent(this.announce.title),
                announce_category_id: this.announce.announce_category_id,
                start_date: moment(this.announce.start_date).isValid() ? moment(this.announce.start_date).format("yyyy/MM/DD HH:mm:00") : null,
                end_date: moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy/MM/DD HH:mm:59") : null,
                contents: encodeURIComponent(this.announce.contents),
                thumbnail_file_name: this.file ? this.file.name : null,
                regist_flg: registFlg,
              };
              formData.append("announce", JSON.stringify(item));

              console.log(this.file)
              if (this.file) {
                formData.append("thumbnail_file", this.file);
              }

              for (let i = 0; i < this.attachments.length; i++) {
                formData.append('attachments[' + i + ']', this.attachments[i]);
              }
              console.log(formData)

              const config = {
                headers: {
                  "Content-type": "multipart/form-data",
                },
              };

              // axios.post('/api/announce', formData, config)
              axios.post('/api/announce/regist',
                formData,
                { headers: { "Content-type": "multipart/form-data", }}
              ).then(response => {
                if(registFlg == 1){
                  this.openSuccess('登録しました');
                }else if(registFlg == 2){
                  this.openSuccess('保存しました');
                }
                // お知らせ一覧画面に遷移
                this.$router.push({ name: 'announce.list' })

                  // バリデーションのメッセージを初期化する
                  this.$store.dispatch("announce/setAnnounceErrorMessages", "");
              })
              .catch(error => {
                console.log(error);
              });
            })
            .catch(error => {
              if (error.response.status !== 422) {
                console.error(error);
              } else {
                this.$store.dispatch("announce/setAnnounceErrorMessages", error.response.data.errors);
              }
            });
          }else if (registFlg == 2){
            // 必須項目を検証する
            axios.post('/api/announce/tempValidation',validateItem )
            .then(response => {
              let formData = new FormData();
              const item = {
                title: encodeURIComponent(this.announce.title),
                announce_category_id: this.announce.announce_category_id,
                start_date: moment(this.announce.start_date).isValid() ? moment(this.announce.start_date).format("yyyy/MM/DD HH:mm:00") : null,
                end_date: moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy/MM/DD HH:mm:59") : null,
                contents: encodeURIComponent(this.announce.contents),
                thumbnail_file_name: this.file ? this.file.name : null,
                regist_flg: registFlg,
              };
              formData.append("announce", JSON.stringify(item));

              console.log(this.file)
              if (this.file) {
                formData.append("thumbnail_file", this.file);
              }

              for (let i = 0; i < this.attachments.length; i++) {
                formData.append('attachments[' + i + ']', this.attachments[i]);
              }
              console.log(formData)

              const config = {
                headers: {
                  "Content-type": "multipart/form-data",
                },
              };

              // axios.post('/api/announce', formData, config)
              axios.post('/api/announce/regist',
                formData,
                { headers: { "Content-type": "multipart/form-data", }}
              ).then(response => {
                if(registFlg == 1){
                  this.openSuccess('登録しました');
                }else if(registFlg == 2){
                  this.openSuccess('保存しました');
                }
                // お知らせ一覧画面に遷移
                this.$router.push({ name: 'announce.list' })

                  // バリデーションのメッセージを初期化する
                  this.$store.dispatch("announce/setAnnounceErrorMessages", "");
              })
              .catch(error => {
                console.log(error);
              });
            })
            .catch(error => {
              if (error.response.status !== 422) {
                console.error(error);
              } else {
                this.$store.dispatch("announce/setAnnounceErrorMessages", error.response.data.errors);
              }
            });
          }
          console.log("invalid!");
          return;
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
    // リッチテキストのhtmlを取得
    getQuillEditorContent() {
      const html = this.$refs.myQuillEditor.getHTML();
      this.contents = html;
    },
    // 掲載期間を取得
    getAnnounceDate() {
      const start = moment(this.announce.start_date).isValid() ? moment(this.announce.start_date).format("yyyy/MM/DD HH:mm") : null;
      const end = moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy/MM/DD HH:mm") : null;
      this.announce.start_date = start;
      this.announce.end_date = end;
      this.username = this.username;
    },

    // click() {
    //   console.log("click!");
    //   console.log(this.announce.thumbnail_file);
    //   console.log(this.announce.thumbnail_file["0"].name);
    // },

    format(date) {
      return moment(date).format('yyyy/MM/DD');
    },
    
    previewFormat(date) {
      return moment(date).format('yyyy/MM/DD HH:mm');
    },

    closePreview(){
      this.displayAnnouncePreview = false;
    },
    // ドラッグ＆ドロップでファイルを追加
    upload: function(event) {
        const files = event.dataTransfer.files;
        for (const file of files) {
          this.attachments.push(file);
        }
        this.leave(event);
    },
    // ファイルを追加ボタン押下
    selectfile: function() {
        const fileInput = document.getElementById("file_input")
        if (fileInput != null) {
            fileInput.click()
        }
    },
    // ファイルを追加ボタンでファイルを追加
    addfile: function() {
        const fileInput = document.getElementById("file_input")
        for (const file of fileInput.files) {
          this.attachments.push(file);
          // 表示用タグとして本文に追加
          let text = this.$refs.myQuillEditor.getText();
          text = text + '\n' + '[['+file.name+']]';
          this.$refs.myQuillEditor.setText(text);
        }
    },
    // 削除ボタン押下
    deletefile: function(item) {
      this.attachments = this.attachments.filter(a => a.name !== item.name);
    },
    over: function(event) {
        if (event.target.classList && event.target.classList.contains("file-upload")) {
            event.target.style.backgroundColor = '#CE93D8'
        }
    },
    leave: function(event) {
        if (event.target.classList && event.target.classList.contains("file-upload")) {
            event.target.style.backgroundColor = ''
        }
    },
  },
  computed: {
    ...mapGetters("announceCategory", ["getCategories"]),
    ...mapState({
      validationErrors: state => state.announce.announceErrorMessages
    }),
    editor() {
      return this.$refs.myQuillEditor.quill;
    },
    categories: {
      get() {
        return this.getCategories;
      }
    },
    getStartHours(){
      if(this.announce.start_date){
        return moment(this.announce.start_date).format("HH")
      }
    },
    getStartMins(){
      if(this.announce.start_date){
        return moment(this.announce.start_date).format("mm")
      }
    },
    getEndHours(){
      if(this.announce.end_date){
        return moment(this.announce.end_date).format("HH")
      }
    },
    getEndMins(){
      if(this.announce.end_date){
        return moment(this.announce.end_date).format("mm")
      }
    }
  },
  created() {
    this.fetchCategories();
  },
  async mounted() {
    // バリデーションのメッセージを初期化する
    this.$store.dispatch("announce/setAnnounceErrorMessages", "");
    
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

<style src="../css/dropdown.css"></style>
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

// 文字色、文字背景色のカラーピッカー位置修正（SP）
@media (max-width: 600px){
  .ql-snow .ql-color-picker .ql-picker-options{
    width: 92px!important;
    margin-left: -2rem !important;
  }
}

</style>
