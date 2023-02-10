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
      id="accountlist"
		>



    
    <template #expand="item">
      <div style="padding: 15px">
        <v-row>
          <v-col>
            ID
          </v-col>
          <v-col>
            {{item.name}}
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            メール
          </v-col>
          <v-col>
            {{item.email}}
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            登録日
          </v-col>
          <v-col>
            {{item.created_at.slice(0,4)}}/{{item.created_at.slice(5,7)}}/{{item.created_at.slice(8,10)}}
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            更新日
          </v-col>
          <v-col>
            {{item.updated_at.slice(0,4)}}/{{item.updated_at.slice(5,7)}}/{{item.updated_at.slice(8,10)}}
          </v-col>
        </v-row>
        <v-row class="accordion_icons" v-if="approval_auth_flg">
          <div>
            <router-link :to="{ name: 'enduser.update', params: { userId: item.id } }">
              <v-icon class="green-icon">mdi-square-edit-outline</v-icon>
            </router-link>
          </div>
          <div>
            <v-icon class="green-icon"
              @click.stop="(displayAccountDeleteConfirm = true), setDeleteAccountId(item.id)"
            >
              mdi-trash-can
            </v-icon>
          </div>
        </v-row>
      </div>
    </template> 
      <!-- ユーザ名 -->
			<template #item-name="item">
				{{ item.name }}
			</template> 
		</EasyDataTable>
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
          { text: '', value: 'name' },
        ],
        users: [],
        displayAccountDeleteConfirm: false,
        menuDeleteAnnounce: [],
        select: [],
        themeColor: "#69A5AF",
        searchField: "name",
        approval_auth_flg: null,
        rowsPerPage: 10,
        reset: true,
        page: 1,
        PageLastIndex: "",
        items: [ {id:'0',text:"アカウント一括削除"},
                 {id:'1',text:"権限一括付与"},
                 {i2:'2',text: "権限一括削除"}],
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
      
    },
    methods: {
      ...mapActions('authority', ['fetchAllAuthority']),
      mergeProps,
      closeAction() {
        this.displayAccountDeleteConfirm = false;
      },
      getAccountList() {
        axios
          .get("/api/enduser", {
          })
          .then((res) => {
            this.users = res.data.users;
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
        this.getAccountList();
        
      },
      timestampFormat(timestamp) {
        const dayjs = inject("dayjs");
        return dayjs(timestamp).format("YYYY/MM/DD HH:mm:ss");
      },
      edit(user) {
        this.$router.push({
          name: 'enduser.update',
          params: { userId: user.id }
        });
      },

      operateidChange: function(id) {
      const postData = {
        id: id,
      };
      this.operate_id = id;
      },

    },
    async mounted() {
      this.getAccountList();
      this.setSelectItems();
      let authority = await this.fetchAllAuthority();
      if(authority){
        this.approval_auth_flg = authority.approval_auth_flg;
        if(!this.approval_auth_flg){
          this.headers[3].text = "";
        }
      }
      let a = this.$refs.dataTable.clientItemsLength;
      this.PageLastIndex = this.$refs.dataTable.maxPaginationNumber;
      this.$emit("LastPageChange",this.PageLastIndex,a)
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

.action-select .v-field--variant-filled  {
  border: #eee 1px solid !important;
  border-radius: 8px;
  height: 56px;
}

.accordion_icons{
  display: flex;
  justify-content: flex-end;
}

.expand-icon{
  color: #69A5AF !important;
}
</style>