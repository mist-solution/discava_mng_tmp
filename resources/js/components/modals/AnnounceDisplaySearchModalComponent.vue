<template>
    <v-dialog v-show="display" persistent>
      <v-card>
        <!-- モーダルタイトル -->
        <v-card-title class="text-center modal-title"> 検索 </v-card-title>
        <!--  モーダル説明文 -->
        <v-card-text class="text-center mb-3">
          検索条件を入力し、「検索」ボタンを押下してください。
        </v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12" md="6">
              <Datepicker
                v-model="searchAddDateBegin"
                label="登録日時：開始"
                locale="ja"
                selectText="確認"
                cancelText="キャンセル"
                :openMenuOnFocus="false"
              />
            </v-col>
  
            <v-col cols="12" md="6">
              <Datepicker
                v-model="searchAddDateEnd"
                label="登録日時：終了"
                locale="ja"
                selectText="確認"
                cancelText="キャンセル"
                :openMenuOnFocus="false"
              />
            </v-col>
  
            <v-col cols="12" md="6">
              <Datepicker
                v-model="searchUpdDateBegin"
                label="更新日時：開始"
                locale="ja"
                selectText="確認"
                cancelText="キャンセル"
                :openMenuOnFocus="false"
              />
            </v-col>
  
            <v-col cols="12" md="6">
              <Datepicker
                v-model="searchUpdDateEnd"
                label="更新日時：終了"
                locale="ja"
                selectText="確認"
                cancelText="キャンセル"
                :openMenuOnFocus="false"
              />
            </v-col>
  
            <v-col cols="12" md="6">
              <v-select
                v-model="searchAddUser"
                :items="AddUsers"
                :rules="[(v) => !!v || 'Item is required']"
                label="登録者名"
              ></v-select>
            </v-col>
  
            <v-col cols="12" md="6">
              <v-select
                v-model="searchUpdUser"
                :items="UpdUsers"
                :rules="[(v) => !!v || 'Item is required']"
                label="更新者名"
              ></v-select>
            </v-col>
  
            <v-col cols="12" md="6">
              <v-select
                v-model="searchCategory"
                :items="AnnounceCategory"
                :rules="[(v) => !!v || 'Item is required']"
                label="カテゴリー"
              ></v-select>
            </v-col>
          </v-row>
        </v-container>
        <!-- 操作 -->
        <v-card-actions class="justify-center">
          <!-- 閉じるボタン -->
          <v-btn @click="closeAction()" class="gray-btn mx-2">閉じる</v-btn>
          <!-- 検索ボタン -->
          <v-btn @click="submitAction()" class="red-btn mx-2">検索</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  import Datepicker from "@vuepic/vue-datepicker";
  import "@vuepic/vue-datepicker/dist/main.css";
  
  export default {
    props: ["display", "closeAction"],
    components: { Datepicker },
    data() {
      return {
        searchAddDateBegin: null,
        searchAddDateEnd: null,
        searchUpdDateBegin: null,
        searchUpdDateEnd: null,
        searchAddUser: "",
        searchUpdUser: "",
        searchCategory: "",
        AddUsers: [],
        UpdUsers: [],
        AnnounceCategory: [],
        clearable: false,
      };
    },
  
    methods: {
      getUsers: function () {
        this.$axios.get("/api/enduser").then((res) => {
          this.AddUsers = res.data.users.map((AddUsers) => {
            return AddUsers.name;
          });
          this.UpdUsers = res.data.users.map((UpdUsers) => {
            return UpdUsers.name;
          });
        });
      },
  
      getAnnounceCategory: function () {
        this.$axios.get("/api/announceCategory").then((res) => {
          this.AnnounceCategory = res.data.announceCategories.map(
            (AnnounceCategory) => {
              return AnnounceCategory.category;
            }
          );
        });
      },
  
      timestampConvert(timestamp) {
        const date = new Date(timestamp);
        return (
          date.getFullYear().toString() +
          "/" +
          (date.getMonth() + 1).toString().padStart(2, "0") +
          "/" +
          date.getDate().toString().padStart(2, "0") +
          " " +
          date.getHours().toString().padStart(1) +
          ":" +
          date.getMinutes().toString().padStart(2, "0") +
          ":" +
          date.getSeconds().toString().padStart(2, "0")
        );
      },
  
      submitAction() {
        // 登録日時検索処理
        let searchAddDateBegin = this.timestampConvert(this.searchAddDateBegin);
        let searchAddDateEnd = this.timestampConvert(this.searchAddDateEnd);
        let searchUpdDateBegin = this.timestampConvert(this.searchUpdDateBegin);
        let searchUpdDateEnd = this.timestampConvert(this.searchUpdDateEnd);
        if (this.searchAddDateBegin && this.searchAddDateEnd) {
          if (this.searchAddDateEnd > this.searchAddDateBegin) {
            this.$store.dispatch(
              "announce/setDisplaySearchAddDateBegin",
              searchAddDateBegin
            );
            this.$store.dispatch(
              "announce/setDisplaySearchAddDateEnd",
              searchAddDateEnd
            );
          } else {
            console.log("NGNGNG::: END < BEGIN");
          }
        } else if (this.searchAddDateBegin) {
          this.$store.dispatch(
            "announce/setDisplaySearchAddDateBegin",
            searchAddDateBegin
          );
          // 更新日時検索処理
        } else if (this.searchUpdDateBegin && this.searchUpdDateEnd) {
          if (this.searchUpdDateEnd > this.searchUpdDateBegin) {
            this.$store.dispatch(
              "announce/setDisplaySearchUpdDateBegin",
              searchUpdDateBegin
            );
            this.$store.dispatch(
              "announce/setDisplaySearchUpdDateEnd",
              searchUpdDateEnd
            );
          } else {
            console.log("NGNGNG::: END < BEGIN");
          }
        } else if (this.searchUpdDateBegin) {
          this.$store.dispatch(
            "announce/setDisplaySearchUpdDateBegin",
            searchUpdDateBegin
          );
  
          // 登録者検索処理
        } else if (this.searchAddUser) {
          let setAddUserId = null;
          setAddUserId = this.AddUsers.indexOf(this.searchAddUser) + 1;
          this.$store.dispatch("announce/setDisplaySearchAnnounceCol", "add_account");
          this.$store.dispatch("announce/setDisplaySearchAnnounce", setAddUserId);
  
          // 更新者検索処理
        } else if (this.searchUpdUser) {
          let setUpdUserId = null;
          setUpdUserId = this.UpdUsers.indexOf(this.searchUpdUser) + 1;
          this.$store.dispatch("announce/setDisplaySearchAnnounceCol", "upd_account");
          this.$store.dispatch("announce/setDisplaySearchAnnounce", setUpdUserId);
        }
  
        // カテゴリ検索処理
        else if (this.searchCategory) {
          let searchCategoryId = null;
          searchCategoryId =
            this.AnnounceCategory.indexOf(this.searchCategory) + 1;
          this.$store.dispatch("announce/setDisplaySearchCategory", searchCategoryId);
        }
  
        this.closeAction("displaySearch");
      },
    },
    watch: {
      displayUsers() {
        this.getUsers();
      },
      displayAnnounceCategory() {
        this.getAnnounceCategory();
      },
    },
    mounted() {
      this.getUsers();
      this.getAnnounceCategory();
    },
  };
  </script>