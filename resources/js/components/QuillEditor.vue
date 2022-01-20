
<template>
  <p>お知らせ管理</p>
  <div>
    <p>ツールバー：FULLタイプ</p>
    <QuillEditor
      toolbar="full"
      class="ql-editor"
      v-model="content"
      ref="myQuillEditor"
      :options="editorOption"
      @blur="onEditorBlur($event)"
      @focus="onEditorFocus($event)"
      @change="onEditorChange($event)"
    >
    </QuillEditor>
    <div>
      <button class="btn btn-primary" @click="getQuillEditorContent()">
        クリックしてアウトプットする
      </button>
    </div>
  </div>

  <!-- <div class="ql-editor">
    <p>ツールバー：カスタマータイプ</p>
    <QuillEditor
      toolbar="#my-toolbar"
      class="ql-editor"
      v-model="content"
      :options="options"
      ref="myQuillEditor"
      @blur="onEditorBlur($event)"
      @focus="onEditorFocus($event)"
      @change="onEditorChange($event)"
    >
      <template #toolbar>
        <div id="my-toolbar">
          <button class="ql-bold"></button>
          <button class="ql-italic"></button>
          <button class="ql-underline"></button>
          <button class="ql-strike"></button>
          <button class="ql-link"></button>
          <button class="ql-video"></button>
          <button class="ql-image"></button>
          <select class="ql-size">
            <option value="small"></option>
            <option selected></option>
            <option value="large"></option>
            <option value="huge"></option>
          </select>
          <select class="ql-header">
            <option value="1"></option>
            <option value="2"></option>
            <option value="3"></option>
            <option value="4"></option>
            <option value="5"></option>
            <option selected></option>
          </select>
          <select class="ql-color">
            <option value="red"></option>
            <option value="purple"></option>
            <option value="green"></option>
          </select>
          <select class="ql-background">
            <option value="black"></option>
            <option value="white"></option>
            <option value="purple"></option>
            <option value="green"></option>
          </select>
          <select class="ql-font">
            <option value="Sans Serif">Sans Serif</option>
            <option value="Serif">Serif</option>
            <option value="Monospace">Monospace</option>
          </select>
        </div>
      </template>
    </QuillEditor>
  </div> -->

  <div class="ql-container">
    <p>---お知らせ詳細---</p>
    <div
      class="ql-editor"
      v-html="content"
      @change="getQuillEditorContent()"
    ></div>
  </div>
</template>

<script>
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

export default {
  components: {
    QuillEditor,
  },
  data() {
    return {
      content: "表示エリア",
      editorOption: {},
    };
  },
  methods: {
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
    getQuillEditorContent(content) {
      const getQuillEditorContent = this.$refs.myQuillEditor.getHTML();
      console.log(getQuillEditorContent);
      if (content) {
        null;
      } else {
        this.content = getQuillEditorContent;
      }
    },
  },
  computed: {
    editor() {
      return this.$refs.myQuillEditor.quill;
    },
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