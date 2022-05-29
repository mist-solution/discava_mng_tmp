<template>
  <v-card>
    <v-card-title class="ml-2" width="80%">
      <h3 class="h4">ユーザ一覧</h3>
      <div class="btn-group ml-auto">
        <router-link v-bind:to="{ name: 'enduser.register' }">
          <button class="btn btn-success">追加</button>
        </router-link>
        <router-link v-bind:to="{ name: 'enduser.register' }">
          <button class="btn btn-success ml-1">削除</button>
        </router-link>
      </div>
    </v-card-title>
    <v-divider />
    <v-card-text>
      <end-user-list-table />
    </v-card-text>
  </v-card>
</template>

<script>
import EndUserListTable from "./EndUserListTableComponent.vue";
export default {
  components: {
    EndUserListTable,
  },
}
</script>