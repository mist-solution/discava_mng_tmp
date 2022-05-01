<template>
  <div>
    <v-btn @click.stop="display=true"><v-icon class="mr-2">mdi-plus-minus-variant</v-icon>表示件数</v-btn>
    <news-display-limit-modal-component :display="display" :closeAction="closeAction" />

    合計件数： {{ $store.state.news.totalCount }}
  </div>
</template>

<script>
import NewsDisplayLimitModalComponent from "./NewsDisplayLimitModalComponent.vue";
export default {
  components: {
    NewsDisplayLimitModalComponent,
  },
  data() {
    return {
      display: false,
    };
  },
  methods: {
    closeAction() {
      this.display = false;
    }
  },
  mounted() {},
};
</script>