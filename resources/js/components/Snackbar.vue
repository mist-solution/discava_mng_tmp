<template>
  <div>
    <v-snackbar v-model="$store.state.snackbar.snackbar" :timeout="timeout" :color="$store.state.snackbar.color">
      {{ $store.state.snackbar.text }}
    </v-snackbar>
  </div>
</template>

<script>
  export default {
    data: () => ({
      timeout: 2000,
    }),
  };
</script>
