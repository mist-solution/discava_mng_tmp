<template>
 <div class="container-fluid bg-light">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Dashboard</a>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" @click="setting"><v-icon>mdi-cog</v-icon></a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" @click="notice"><v-icon>mdi-bell</v-icon></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
  },
  mounted() {
    console.log("example mounted.");
  },
};
</script>