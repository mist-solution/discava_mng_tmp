<template>
    <v-container>
      <v-card class="error_message mx-5">
        <v-card-title class="ml-2 text-center" width="80%">
        <h3 class="h4 mt-5">ご指定のページは存在しません。</h3>
        <div class="col-md-12">
          <router-link v-bind:to="{ name: 'announce.list' }">
            <button class="btn my-5 green-btn">
              投稿管理に戻る
            </button>
          </router-link>
        </div>
      </v-card-title>
    </v-card>
  </v-container>
</template>

<style src="../pages/css/common.css"></style>
<style src="../pages/css/sidebar.css"></style>
<style src="../pages/css/dropdown.css"></style>

<style scoped>
.error_message{
  position: relative;
  top: 25px;
}
</style>