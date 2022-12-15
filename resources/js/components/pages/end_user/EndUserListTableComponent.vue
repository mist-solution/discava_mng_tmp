<template>
  <back-to-top-component />

      <EasyDataTable
        v-model:items-selected="selected"
        :headers="headers"
        :items="users"
        dense
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
          <v-icon class="green-icon mr-3" @click="edit(item)">mdi-square-edit-outline</v-icon>
          <v-icon class="green-icon" @click="edit(item)">mdi-trash-can</v-icon>
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
<!--
  <news-delete-confirm-modal-component
    :display="displayNewsDeleteConfirm"
    :closeAction="closeAction"
    :deleteAnnounce="deleteAnnounce"
  />
-->
</template>

<script>
import NewsListTablePagination from "../news_list/NewsListTablePagination.vue";
import BackToTopComponent from "../../BackToTopComponent.vue";
import { inject, mergeProps } from "vue";
import NewsDeleteConfirmModalComponent from "../news_list/NewsDeleteConfirmModalComponent.vue";

export default {
  components: {
    NewsListTablePagination,
    BackToTopComponent,
    NewsDeleteConfirmModalComponent,
  },
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
      displayNewsDeleteConfirm: false,
      menuDeleteAnnounce: [],
      select: [],
    };
  },
  computed: {
  },
  watch: {
  },
  methods: {
    mergeProps,
    closeAction() {
      this.displayNewsDeleteConfirm = false;
      window.location.reload();
    },

    getNewsList() {
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
    setDeleteAnnounceId(id) {
      let announceId = id;
      this.$store.dispatch("news/setDeleteNewsId", announceId);
    },

    // 削除処理
    deleteAnnounce(announceId) {
      console.log(`ID:${announceId} が削除しました。`);
      axios.delete("/api/announce/" + announceId).then((res) => {});
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
    this.getNewsList();
    this.setSelectItems();
  },
};
</script>

<!-- 共通CSS -->
<style src="../css/common.css"></style>

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

/* vue3-data-tableで罫線固定しているためimportantで指定 */
.accounttable tr.th,td {
  border: none !important;
}

.accordionsp {
}

.accordionsp > div {
}


@media (min-width: 600px){
  .displaysp {
    display: none;
  }
}

@media (max-width: 600px){
  .accounttable th {
    background: #FFF;
    border-bottom: 1px solid #F7F7F7 !important;
  }

  .accounttable td {
        background: #FFF;
  }

  .displaypc {
    display: none;
  }

  .displaysp {
    display: block;
  }
}

</style>