<template>
  <back-to-top-component />

  <EasyDataTable
    v-model:items-selected="selected"
    :headers="headers"
    :items="users"
    :theme-color="themeColor"
    alternating
    buttons-pagination
    dense
    :search-field="searchField"
    :search-value="searchValue"
    :rows-per-page=10
  >
<!--
    <template #item-title="item">
      <router-link :to="{ name: 'announce.edit', params: { announceId: item.id } }">
        {{ item.title }}
      </router-link>
    </template>
-->
    <template #item-created_at="item">
      {{ timestampFormat(item.created_at) }}
    </template>
    <template #item-updated_at="item">
      {{ timestampFormat(item.updated_at) }}
    </template>
    <template #item-button="item">
      <v-icon class="green-icon mr-3" @click="edit(item)">
        mdi-square-edit-outline
      </v-icon>
      <v-icon class="green-icon"
        @click.stop="(displayAccountDeleteConfirm = true), setDeleteAccountId(item.id)"
      >
        mdi-trash-can
      </v-icon>
    </template>
  </EasyDataTable>
<!--
        <template #loading>
          <v-progress-linear
            indeterminate
            class="mx-auto"
            color="primary"
          />
        </template>
-->

  <!-- 削除モーダル -->
  <end-user-delete-confirm-modal-component
    :modelValue="displayAccountDeleteConfirm"
    @update:modelValue="displayAccountDeleteConfirm = $event"
    :closeAction="closeAction"
    :deleteUser="deleteUser"
    />
</template>

<script>
//import NewsListTablePagination from "../news_list/NewsListTablePagination.vue";
import BackToTopComponent from "../../BackToTopComponent.vue";
import { inject, mergeProps } from "vue";
import EndUserDeleteConfirmModalComponent from "../end_user/EndUserDeleteConfirmModalComponent.vue";

export default {
  components: {
    BackToTopComponent,
    EndUserDeleteConfirmModalComponent,
  },
  props: [
    "searchValue",
  ],
  data() {
    return {
      selected: [],

      headers: [
        { text: 'ユーザ名', value: 'name' },
        { text: '登録日時', value: 'created_at' },
        { text: '更新日時', value: 'updated_at' },
        {
          text: '編集/削除',
          sortable: false,
          value: 'button',
        },
      ],
      users: [],
      displayAccountDeleteConfirm: false,
      menuDeleteAnnounce: [],
      select: [],
      themeColor: "#69A5AF",
      searchField: "name",
    };
  },
  computed: {
  },
  watch: {
  },
  methods: {
    mergeProps,
    closeAction() {
      this.displayAccountDeleteConfirm = false;
//      window.location.reload();
    },

    getAccountList() {
//      this.loading = true;
      axios
        .get("/api/enduser", {
        })
        .then((res) => {
          this.users = res.data.users;
//          this.$store.dispatch("news/setTotalCount", res.data.count);
//          this.loading = false;
        });
    },

    // 選択した記事をstoreに設定
    setSelectItems() {
      this.$store.dispatch("news/setDisplayCheckedItems", this.select);
    },

    // 削除確認ダイアログに渡せるため、IDをstoreに設定
    setDeleteAccountId(id) {
      let accountId = id;
      this.$store.dispatch("enduser/setDeleteUserId", accountId);
    },

    // 削除処理
    deleteUser(accountId) {
console.log(`ID:${accountId} を削除しました。`);
      axios.delete("/api/enduser/" + accountId).then((res) => {});
      window.location.reload();
    },

    timestampFormat(timestamp) {
      const dayjs = inject("dayjs");
      return dayjs(timestamp).format("YYYY/MM/DD HH:mm:ss");
//      const date = new Date(timestamp);
//      return (
//        date.getFullYear().toString() +
//        "-" +
//        (date.getMonth() + 1).toString().padStart(2, "0") +
//        "-" +
//        date.getDate().toString().padStart(2, "0")
//      );
    },

    edit(user) {
      this.$router.push({
        name: 'enduser.update',
        params: { userId: user.id }
      });
    },

  },
  mounted() {
    this.getAccountList();
    this.setSelectItems();
  },
};
</script>

<!-- 共通CSS -->
<style src="../css/common.css"></style>
<style src="../css/list.css"></style>

<!-- 固有CSS -->
<style scoped>
.green-icon {
  color: #69A5AF;
}
.accounttable td {
        background: #F7F7F7;
}
.accounttable tr:nth-child(odd) td {
        background: #fff;
}

.customize-table {
  /* 表の罫線 */
  --easy-table-row-border: none;

  /* 表の背景色 */
  --easy-table-header-background-color: #F7F7F7;

  /* フッターのpadding追加 */
  --easy-table-footer-padding: 1.5rem;

  /* フッターフォントサイズ */
  --easy-table-footer-font-size: 14px;
}

</style>