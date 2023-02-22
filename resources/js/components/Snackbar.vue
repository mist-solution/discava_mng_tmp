<template>
  <div>
    <v-snackbar
        v-model="$store.state.snackbar.snackbar"
        :timeout="timeout"
        :top="true"
      >
      {{ $store.state.snackbar.text }}
    </v-snackbar>
  </div>
</template>

<script>
  export default {
    data: () => ({
      timeout: 1500,
    }),
  };
</script>
<style>
  /* スナックバーの横幅を広げる、 */
  .v-snackbar__content {
    width: 100vw;
    bottom: 50vh !important;
    text-align: center;
    background-color: #69A5AF;
    color: #fff;
  }
  .v-snackbar__wrapper {
    bottom: 50vh !important;
  }
  .v-snackbar {
    background-color: rgba(0, 0, 0, 0.4);
  }
</style>