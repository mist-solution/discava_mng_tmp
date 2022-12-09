<template>
  <v-card class="main-cont">
    <v-card-title>
      <h3 class="h4">{{ name }}</h3>
    </v-card-title>
  </v-card>
</template>

<script>
export default {
  props:{
    name: String,
  },
}
</script>