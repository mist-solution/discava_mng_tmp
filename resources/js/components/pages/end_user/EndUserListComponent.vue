<template>
  <title-component
   name = "アカウント一覧"
  />
  <v-card class="mt-5">
    <v-card-text>
      <end-user-list-table />
    </v-card-text>
  </v-card>
</template>

<script>
import EndUserListTable from "./EndUserListTableComponent.vue";
import TitleComponent from "../../common/TitleComponent.vue"
export default {
  components: {
    EndUserListTable,
    TitleComponent,
  },
}
</script>