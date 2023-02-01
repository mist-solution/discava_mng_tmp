<template>
  <div
    v-if="$store.state.announce.loadingCircular"
    class="progress-circular_position"
  >
    <v-progress-circular
        indeterminate
        color="grey"
      >
      </v-progress-circular>
  </div>
</template>

<script>
  export default {
    data: () => ({
    }),
  };
</script>

<style scoped>
  .progress-circular_position {
    position: absolute;
    top: 50%;
    left: 50%;
  }
</style>