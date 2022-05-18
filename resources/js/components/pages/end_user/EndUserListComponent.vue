<template>
  <v-card>
    <v-card-title class="ml-2" width="80%">ユーザ一覧</v-card-title>
    <v-divider />

    <v-card-actions>
        <end-user-list-action-bar class="ml-3" />
    </v-card-actions>

    <v-card-text>
      <end-user-list-table />
    </v-card-text>
  </v-card>
</template>

<script>
import EndUserListTable from "./EndUserListTableComponent.vue";
import EndUserListActionBar from "./EndUserListActionBarConponent.vue";
export default {
  components: {
    EndUserListTable,
    EndUserListActionBar,
  },
}
</script>