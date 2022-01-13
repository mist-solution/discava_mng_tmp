
<template>
  <p>お知らせ管理</p>
  <div>
    <p>ツールバー：FULLタイプ</p>
    <QuillEditor toolbar="full" />
  </div>

  <div class="ql-editor">
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
          <!-- Add buttons as you would before -->
          <button class="ql-bold"></button>
          <button class="ql-italic"></button>
          <button class="ql-underline"></button>
          <button class="ql-strike"></button>
          <button class="ql-blockquote"></button>
          <button class="ql-code-block"></button>
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
    <div>
      <button @click="getQuillEditorContent" color="primary">
        click here to output
      </button>
    </div>
  </div>

  <div>
    <div style="height: 500px; width: 700px">
      <div class="quill-editor">
        <div class="ql-container">
          <p>---OUTPUT AREA---</p>
          <div class="ql-editor" v-html="content"></div>
        </div>
      </div>
    </div>
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
      content: "",
      options: {
        placeholder: "入力エリア",
      },
    };
  },
  methods: {
    onEditorReady(editor) {},
    onEditorBlur() {},
    onEditorFocus() {},
    onEditorChange() {},
    getQuillEditorContent() {
      // console.log(this.content);
      console.log(this.$refs.myQuillEditor.getContents());
    },
  },
  computed: {
    editor() {
      return this.$refs.myQuillEditor;
    },
  },
};
</script>

<style lang="scss">
.edit_container {
  width: 800px;
}

.ql-container {
  height: 400px;
}
</style>