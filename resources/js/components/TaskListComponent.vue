<template>
  <div class="container">
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Content</th>
          <th scope="col">Person In Charge</th>
          <th scope="col">Show</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <v-btn @click.stop="display = true" fab dark color="grey"
        ><v-icon class="mr-2">mdi-magnify</v-icon>検索</v-btn
      >
      <tbody>
        <tr v-for="(task, index) in tasks" :key="index">
          <th scope="row">{{ task.id }}</th>
          <td>{{ task.title }}</td>
          <td>{{ task.content }}</td>
          <td>{{ task.person_in_charge }}</td>
          <td>
            <router-link
              v-bind:to="{ name: 'task.show', params: { taskId: task.id } }"
            >
              <button class="btn btn-primary">Show</button>
            </router-link>
          </td>
          <td>
            <router-link
              v-bind:to="{ name: 'task.edit', params: { taskId: task.id } }"
            >
              <button class="btn btn-success">Edit</button>
            </router-link>
          </td>
          <td>
            <button class="btn btn-danger" v-on:click="deleteTask(task.id)">
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>


<script>
import "vuetify/styles";

export default {
  props: {
    taskId: String,
  },
  data: function () {
    return {
      tasks: [],
    };
  },
  methods: {
    // 一覧取得
    getTasks() {
      axios.get("/api/tasks").then((res) => {
        this.tasks = res.data;
      });
    },
    //　削除
    deleteTask(id) {
      console.log(`ID:${id} is deleted.`);
      axios.delete("/api/tasks/" + id).then((res) => {
        this.getTasks();
      });
    },
  },

  mounted() {
    this.getTasks();
    console.log("taskList mounted.");
  },
};
</script>