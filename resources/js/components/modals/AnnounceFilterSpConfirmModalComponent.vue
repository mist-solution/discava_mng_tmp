<template>
    <v-dialog v-show="display" persistent>
      <v-card class="p-3">
        <v-select
        dense
        :items="items2"
        label="投稿月"
        item-value="id"
        item-title="text"
        @update:modelValue="createdChange"
      />

      <v-select
        dense
        :items="items2"
        label="更新月"
        item-value="id"
        item-title="text"
        @update:modelValue="updatedChange"
      />

      <v-select
        dense
        :items="categories"
        item-value="id"
        item-title="category_name"
        label="カテゴリー"
        hide-details="false"
        @update:modelValue="categoriesChange"
      />

      <v-select
        dense
        :items="users"
        label="投稿者名"
        item-value="id"
        item-title="name"
        hide-details="false"
        @update:modelValue="userChange"
      />

      <v-select
        dense
        :items="items"
        label="公開状態"
        item-title="text"
        item-value="id"
        @update:modelValue="releaseChange"
      />
        <!-- 操作 -->
        <v-card-actions class="justify-center">
          <!-- 検索ボタン -->
          <v-btn @click="searchAction()" class="green-btn mx-2">検索</v-btn>
          <!-- キャンセルボタン -->
          <v-btn @click="closeAction()" class="gray-btn mx-2">キャンセル</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    props: ["display", "closeAction", "approvalCancel","items","items2","categories","users"],
    data() {
      return {
        returnComment: null,
        created_id: "",
        updated_id: "",
        categories_id: "",
        user_id: "",
        release_id: "",
      };
    },
    methods: {
      //ドロップダウンリスト更新
        createdChange: function(id) {
            const postData = {
                id: id,
            };
            this.created_id = id;
        },
        updatedChange: function(id) {
            const postData = {
                id: id,
            };
            this.updated_id = id;
        },
        categoriesChange: function(id) {
            const postData = {
                id: id,
            };
        this.categories_id = id;
        },
        userChange: function(id) {
            const postData = {
                id: id,
            };
        this.user_id = id;
        },
        releaseChange: function(id) {
            const postData = {
                id: id,
            };
        this.release_id = id;
        },
        FilterAnnounce(){
        //投稿月検索
            if(this.created_id != 0){
                if(this.created_id == 1){
                let start = new Date(this.items2[this.created_id].year + "-" + this.items2[this.created_id].month + "-1")
                this.$store.dispatch("announce/setDisplaySearchAddDateBegin", start);
                }else{
                let start = new Date(this.items2[this.created_id].year + "-" + this.items2[this.created_id].month + "-1")
                let end = new Date(this.items2[this.created_id - 1].year + "-" + this.items2[this.created_id - 1].month + "-1")
                this.$store.dispatch("announce/setDisplaySearchAddDateBegin", start);
                this.$store.dispatch("announce/setDisplaySearchAddDateEnd", end);
                }
            }else{
                this.$store.dispatch("announce/setDisplaySearchAddDateBegin", null);
                this.$store.dispatch("announce/setDisplaySearchAddDateEnd", null);
            }
            //更新月検索
            if(this.updated_id != 0){
                if(this.updated_id == 1){
                let start = new Date(this.items2[this.updated_id].year.toString() + "-" + this.items2[this.updated_id].month.toString() + "-1")
                this.$store.dispatch("announce/setDisplaySearchUpdDateBegin", start);
                }else{
                let start = new Date(this.items2[this.updated_id].year.toString() + "-" + this.items2[this.updated_id].month.toString() + "-1")
                let end = new Date(this.items2[this.updated_id - 1].year.toString() + "-" + this.items2[this.updated_id - 1].month.toString() + "-1")
                this.$store.dispatch("announce/setDisplaySearchUpdDateBegin", start);
                this.$store.dispatch("announce/setDisplaySearchUpdDateEnd", end);
                }
            }else{
                this.$store.dispatch("announce/setDisplaySearchUpdDateBegin", null);
                this.$store.dispatch("announce/setDisplaySearchUpdDateEnd", null);
            }
            //カテゴリ検索
            if(this.categories_id != 0){
                this.$store.dispatch("announce/setDisplaySearchCategory", this.categories_id);
            }else{
                this.$store.dispatch("announce/setDisplaySearchCategory", null);
            }
            //ユーザー検索
            if(this.user_id != 0){
                this.$store.dispatch("announce/setDisplayAnnounceAddAccount", this.user_id);
            }else{
                this.$store.dispatch("announce/setDisplayAnnounceAddAccount", null);
            }
            //公開/非公開検索
            this.$store.dispatch("announce/setDisplaySearchRelease", this.release_id);
        },
        searchAction(){
            this.FilterAnnounce();
            this.closeAction();
        }
    },
    mounted() {},
  };
  </script>