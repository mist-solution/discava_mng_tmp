<template>

  <v-table class="accounttable" fixed-header>
    <thead  class="displaypc">
      <tr>
        <th class="text-left"></th>
        <th class="text-left">ユーザID</th>
        <th class="text-left">メールアドレス</th>
        <th class="text-left">登録日時</th>
        <th class="text-left">更新日時</th>
        <th class="text-left">編集/削除</th>
      </tr>
    </thead>
    <tbody class="displaypc">
      <tr v-for="item in users" :key="item.id">
        <td>
          <input type="checkbox" :value="item.id" v-model="selected">
        </td>
        <td>{{ item.name }}</td>
        <td>{{ item.email }}</td>
        <td>{{ timestampFormat(item.created_at) }}</td>
        <td>{{ timestampFormat(item.updated_at) }}</td>
        <td class="d-flex align-center">
          <v-icon class="green-icon mr-3" @click="edit(item)">mdi-square-edit-outline</v-icon>
          <v-icon class="green-icon" @click="edit(item)">mdi-trash-can</v-icon>
        </td>
      </tr>
    </tbody>

    <div class="displaysp">
      <tbody>
        <tr v-for="item in users" :key="item.id">
          <div @click="toggleAccordion()"><input type="checkbox" :value="item.id" v-model="selected">{{ item.name }}</div>
            <div v-if="isOpened">
                <tr>
                  <td>ID</td>
                  <td>{{ item.name }}</td>
                </tr>
                <tr>
                  <td>メール</td>
                  <td>{{ item.email }}</td>
                </tr>
                <tr>
                  <td>登録日</td>
                  <td>{{ timestampFormat(item.created_at) }}</td>
                </tr>
                <tr>
                  <td>更新日</td>
                  <td>{{ timestampFormat(item.updated_at) }}</td>
                </tr>
                <tr>
                  <td class="d-flex align-center">
                    <v-icon class="green-icon mr-3" @click="edit(item)">mdi-square-edit-outline</v-icon>
                    <v-icon class="green-icon" @click="edit(item)">mdi-trash-can</v-icon>
                  </td>
                </tr>
            </div>
        </tr>
      </tbody>
    </div>
  </v-table>
</template>

<script>
import { mapState, mapActions } from "vuex";
import { inject } from "vue";
export default {
  data() {
    return {
      selected: [],
      isOpened: false
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
    },
    toggleAccordion() {
      this.isOpened = !this.isOpened;
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

<!-- 共通CSS -->
<style src="../css/common.css"></style>

<!-- 固有CSS -->
<style scoped>
.green-icon {
  color: #69A5AF;
}

.accounttable td {
	background: #F7F7F7;
}
.accounttable tr:nth-child(odd) td {
	background: #fff;
}

/* vue3-data-tableで罫線固定しているためimportantで指定 */
.accounttable tr.th,td {
  border: none !important;
}

.accordionsp {
}

.accordionsp > div {
}


@media (min-width: 600px){
  .displaysp {
    display: none;
  }
}

@media (max-width: 600px){
  .accounttable th {
    background: #FFF;
    border-bottom: 1px solid #F7F7F7 !important;
  }

  .accounttable td {
	background: #FFF;
  }

  .displaypc {
    display: none;
  }

  .displaysp {
    display: block;
  }
}

  </style>