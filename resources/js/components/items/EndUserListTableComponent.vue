<template>
  <div>
		<!-- ページトップボタン -->
		<back-to-top-component />
		<!-- データテーブル -->
		<EasyDataTable
      ref="dataTable"
			v-model:items-selected="selected"
			:headers="headers"
			:items="users"
			:theme-color="themeColor"
			alternating
      table-class-name="customize-table"
			buttons-pagination
			dense
			:search-field="searchField"
			:search-value="searchValue"
			:rows-per-page="rowsPerPage"
      v-if="reset"
      :hide-footer="true"
		>
			<!-- <template #item-title="item">
					<router-link :to="{ name: 'enduser.edit', params: { announceId: item.id } }">
					{{ item.title }}
					</router-link>
			</template> -->
      <!-- ユーザ名（クリックで更新画面） -->
			<template #item-name="item">
        <router-link :to="{ name: 'enduser.update', params: { userId: item.id } }" v-if="approval_auth_flg" class="enduser-name-font">
				{{ item.name }}
        </router-link>
        <div v-if="!approval_auth_flg">
          {{ item.name }}
        </div>
			</template>
      <!-- メールアドレス -->
			<template #item-mail="item">
				{{ item.email }}
			</template>
			<!-- 登録日 -->
			<template #item-created_at="item">
				{{ timestampFormat(item.created_at) }}
			</template>
			<!-- 更新日 -->
			<template #item-updated_at="item">
				{{ timestampFormat(item.updated_at) }}
			</template>
			<!-- 操作 -->
			<template #item-button="item" v-if="approval_auth_flg">
				<!-- 編集 -->
				<!-- <v-icon class="green-icon mr-3 mr-sm-5"
					@click="edit(item)"
				>
					mdi-square-edit-outline
				</v-icon> -->
				<!-- 削除 -->
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
	</div>
</template>
  
  <script>
  import { mapActions } from "vuex";
  //import AnnounceListTablePagination from "../announce/AnnounceListTablePagination.vue";
  import BackToTopComponent from "../BackToTopComponent.vue";
  import { inject, mergeProps } from "vue";
  import EndUserDeleteConfirmModalComponent from "../modals/EndUserDeleteConfirmModalComponent.vue";
  
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
          { text: 'メールアドレス', value: 'mail' },
          { text: '登録日時', value: 'created_at' },
          { text: '更新日時', value: 'updated_at' },
          {
            text: '削除',
            sortable: false,
            value: 'button',
          },
        ],
        users: [],
        displayAccountDeleteConfirm: false,
        menuDeleteAnnounce: [],
        select: [],
        themeColor: "#69A5AF",
        searchField:['email','name'],
        approval_auth_flg: null,
        rowsPerPage: 10,
        reset: true,
        page: 1,
        PageLastIndex: "",
      };
    },
    computed: {
      displayLimit() {
        return this.$store.state.enduser.displayLimit;
      },
      displayPage() {
        return this.$store.state.enduser.displayPage;
      },
    },
    watch: {
      displayLimit() {
        this.rowsPerPage = this.$store.state.enduser.displayLimit;
        let a = this.$refs.dataTable.clientItemsLength;
        this.PageLastIndex = Math.ceil(a/this.rowsPerPage)
        this.$emit("LastPageChange",this.PageLastIndex,a)
        this.reset = false;
        this.$nextTick(() => (this.reset = true));
      },
      displayPage() {
        this.page = this.$store.state.enduser.displayPage;
        this.$refs.dataTable.updatePage(this.page);
      },
      searchValue(){
        setTimeout(() => {
          this.rowsPerPage = this.$store.state.enduser.displayLimit;
          let a = this.$refs.dataTable.clientItemsLength;
          this.PageLastIndex = Math.ceil(a/this.rowsPerPage)
          this.$emit("LastPageChange",this.PageLastIndex,a)
          this.reset = false;
          this.$nextTick(() => (this.reset = true));
        }, 300);
      }
      
    },
    methods: {
      ...mapActions('authority', ['fetchAllAuthority']),
      mergeProps,
      closeAction() {
        this.displayAccountDeleteConfirm = false;
  			// window.location.reload();
      },
      getAccountList() {
  			// this.loading = true;
        axios
          .get("/api/enduser", {
          })
          .then((res) => {
            this.users = res.data.users;
  					// this.$store.dispatch("announce/setTotalCount", res.data.count);
  					// this.loading = false;
          });
        // バリデーションのメッセージを初期化する
        this.$store.dispatch("enduser/setEndUserErrorMessages", "");
      },
      // 選択した記事をstoreに設定
      setSelectItems() {
        this.$store.dispatch("announce/setDisplayCheckedItems", this.select);
      },
  
      // 削除確認ダイアログに渡せるため、IDをstoreに設定
      setDeleteAccountId(id) {
        let accountId = id;
        this.$store.dispatch("enduser/setDeleteUserId", accountId);
      },
  
      // 削除処理
      deleteUser(accountId) {
        axios.delete("/api/enduser/" + accountId).then((res) => {});
        window.location.reload();
      },
      timestampFormat(timestamp) {
        const dayjs = inject("dayjs");
        return dayjs(timestamp).format("YYYY/MM/DD HH:mm:ss");
				// const date = new Date(timestamp);
				// return (
				// date.getFullYear().toString() +
				// "-" +
				// (date.getMonth() + 1).toString().padStart(2, "0") +
				// "-" +
				// date.getDate().toString().padStart(2, "0")
				// );
      },
      edit(user) {
        this.$router.push({
          name: 'enduser.update',
          params: { userId: user.id }
        });
      },
    },
    async mounted() {
      this.getAccountList();
      this.setSelectItems();
      let authority = await this.fetchAllAuthority();
      if(authority){
        this.approval_auth_flg = authority.approval_auth_flg;
        if(!this.approval_auth_flg){
          this.headers[4].text = "";
        }
      }
      let a = this.$refs.dataTable.clientItemsLength;
      this.PageLastIndex = this.$refs.dataTable.maxPaginationNumber;
      this.$emit("LastPageChange",this.PageLastIndex,a)
      console.log("Lastpage:" + this.PageLastIndex)
    },
  };
  </script>
  
  <!-- 共通CSS -->
  <style src="../pages/css/common.css"></style>
  <style src="../pages/css/list.css"></style>
  
  <!-- 固有CSS -->
  <style scoped>
  .green-icon {
    color: #69A5AF;
    font-size: 24px;
  }
  @media (max-width: 599.99px){
    .green-icon {
      font-size: 20px;
    }
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

  @media (max-width: 900px){
    .sp_disable{
        display: none;
    }
  }

@media (min-width: 901px){
    .pc_disable{
        display: none;
    }
  }

/* ユーザ名のフォント設定 */
.enduser-name-font {
  font-weight: 600;
  font-size: 1rem;
  color: #69A5AF;
  transition: .4s !important;
  white-space: pre-line;
}
.enduser-name-font:hover {
  transition: .4s;
  color: #69A5AF;
  opacity: .6 !important;
}
.enduser-name-font_disable {
  font-weight: 600;
  font-size: 1rem;
  color: #666;
  white-space: pre-line;
}
</style>