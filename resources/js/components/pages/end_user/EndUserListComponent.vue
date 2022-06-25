<template>
  <v-card>
    <v-card-title class="ml-2" width="80%">
      <h3 class="h4">ユーザ一覧</h3>
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