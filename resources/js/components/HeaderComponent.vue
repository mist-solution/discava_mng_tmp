<template>
 <div class="container-fluid bg-light">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <!-- <a class="navbar-brand" href="#">Dashboard</a> -->
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a
                  class="nav-link active header-icon"
                  aria-current="page"
                  @click="(displayDevelopMentModal = true)"
                >
                  <v-icon>mdi-cog</v-icon>
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link active header-icon"
                  aria-current="page"
                  @click="(displayDevelopMentModal = true)"
                >
                  <v-icon>mdi-bell</v-icon>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <development-modal-component
      :modelValue="displayDevelopMentModal"
      @update:modelValue="displayDevelopMentModal = $event"
      :closeAction="closeReturn"
    />
  </div>
</template>

<script>
import DevelopmentModalComponent from "../components/modals/DevelopmentModalComponent.vue"

export default {
  components: {
    DevelopmentModalComponent,
  },
  data() {
    return {
      displayDevelopMentModal: false,
    }
  },
  methods: {
    closeReturn() {
      this.displayDevelopMentModal = false;
    },
  },
  mounted() {
    console.log("header mounted.");
  },
};
</script>

<style scoped>
.header-icon {
  cursor: pointer;
}
</style>