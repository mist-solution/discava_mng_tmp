<template>
    <v-card class="main-cont sp-title mb-0 mb-sm-5">
      <v-row>
        <!-- タイトル -->
        <v-col cols="4">
          <v-card-title class="pl-0 pl-sm-4">
            <h3 class="p-3 pl-0 pl-sm-4 m-0 font-weight-bold title-name">{{ name }}</h3>
          </v-card-title>
        </v-col>
        <!-- お知らせ一覧 タブ -->
        <v-col cols="8" v-if="tabFlg" class="tab-posision">
          <v-tabs v-model="tab" fixed-tabs class="text-left mr-2" color="#69A5AF">
            <v-tab
              value="one"
              @click="announceStatus();
                setSelectTab(1);"
            >
              全ての投稿
            </v-tab>
            <v-tab
              value="two"
              @click="announceStatus(1);
                setSelectTab(2);"
            >
              承認待ち
            </v-tab>
            <v-tab
              value="three"
              @click="announceStatus(3);
                setSelectTab(3);"
            >
              差戻し
            </v-tab>
            <v-tab
              value="four"
              @click="announceStatus(4);
                setSelectTab(4);"
            >
              承認済み
            </v-tab>
          </v-tabs>
        </v-col>
      </v-row>

  </v-card>
</template>

<script>
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
        // 全ての投稿
        tabName = "allLists";
      } else if (key == 2) {
        // 承認待ち
        tabName = "notCheckLists";
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
  font-size: clamp(1.375rem, 1.33rem + 0.23vw, 1.5rem);
}
@media (max-width: 599.9px){
  .sp-title{
    box-shadow: unset;
    background: unset;
  }
}
.tab-posision {
  align-content: center;
  align-items: center;
  display: grid;
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
}
</style>