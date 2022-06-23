<template>
  <v-dialog v-model="display" persistent>
    <v-card>
      <v-card-title> 検索 </v-card-title>
      <v-card-text>
        検索条件を入力し、「検索」ボタンを押下してください。
      </v-card-text>
      <v-container>
        <v-row>
          <v-col cols="12" md="4">
            <Datepicker
              v-model="searchAddDateBegin"
              label="登録日時：開始"
              locale="ja"
              selectText="確認"
              cancelText="キャンセル"
            />
          </v-col>

          <v-col cols="12" md="4">
            <Datepicker
              v-model="searchAddDateEnd"
              label="登録日時：終了"
              locale="ja"
              selectText="確認"
              cancelText="キャンセル"
            />
          </v-col>

          <v-col cols="12" md="4">
            <Datepicker :v-model="date" label="更新日時" locale="ja" range />
          </v-col>

          <v-col cols="12" md="6">
            <v-select
              v-model="searchAddUser"
              :items="AddUsers"
              :rules="[(v) => !!v || 'Item is required']"
              label="登録者名"
              @update:modelValue="setSearchCol"
              :open-on-clear="clearable"
            ></v-select>
          </v-col>

          <v-col cols="12" md="6">
            <v-select
              v-model="searchUpdUser"
              :items="UpdUsers"
              :rules="[(v) => !!v || 'Item is required']"
              label="更新者名"
              @update:modelValue="setSearchCol"
              open-on-clear
            ></v-select>
          </v-col>

          <v-col cols="12" md="6">
            <v-select
              v-model="searchCategory"
              :items="items"
              :rules="[(v) => !!v || 'Item is required']"
              label="カテゴリー"
            ></v-select>
          </v-col>
        </v-row>
      </v-container>
      <v-card-actions>
        <v-btn @click="closeAction()">閉じる</v-btn>
        <v-btn color="primary" @click="submitAction()">検索</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { ref, onMounted } from "vue";

export default {
  props: ["display", "closeAction"],
  components: { Datepicker },
  data() {
    return {
      searchAddDateBegin: null,
      searchAddDateEnd: null,
      searchAddUser: "",
      searchUpdUser: "",
      searchCategory: "",
      AddUsers: [],
      UpdUsers: [],
      clearable: false,
    };
  },
  setup() {
    const date = ref();
    // For demo purposes assign range from the current date
    onMounted(() => {
      const startDate = new Date();
      const endDate = new Date();
      date.value = [startDate, endDate];
      console.log(startDate);
      console.log(endDate);
    });

    return {
      date,
    };
  },
  methods: {
    getUsers: function () {
      this.$axios.get("api/enduser").then((res) => {
        this.AddUsers = res.data.users.map((AddUsers) => {
          return AddUsers.name;
        });
        this.UpdUsers = res.data.users.map((UpdUsers) => {
          return UpdUsers.name;
        });
      });
    },

    setSearchCol(colName) {
      let searchCol = [];
      if (colName) {
        if (this.AddUsers) {
          searchCol.push("add_account");
        } else if (this.UpdUsers) {
          searchCol.push("upd_account");
        }
        console.log(searchCol);
      }
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
      if (this.searchAddDateBegin && this.searchAddDateEnd) {
        if (this.searchAddDateEnd > this.searchAddDateBegin) {
          console.log("OKOKOK::: END > BEGIN");
          let searchAddDateBegin = this.timestampConvert(
            this.searchAddDateBegin
          );
          let searchAddDateEnd = this.timestampConvert(this.searchAddDateEnd);
          console.log(searchAddDateBegin);
          console.log(searchAddDateEnd);
          this.$store.dispatch(
            "news/setDisplaySearchAddDateBegin",
            searchAddDateBegin
          );
          this.$store.dispatch(
            "news/setDisplaySearchAddDateEnd",
            searchAddDateEnd
          );
        } else {
          console.log("NGNGNG::: END < BEGIN");
        }

        // 登録者検索処理
      } else if (this.searchAddUser) {
        let setAddUserId = null;
        setAddUserId = this.AddUsers.indexOf(this.searchAddUser) + 1;
        console.log("107::::" + this.$store.state.news.displaySearchNewsCol);
        console.log("107::::" + this.$store.state.news.displaySearchNews);
        this.$store.dispatch("news/setDisplaySearchNewsCol", "add_account");
        this.$store.dispatch("news/setDisplaySearchNews", setAddUserId);
        console.log("109::::" + this.$store.state.news.displaySearchNewsCol);
        console.log("109::::" + this.$store.state.news.displaySearchNews);

        // 更新者検索処理
      } else if (this.searchUpdUser) {
        let setUpdUserId = null;
        setUpdUserId = this.UpdUsers.indexOf(this.searchUpdUser) + 1;
        this.$store.dispatch("news/setDisplaySearchNewsCol", "upd_account");
        this.$store.dispatch("news/setDisplaySearchNews", setUpdUserId);
      }

      // カテゴリ検索処理
      else {
      }

      this.closeAction("displaySearch");
    },
  },
  watch: {
    displayUsers() {
      this.getUsers();
    },
  },
  mounted() {
    this.getUsers();
  },
};
</script>