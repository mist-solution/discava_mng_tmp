<template>
  <v-container class="max-cont">
    <title-component
      name = "投稿記事一覧"
    />
    <div class="btn-group ml-1 mb-5" v-if="create_auth_flg">
      <router-link v-bind:to="{ name: 'announce.register' }" class="mt-2">
        <button class="btn green-btn_toukou mr-2 px-4 justify-center">
          <v-icon color="white" x-small class="pb-1">mdi-pencil</v-icon>
          投稿
        </button>
      </router-link>
    </div>
    <v-card>
      <v-tabs v-model="tab" fixed-tabs class="mx-auto text-gray" dark>
        <v-tab
          value="one"
          @click="
            announceStatus(1);
            setSelectTab(1);
          "
          >承認待ち</v-tab
        >
        <v-tab
          value="two"
          @click="
            announceStatus(0);
            setSelectTab(2);
          "
          >下書き</v-tab
        >
        <v-tab
          value="three"
          @click="
            announceStatus(3);
            setSelectTab(3);
          "
          >差戻し</v-tab
        >
        <v-tab
          value="four"
          @click="
            announceStatus(2);
            setSelectTab(4);
          "
          >承認済み</v-tab
        >
      </v-tabs>

      <!-- <v-card-actions>
        <announce-list-action-bar-conponent class="ml-3" />
      </v-card-actions> -->

      <v-card-text>
        <v-window v-model="tab">
          <v-window-item value="one">
            <announce-list-table />
          </v-window-item>

          <v-window-item value="two">
            <announce-list-table />
          </v-window-item>

          <v-window-item value="three">
            <announce-list-table />
          </v-window-item>

          <v-window-item value="four">
            <announce-list-table />
          </v-window-item>
        </v-window>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions } from "vuex";

import AnnounceListTable from "./AnnounceListTableComponent.vue";
// import AnnounceListActionBarConponent from "./AnnounceListActionBarConponent.vue";
import TitleComponent from "../../common/TitleComponent.vue"
export default {
  components: {
    AnnounceListTable,
    // AnnounceListActionBarConponent,
    TitleComponent
  },
  data() {
    return {
      tab: null,
      create_auth_flg: null,
    };
  },
  methods: {
    ...mapActions('authority', ['fetchAllAuthority']),
    // お知らせの承認ステータス
    announceStatus(announceStatus) {
      this.$store.dispatch("announce/setDisplayAnnounceStatus", announceStatus);
    },

    // 選択したタブをstoreに設定
    setSelectTab(key) {
      let tabName = "";
      if (key == 1) {
        // 承認待ち
        tabName = "notCheckLists";
      } else if (key == 2) {
        // 下書き
        tabName = "draftLists";
      } else if (key == 3) {
        // 差戻し
        tabName = "sendBackLists";
      } else if (key == 4) {
        // 承認済み
        tabName = "checkedLists";
      }
      this.$store.dispatch("announce/setDisplayListsItemKey", tabName);
    },
  },
  async mounted() {
    let authority = await this.fetchAllAuthority();
    if(authority){
      this.create_auth_flg = authority.create_auth_flg;
    }
  },
};
</script>

<style scoped>
  /* 投稿ボタン */
  .green-btn_toukou {
    border-radius: 5px;
    background-color: #69A5AF;
    box-shadow: unset;
    font-size: large;
    font-weight: 400;
    box-shadow: 0 4px 8px rgba(105, 165, 175, 0.56);
    transition: 0.3s;
  }
  .green-btn_toukou:hover {
  color: white !important;
  background-color: #69A5AF !important;
  transform: translate(0, 3px);
  transition: 0.3s;
  box-shadow: 0 2px 4px rgba(105, 165, 175, 0.56) !important;
}
  .green-btn_toukou:active {
    border-color: #69A5AF !important;
  }
  .green-btn_toukou .v-btn__content{
    color:#fff !important;
  }
  .green-btn_toukou {
    color:#fff !important;
  }
  .green-btn_toukou:hover{
    opacity:.8 !important;
    box-shadow: unset !important;
    background-color: #69A5AF !important;
    color:#fff !important;
  }

  .green-btn_toukou > i {
    font-size: 18px !important;
  }

</style>