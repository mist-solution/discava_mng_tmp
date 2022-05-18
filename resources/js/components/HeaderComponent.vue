<template>
  <div class="container-fluid bg-light mb-3">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <v-btn icon @click="this.$store.dispatch('sidebar/toggleOpen')">
            <v-icon color='dark'>mdi-menu</v-icon>
          </v-btn>
          <a class="navbar-brand" href="#">Vue Laravel SPA</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">ホーム</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" @click="logout">ログアウト</a>
              </li>
              <!-- <li class="nav-item dropend">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown Link
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" @click="logout">ログアウト</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li> -->
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
      logout() {
        axios
            .post("/logout")
            .then(response => {
                console.log(response);
                localStorage.removeItem("auth");
                window.location.href = "/login"
                
            })
            .catch(error => {
                console.log(error);
            });
      }
  },
  mounted() {
    console.log("header mounted.");
  },
};
</script>