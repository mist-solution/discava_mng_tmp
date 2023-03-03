
<template>
  <div>
    <div class="edit-title mt-5">
      <h3 class="h4 my-5 text-gray font-weight-bold">投稿記事編集</h3>
      <!-- エラーメッセージ -->
    <validation-errors :errors="validationErrors" v-if="validationErrors"/>
    <div v-if="announce.approval_status === 3">差戻しコメント：{{ announce.remand_comment }}</div>
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
          :rules="[rules.required]"
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
                  :required="isRequired ? ['rules.required'] : ''"
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
                        v-model="getStartHours"
                        dense
                        hide-details="false"
                        disabled
                    /> -->
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <p class="text-gray">時</p>
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <label class="ml-2">{{getStartMins}}</label>
                    <!-- <v-text-field
                        v-model="getStartMins"
                        dense
                        hide-details="false"
                        disabled
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
                        v-model="getEndHours"
                        dense
                        hide-details="false"
                        disabled
                    /> -->
                  </v-col>
                  <v-col cols="2" class="p-0 text-gray">
                    <p>時</p>
                  </v-col>
                  <v-col cols="2" class="p-0">
                    <label class="ml-2">{{getEndMins}}</label>
                    <!-- <v-text-field
                        v-model="getEndMins"
                        dense
                        hide-details="false"
                        disabled
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
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="3" sm="12" class="pr-0 pb-3 pb-sm-0">
            <p class="mt-2 mt-sm-4 mb-1 font-weight-bold text-gray">サムネイル画像</p>
          </v-col>
          <v-col cols="9" sm="12" class="pt-3 pt-sm-2">
            <div class="samb-box">
              <div v-if="!dataUrl && !announce.thumbnail_img_path">
                <label for="image" class="samb-none"></label>
                <input type="file" id="image" accept="image/*" @change="readImage">
              </div>
              <div v-if="!dataUrl && announce.thumbnail_img_path">
                <div id="image-preview">
                    <img :src=" '../../' + announce.thumbnail_img_path" v-if="announce.thumbnail_img_path">
                </div>
                <label for="image" class="samb-on"></label>
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
            <button
              type="button"
              class="pr-0 pl-0 btn white-btn"
              @click="(displayAnnouncePreview = true),
              getQuillEditorContent(),getAnnounceDate()"
            >
              プレビュー
            </button>
          </v-col>
        </v-row>
        <v-row class="p-1 btn-gap mt-4 justify-center mb-3">
          <!-- 更新する - ユーザに更新権限がある場合 -->
          <v-col
            v-if="update_auth_flg"
            cols="11"
            class="p-0 mb-sm-0 mb-2"
          >
            <button
              class="btn green-btn pr-0 pl-0"
              @click.prevent="submit()"
              type="button"
            >
              更新する
            </button>
          </v-col>
          <!-- 申請する - ユーザに申請権限がある場合かつ、承認ステータス 2:承認済み、1:承認待ち 以外の場合、-->
          <v-col
            v-if="request_auth_flg &&
              (announce.approval_status === 0 || announce.approval_status === 3)"
            cols="11"
            class="p-0 mb-sm-0 mb-2 mt-3"
          >
            <button
              class="btn green-btn pr-0 pl-0"
              @click="approvalRequest(announce.id)"
              type="button"
            >
              申請する
            </button>
          </v-col>
          <!-- 更新権限があるかつ、承認ステータス 0:取り下げる以外の場合 -->
          <v-col
            v-if="update_auth_flg &&
              (announce.approval_status === 1 || announce.approval_status === 2)"
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

        <!-- ユーザに承認権限がある場合かつ、承認ステータス 0:下書き以外の場合 -->
        <div v-if="approval_auth_flg">
          <!-- 区切り線-->
          <hr class="text-center">
          <p class="pt-3 mt-3 mb-4 font-weight-bold text-left text-gray">
            承認ステータス
          </p>
          <p class="ml-3"
            :class="getApprovalStatusColor(announce.approval_status)">
            【{{this.getApprovalStatus(announce.approval_status)}}】
          </p>
          <v-row mb="2" justify="space-around" class="p-1 btn-gap mt-0 pb-5">
            <!-- 承認する - 承認ステータス 2:承認済み以外の場合 -->
            <v-col cols="11" class="pt-sm-3 pt-0 pr-0 pl-0 pb-1 mb-3" >
              <button
                v-if="announce.approval_status != 2"
                class="btn greens-btn"
                @click.prevent="approvalAnnounce(announce.id)"
                type="button"
              >
                承認する
              </button>
            </v-col>
            <!-- 承認済み - 承認ステータス 2:承認済みの場合 -->
            <v-col
              v-if="announce.approval_status === 2"
              cols="11"
              class="pt-0 pr-0 pl-0 pb-1 text-center"
            >
              <button class="btn disable-btn">承認済み</button>
            </v-col>
            <!-- 承認ステータス 0:下書き、3:差戻し以外の場合 -->
            <v-col
              v-if="announce.approval_status != 0 && announce.approval_status != 3"
              cols="11"
              class="pt-0 pr-0 pl-0 pb-1"
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
              class="pt-sm-3 pt-0 pr-0 pl-0 pb-1 text-center"
            >
              <button class="btn disable-btn">差戻し済み</button>
            </v-col>
          </v-row>
        </div>
      </v-card>
    </v-form>

    <!-- <div class="ql-container">
      <p>---お知らせ詳細---</p>
      <div
        class="ql-editor"
        v-html="contents"
        @change="getQuillEditorContent()"
      >
      </div> -->
  </div>

  <!-- プレビュー画面モーダル -->
  <announce-preview-modal-component
    v-if="categories[announce.announce_category_id - 1]"
    :modelValue="displayAnnouncePreview"
    @update:modelValue="displayAnnouncePreview = $event"
    :closeAction="closePreview"
    :contents="contents"
    :start_date="announce.start_date"
    :end_date="announce.end_date"
    :title="announce.title"
    :category="categories[announce.announce_category_id - 1].category_name"
    :flg=true
  />

  <!-- 差し戻しモーダル -->
  <announce-approval-return-confirm-modal-component
    :modelValue="displayAnnounceReturnApprovalConfirm"
    @update:modelValue="displayAnnounceReturnApprovalConfirm = $event"
    :closeAction="closeReturn"
    :approvalReturn="approvalReturn"
  />

