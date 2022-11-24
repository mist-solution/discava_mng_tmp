<template>
  <v-card>
    <v-card-title class="ml-2" width="80%">
      <h3 class="h4">ページが存在しません。</h3>
      <div class="col-md-8">
        <router-link v-bind:to="{ name: 'news.list' }">
          <button class="btn btn-success ml-1">
            戻る
          </button>
        </router-link>
      </div>
    </v-card-title>
  </v-card>
</template>
