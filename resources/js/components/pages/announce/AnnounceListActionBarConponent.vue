<template>
  <v-container class="grey lighten-5">
    <v-row no-gutters>
      <v-row justify="right">
        <v-col cols="12">
          <v-btn
            @click.stop="displaySearch = true"
            class="ma-2"
            color="#d9d9d9"
            icon="mdi-magnify"
            variant="contained"
          >
          </v-btn>
          <label>検索</label>

          <v-btn
            @click.stop="displaySort = true"
            class="ma-2"
            color="#d9d9d9"
            icon="mdi-unfold-more-horizontal"
            variant="contained"
          >
          </v-btn>
          <label>並び順</label>

          <v-btn
            @click.stop="displayLimit = true"
            class="ma-2"
            color="#d9d9d9"
            icon="mdi-plus-minus-variant"
            variant="contained"
          >
          </v-btn>
          <label>表示件数</label>

          <v-btn
            @click.stop="displayCheckAll = true"
            class="ma-2"
            color="#d9d9d9"
            icon="mdi-check"
            variant="contained"
          >
          </v-btn>
          <label>一括承認</label>
        </v-col>

          <!-- 検索モーダル -->
          <announce-display-search-modal-component
            :display="displaySearch"
            :closeAction="closeAction"
          />

          <!-- 並び順モーダル -->
          <announce-display-sort-modal-component
            :display="displaySort"
            :closeAction="closeAction"
          />
          <!-- 表示件数モーダル -->
          <announce-display-limit-modal-component
            :display="displayLimit"
            :closeAction="closeAction"
          />

          <!-- 一括承認モーダル -->
          <announce-display-check-all-modal-component
            :display="displayCheckAll"
            :closeAction="closeAction"
          />
      </v-row>
    </v-row>

  </v-container>
</template>

<script>
import AnnounceDisplaySearchModalComponent from "../../modals/AnnounceDisplaySearchModalComponent.vue";
import AnnounceDisplayLimitModalComponent from "../../modals/AnnounceDisplayLimitModalComponent.vue";
import AnnounceDisplaySortModalComponent from "../../modals/AnnounceDisplaySortModalComponent.vue";
import AnnounceDisplayCheckAllModalComponent from "../../modals/AnnounceDisplayCheckAllModalComponent.vue";

export default {
  inject: ["reload"],
  components: {
    AnnounceDisplaySearchModalComponent,
    AnnounceDisplayLimitModalComponent,
    AnnounceDisplaySortModalComponent,
    AnnounceDisplayCheckAllModalComponent,
  },
  data() {
    return {
      displaySearch: false,
      displaySort: false,
      displayLimit: false,
      displayCheckAll: false,
    };
  },
  methods: {
    closeAction(key) {
      if (key == "displaySearch") {
        this.displaySearch = false;
      } else {
        this.displaySort = false;
        this.displayLimit = false;
        this.displayCheckAll = false;
        window.location.reload();
      }
    },
  },
  mounted() {},
};
</script>