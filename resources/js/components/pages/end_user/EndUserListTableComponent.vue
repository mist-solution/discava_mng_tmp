<template>
  <div class="btn-group ml-auto mb-1">
    <router-link v-bind:to="{ name: 'enduser.register' }">
      <button class="btn btn-success">追加</button>
    </router-link>
    <button @click="deleteAll" class="btn btn-success ml-1">削除</button>
  </div>
  <v-table fixed-header>
    <thead>
      <tr>
        <th class="text-left">選択</th>
        <th class="text-left">ユーザID</th>
        <th class="text-left">ユーザ名</th>
        <th class="text-left">メールアドレス</th>
        <th class="text-left">登録日時</th>
        <th class="text-left">更新日時</th>
        <th class="text-left">編集/削除</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in users" :key="item.id">
        <th>
          <input type="checkbox" :value="item.id" v-model="selected">
        </th>
        <td>{{ item.name }}</td>
        <td>{{ item.email }}</td>
        <td>{{ timestampFormat(item.created_at) }}</td>
        <td>{{ timestampFormat(item.updated_at) }}</td>
        <td>
          <v-btn @click="edit(item)" depressed color="primary">
            編集
          </v-btn>
        </td>
      </tr>
    </tbody>
  </v-table>
</template>

<script>
import { mapState, mapActions } from "vuex";
import { inject } from "vue";
export default {
  data() {
    return {
      selected: [],
    };
  },
  methods: {
    ...mapActions('enduser', ['fetchUsers']),
    ...mapActions('customer', ['fetchCustomers']),
    ...mapActions("snackbar", ["openSuccess", "openWarning", "openError", "closeSnackbar"]),
    timestampFormat(timestamp) {
      const dayjs = inject("dayjs");
      return dayjs(timestamp).format("YYYY/MM/DD HH:mm:ss");
    },
    edit(user) {
      this.$router.push({
        name: 'enduser.update',
        params: {user_id: user['id']}
      });
    },
    deleteAll() {
      if (this.selected.length === 0) {
        this.openError('対象が選択されていません');
        return;
      }
      this.$axios.post('/api/enduser/delete', this.selected)
        .then(response => {
            this.openSuccess('削除しました');
            this.fetchUsers();
        })
        .catch(error => {
            console.log(error);
        });
    }
  },
  mounted() {
    this.fetchUsers();
    this.fetchCustomers();
  },
  computed: {
    ...mapState("enduser", ["users"]),
  },
};
</script>