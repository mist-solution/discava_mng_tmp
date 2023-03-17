<template>
    <v-dialog v-show="display" persistent>
      <v-card class="p-3">
        <DatePicker
          class="filter-btnsp datepicker mb-2"
          v-model="createdmodel"
          placeholder="投稿月"
          :format="format"
          :preview-format="previewFormat"
          selectText="確認"
          cancelText="キャンセル"
          month-picker
          locale="jp"
        />

        <DatePicker
          class="filter-btnsp datepicker mb-2"
          v-model="updatedmodel"
          placeholder="更新月"
          :format="format"
          :preview-format="previewFormat"
          selectText="確認"
          cancelText="キャンセル"
          month-picker
          locale="jp"
        />


      <v-select
        dense
        v-model="categoriesmodel"
        :items="categories"
        item-value="id"
        item-title="category_name"
        label="カテゴリー"
        hide-details="false"
        @update:modelValue="categoriesChange"
        class="mb-2"
      />

      <input
        dense
        class="filter-btn user_search mb-2"
        placeholder="　投稿者名"
        type="search"
        hide-details="false"
        v-model="usermodel"
        Style="text-align: center"
      />

      <v-select
        dense
        v-model="releasemodel"
        :items="items"
        label="公開状態"
        item-title="text"
        item-value="id"
        @update:modelValue="releaseChange"
        class="mb-2"
      />
        <!-- 操作 -->
        <v-card-actions class="justify-center">
          <!-- 検索ボタン -->
          <v-btn @click="searchAction()" class="green-btn mx-2">検索</v-btn>
          <!-- リセットボタン -->
           <v-btn @click="resetFilterAnnounce()" class="green-btn mx-2">リセット</v-btn>
          <!-- キャンセルボタン -->
          <v-btn @click="closeAction()" class="gray-btn mx-2">キャンセル</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  import DatePicker from '@vuepic/vue-datepicker';
  import '@vuepic/vue-datepicker/dist/main.css'
  import moment from 'moment';
  export default {
    components: {
    DatePicker,
  },
    props: ["display", "closeAction", "approvalCancel","items","items2","categories","users",
            "createdfirst","updatedfirst","categoriesfirst","userfirst","releasefirst"],
    data() {
      return {
        returnComment: null,
        created_id: "",
        updated_id: "",
        categories_id: "",
        user_id: "",
        release_id: "",
        createdmodel: this.createdfirst,
        updatedmodel: this.updatedfirst,
        categoriesmodel: this.categoriesfirst,
        usermodel: this.userfirst,
        releasemodel: this.releasefirst,
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
        /*userChange: function(id) {
            const postData = {
                id: id,
            };
        this.user_id = id;
        },*/
        releaseChange: function(id) {
            const postData = {
                id: id,
            };
        this.release_id = id;
        },
        FilterAnnounce(){
          if(this.createdmodel != null){
            let start_year
            let start_month
            let end_year
            let end_month
            if(this.createdmodel.month == 11){
              start_month = 12;
              start_year = this.createdmodel.year;
              end_month = 1;
              end_year = start_year + 1
            }else{
              start_month = this.createdmodel.month + 1;
              start_year = this.createdmodel.year;
              end_month = start_month + 1;
              end_year = start_year;
            }
            let start = new Date(start_year + "-" + start_month + "-1")
            let end = new Date(end_year + "-" + end_month + "-1")
            start.setHours(start.getHours() + 9);
            end.setHours(end.getHours() + 9);
            this.$store.dispatch("announce/setDisplaySearchAddDateBegin", start);
            this.$store.dispatch("announce/setDisplaySearchAddDateEnd", end);
          }else{
            this.$store.dispatch("announce/setDisplaySearchAddDateBegin", null);
            this.$store.dispatch("announce/setDisplaySearchAddDateEnd", null);
          }
          //更新月検索
          if(this.updatedmodel != null){
            let start_year
            let start_month
            let end_year
            let end_month
            if(this.updatedmodel.month == 11){
              start_month = 12;
              start_year = this.updatedmodel.year;
              end_month = 1;
              end_year = start_year + 1
            }else{
              start_month = this.updatedmodel.month + 1;
              start_year = this.updatedmodel.year;
              end_month = start_month + 1;
              end_year = start_year;
            }
            let start = new Date(start_year + "-" + start_month + "-1")
            let end = new Date(end_year + "-" + end_month + "-1")
            start.setHours(start.getHours() + 9);
            end.setHours(end.getHours() + 9);
            this.$store.dispatch("announce/setDisplaySearchUpdDateBegin", start);
            this.$store.dispatch("announce/setDisplaySearchUpdDateEnd", end);
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
            if(this.usermodel != 0){
                this.$store.dispatch("announce/setDisplayAnnounceAddAccount", this.usermodel);
            }else{
                this.$store.dispatch("announce/setDisplayAnnounceAddAccount", null);
            }
            //公開/非公開検索
            this.$store.dispatch("announce/setDisplaySearchRelease", this.release_id);
        },
        //検索条件リセット
        resetFilterAnnounce(){
          this.created_id = 0;
          this.updated_id = 0;
          this.categories_id = 0;
          this.user_id = 0;
          this.release_id = 0;
          this.createdmodel = null;
          this.updatedmodel = null;
          this.categoriesmodel = null;
          this.usermodel = null;
          this.releasemodel = null;
          this.FilterAnnounce();
        },
        searchAction(){
          this.FilterAnnounce();
          this.$emit("FilterChange",this.createdmodel,this.updatedmodel,this.categoriesmodel,this.usermodel,this.releasemodel)
          this.closeAction();
        },

        format(date) {
          return moment(date).format('yyyy/MM');
        },

        previewFormat(date) {
          return moment(date).format('yyyy/MM');
        },
    },
    mounted() {},
  };
  </script>

<style src="../pages/css/common.css"></style>
  <style scoped>
  .user_search{
    height: 65px;
    background-color: #f4f4f4;
  }

  ::placeholder {
    text-align: left;
    color: #767676;
    font-size: 16px;
  }

  </style>