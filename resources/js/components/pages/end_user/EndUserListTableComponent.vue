<template>
  <v-table
    fixed-header
  >
    <thead>
      <tr>
        <th class="text-left">
          ユーザID
        </th>
        <th class="text-left">
          メールアドレス
        </th>
        <th class="text-left">
          顧客
        </th>
        <th class="text-left">
          登録日時
        </th>
        <th class="text-left">
          更新日時
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="item in users"
        :key="item.id"
      >
        <td>{{ item.name }}</td>
        <td>{{ item.email }}</td>
        <td>{{ item.customer_code }}</td>
        <td>{{ timestampFormat(item.created_at) }}</td>
        <td>{{ timestampFormat(item.updated_at) }}</td>
      </tr>
    </tbody>
  </v-table>
</template>

<script>
import { mapState } from 'vuex'
import { inject } from 'vue'
export default {
  data() {
    return {
      end_users: [],
    };
  },
  methods: {
    timestampFormat(timestamp) {
      const dayjs = inject('dayjs');
      return dayjs(timestamp).format('YYYY/MM/DD HH:mm:ss');
    },
  },
  mounted() {
    this.$store.dispatch('enduser/getUsers')
  },
  computed: {
    ...mapState("enduser", ["users"]),
  },
};
</script>