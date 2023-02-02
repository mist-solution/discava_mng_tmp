<template>
  <div>
    <v-row>
      <!-- タイトル -->
      <v-col>
        <v-card-title class="pl-0">
          <h3 class="p-3 pl-0 m-0 pl-0 font-weight-bold title-name">{{ name }}</h3>
        </v-card-title>
      </v-col>
    </v-row>
    <v-card class="main-cont mb-0 mb-sm-5">
      <v-row>
        <!-- お知らせ一覧 タブ -->
        <v-col v-if="tabFlg" class="tab-posision mx-auto">
          <v-tabs v-model="tab" fixed-tabs class="" color="#69A5AF">
            <v-tab
              value="one"
              @click="announceStatus();
                setSelectTab(1);"
              class="px-2 tab-text"
            >
              全ての投稿
            </v-tab>
            <v-tab
              value="two"
              @click="announceStatus(1);
                setSelectTab(2);"
              class="px-2 tab-text"
            >
              承認待ち
            </v-tab>
            <v-tab
              value="three"
              @click="announceStatus(3);
                setSelectTab(3);"
              class="px-2 tab-text"
            >
              差戻し
            </v-tab>
            <v-tab
              value="four"
              @click="announceStatus(2);
                setSelectTab(4);"
              class="px-2 tab-text"
            >
              承認済み
            </v-tab>
          </v-tabs>
        </v-col>
      </v-row>
    </v-card>
  </div>
</template>

<script>
import { tr } from 'date-fns/locale';

export default {
  props:{
    name: String,
    tabFlg: Boolean
  },
  data() {
    return {
      tab: null,
    };
  },
  methods: {
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
        // 全ての投稿
        tabName = "allLists";
      } else if (key == 3) {
        // 差戻し
        tabName = "sendBackLists";
      } else if (key == 4) {
        // 承認済み
        tabName = "checkedLists";
      }
      this.$store.dispatch("announce/setDisplayListsItemKey", tabName);
    },
  }
}
</script>

<style scoped>
.title-name {
  color: #707070;
  font-size: clamp(1.438rem, 1.369rem + 0.34vw, 1.625rem);
  padding-top: 0 !important;
}

.tab-text {
  font-size: 14px !important;
  font-weight: 700 !important;
  color: #707070 !important;
}


/* セレクトタブの下線を消す */
.v-tab--selected .v-tab__slider {
  opacity: 0 !important;
  display: none !important;
}
.v-tab__slider {
  opacity: 0 !important;
  display: none !important;
}
.v-tab--selected {
  font-weight: 600 !important;
  color: rgb(105, 165, 175) !important;
}
</style>