</template>

<script>
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import { mapGetters, mapActions, mapState } from "vuex";
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';
import AnnouncePreviewModalComponent from "../../modals/AnnouncePreviewModalComponent.vue";
import AnnounceApprovalReturnConfirmModalComponent from "../../modals/AnnounceApprovalReturnConfirmModalComponent.vue";
import ValidationErrors from "../../ValidationErrors.vue";

export default {
  components: {
    DatePicker,
    'vue-ctk-date-time-picker': VueCtkDateTimePicker,
    AnnouncePreviewModalComponent,
    AnnounceApprovalReturnConfirmModalComponent,
    ValidationErrors,
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
      attachments: [],
      loadAttachments: [],
      insertAttachments: [],
      deleteAttachments: [],
      headers: [
          { text: 'ファイル名', value: 'name', align: 'left', class: 'no-wrap', sortable: false },
          { text: '', value: 'action', align: 'right', class: 'action', sortable: false },
      ],
      isRequired: false,
      flg: false,
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
      if(this.announce.approval_status != 0){
        this.isRequired = true;
      }else{
        this.isRequired = false;
      }

      const validateRes = this.$refs.form.validate();
      validateRes.then(res => {
        console.log(res);
        // if (!res.valid || validateItem.contents == null) {
          if(this.announce.approval_status != 0) {
            axios.post('/api/announce/registValidation', validateItem )
            .then(response => {
              let formData = new FormData();
              const item = {
                title: encodeURIComponent(this.announce.title),
                announce_category_id: this.announce.announce_category_id,
                start_date: moment(this.announce.start_date).isValid() ? moment(this.announce.start_date).format("yyyy/MM/DD HH:mm:00") : null,
                end_date: moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy/MM/DD HH:mm:59") : null,
                contents: encodeURIComponent(this.announce.contents),
                thumbnail_img_path: this.file ? this.file.name : null,
              }

              formData.append("announce", JSON.stringify(item));

              if (this.file) {
                formData.append("thumbnail_file", this.file);
              }


              for (let i = 0; i < this.insertAttachments.length; i++) {
                formData.append('insertAttachments[' + i + ']', this.insertAttachments[i]);
              }

              for (let i = 0; i < this.deleteAttachments.length; i++) {
                formData.append('deleteAttachments[' + i + ']', JSON.stringify(this.deleteAttachments[i]));
              }

              // Larabel は multipart/form-data を put で処理できないため post
              axios.post('/api/announce/' + this.announce.id + '/update',
                formData,
                { headers: { "Content-type": "multipart/form-data", }}
              ).then(response => {
                this.openSuccess('更新しました');
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
                this.scrollTop()
                this.$store.dispatch("announce/setAnnounceErrorMessages", error.response.data.errors);
              }
            });
          } else {
            axios.post('/api/announce/tempValidation', validateItem )
            .then(response => {
              let formData = new FormData();
              const item = {
                title: encodeURIComponent(this.announce.title),
                announce_category_id: this.announce.announce_category_id,
                start_date: moment(this.announce.start_date).isValid() ? moment(this.announce.start_date).format("yyyy/MM/DD HH:mm:00") : null,
                end_date: moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy/MM/DD HH:mm:59") : null,
                contents: encodeURIComponent(this.announce.contents),
                thumbnail_img_path: this.file ? this.file.name : null,
              }
              formData.append("announce", JSON.stringify(item));

              if (this.file) {
                formData.append("thumbnail_file", this.file);
              }

              console.log(this.file)

              for (let i = 0; i < this.insertAttachments.length; i++) {
                formData.append('insertAttachments[' + i + ']', this.insertAttachments[i]);
              }

              for (let i = 0; i < this.deleteAttachments.length; i++) {
                formData.append('deleteAttachments[' + i + ']', JSON.stringify(this.deleteAttachments[i]));
              }

              // Larabel は multipart/form-data を put で処理できないため post
              axios.post('/api/announce/' + this.announce.id + '/update',
                formData,
                { headers: { "Content-type": "multipart/form-data", }}
              ).then(response => {
                this.openSuccess('更新しました');
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
                this.scrollTop()
                this.$store.dispatch("announce/setAnnounceErrorMessages", error.response.data.errors);
              }
            });
          }
          console.log("invalid!");
          return;
        // }
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
      const start = moment(this.announce.start_date).isValid() ? moment(this.announce.start_date).format("yyyy/MM/DD HH:mm") : '';
      const end = moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy/MM/DD HH:mm") : '';
      this.announce.start_date = start;
      this.announce.end_date = end;
      this.username = this.username;
    },

    format(date) {
      return moment(date).format('yyyy/MM/DD');
    },

     previewFormat(date) {
      return moment(date).format('yyyy/MM/DD HH:mm');
    },

    // プレビュー画面を閉じる
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
          const sameNameFiles = this.attachments.filter(a => a.name == file.name);
          if(sameNameFiles.length > 0) {
            // 同名ファイルの追加は行えない
            continue;
          }

          this.attachments.push(file);
          this.insertAttachments.push(file);
          // 表示用タグとして本文に追加
          let text = this.$refs.myQuillEditor.getText();
          text = text + '\n' + '[['+file.name+']]';
          this.$refs.myQuillEditor.setText(text);
        }
    },
    // 削除ボタン押下
    deletefile: function(item) {
      this.attachments = this.attachments.filter(a => a.name !== item.name);

      const deleteFiles = this.loadAttachments.filter(a => a.img_filename == item.name);
      if (deleteFiles.length > 0) {
        this.deleteAttachments.push(deleteFiles[0]);
      }
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
      .then((res) => {
        this.openSuccess('申請しました');
        // スナックバーの表示時間が経ってから実行
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      });
    },
    // 承認処理
    approvalAnnounce(announce) {
      // お知らせが承認する場合、開始掲載日、カテゴリーカラムを必須にする
      if(this.announce.approval_status != 2){
        this.isRequired = true;
      }else{
        this.isRequired = false;
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

      const validateRes = this.$refs.form.validate();
      validateRes.then(res => {
        if(this.announce.approval_status != 2) {
          axios.post('/api/announce/registValidation', validateItem )
          .then(response => {
            // バリデーションがOKの場合
            // お知らせ記事を更新する
            let formData = new FormData();
            const item = {
              title: encodeURIComponent(this.announce.title),
              announce_category_id: this.announce.announce_category_id,
              start_date: moment(this.announce.start_date).isValid() ? moment(this.announce.start_date).format("yyyy/MM/DD HH:mm:00") : null,
              end_date: moment(this.announce.end_date).isValid() ? moment(this.announce.end_date).format("yyyy/MM/DD HH:mm:59") : null,
              contents: encodeURIComponent(this.announce.contents),
              thumbnail_img_path: this.file ? this.file.name : null,
            }

            formData.append("announce", JSON.stringify(item));

            if (this.file) {
              formData.append("thumbnail_file", this.file);
            }


            for (let i = 0; i < this.insertAttachments.length; i++) {
              formData.append('insertAttachments[' + i + ']', this.insertAttachments[i]);
            }

            for (let i = 0; i < this.deleteAttachments.length; i++) {
              formData.append('deleteAttachments[' + i + ']', JSON.stringify(this.deleteAttachments[i]));
            }

            // Larabel は multipart/form-data を put で処理できないため post
            axios.post('/api/announce/' + this.announce.id + '/update',
              formData,
              { headers: { "Content-type": "multipart/form-data", }}
            ).then(response => {
              this.openSuccess('更新しました');
              // お知らせ一覧画面に遷移
              this.$router.push({ name: 'announce.list' })

              // バリデーションのメッセージを初期化する
              this.$store.dispatch("announce/setAnnounceErrorMessages", "");
            })
            .catch(error => {
              console.log(error);
            });
            // お知らせ承認する
            axios.post("/api/announce/" + announce + "/approval")
            .then((res) => {
              this.openSuccess('承認しました');
              // スナックバーの表示時間が経ってから実行
              setTimeout(() => {
                window.location.reload();
              }, 1000);
            }); 
          })
          .catch(error => {
            if (error.response.status !== 422) {
              console.error(error);
            } else {
              this.scrollTop()
              this.$store.dispatch("announce/setAnnounceErrorMessages", error.response.data.errors);
            }
          });
        } 
        console.log("invalid!");
        return;
      });
    },
    // 差戻し処理
    approvalReturn(announceId) {
      axios.put("/api/announce/" + announceId + "/return", {
          announce: this.announce,
          approvalReturnComment:
          this.$store.state.announce.approvalReturnComment,
      })
      .then((res) => {
        this.openSuccess('差戻しました');
        // スナックバーの表示時間が経ってから実行
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      });
    },
    // 取り下げ処理
    approvalCancel(announceId) {
      axios.put("/api/announce/" + announceId + "/cansel").then((res) => {
        this.openSuccess('取り下げました');
        // スナックバーの表示時間が経ってから実行
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      });
    },

    // 承認ステータスに応じて文字を返す
    getApprovalStatus(status) {
      if (status === 0) {
        // 0:下書きの場合
        return "下書き"
      } else if (status === 1) {
        // 1:承認待ちの場合
        return "承認待ち"
      } else if (status === 2) {
        // 2:承認済みの場合
        return "承認済み"
      } else if (status === 3) {
        // 3:差戻しの場合
        return "差戻し"
      }
    },

    // 承認ステータスに応じて文字色を返す
    getApprovalStatusColor(status) {
      if (status === 0) {
        // 0:下書きの場合
        return "stastus-font__grey"
      } else if (status === 1) {
        // 1:承認待ちの場合
        return "stastus-font__orange"
      } else if (status === 2) {
        // 2:承認済みの場合
        return "stastus-font__green"
      } else if (status === 3) {
        // 3:差戻しの場合
        return "stastus-font__red"
      }
    },
    scrollTop(){
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    }
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
  async mounted() {
    // バリデーションのメッセージを初期化する
    this.$store.dispatch("announce/setAnnounceErrorMessages", "");

    this.announce = await this.getAnnounce(this.announceId);
    this.loadAttachments = this.announce.attachments;
    this.loadAttachments.forEach(attachment => {
      this.attachments.push({ name: attachment.img_filename });
    });
    this.$refs.myQuillEditor.pasteHTML(this.announce.contents);
    // ユーザの権限セットを取得
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.approval_auth_flg = authority.approval_auth_flg;
      this.request_auth_flg = authority.request_auth_flg;
      console.log("this.request_auth_flg")
      console.log(this.request_auth_flg)
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

<style src="../css/common.css"></style>
<style src="../css/dropdown.css"></style>
<style lang="scss">
  .accept-stat{
    border-top:1px solid rgba(0,0,0,0.5);
  }

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

  
  @media (max-width: 599.99px){
    .editBtn-widht {
      width: 60% !important;
    }
  }
  
  /* 承認ステータス用のフォントカラー */
  /* 承認待ち */
  .stastus-font__orange {
  color: orange;
  font-weight: 600;
  }
  /* 差戻し */
  .stastus-font__red {
    color: #D32F2F;
    font-weight: 600;
  }
  /* 承認済み */
  .stastus-font__green {
    color: #94CAB1;
    font-weight: 600;
  }
  /* 下書き */
  .stastus-font__grey {
    color: grey;
    font-weight: 600;
  }
</style>
