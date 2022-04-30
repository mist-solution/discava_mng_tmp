<template>
  <div class="container-fluid bg-dark mb-3">
    <div class="container">
      <nav class="navbar navbar-dark">
        <v-btn icon @click="this.$store.dispatch('sidebar/toggleOpen')">
          <v-icon color='white'>mdi-menu</v-icon>
        </v-btn>
        <span class="navbar-brand mb-0 h1">Vue Laravel SPA</span>
        <div>
          <router-link v-bind:to="{ name: 'task.list' }">
            <button class="btn btn-success">List</button>
          </router-link>
          <router-link v-bind:to="{ name: 'task.create' }">
            <button class="btn btn-success">ADD</button>
          </router-link>
          <router-link v-bind:to="{ name: 'quilleditor' }">
            <button class="btn btn-success">News</button>
          </router-link>
        </div>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("header mounted.");
  },
};
</script>