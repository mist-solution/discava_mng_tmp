
<template>
  <p>お知らせ管理</p>

  <p>ツールバー：FULLタイプ</p>
  <QuillEditor toolbar="full" />
  <p>ツールバー：カスタマータイプ</p>

  <QuillEditor toolbar="#my-toolbar">
    <template #toolbar>
      <div id="my-toolbar">
        <!-- Add buttons as you would before -->
        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-underline"></button>
        <button class="ql-strike"></button>
      </div>
    </template>
  </QuillEditor>
</template>

<script>
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
export default {
  components: {
    QuillEditor,
  },
};
</script>