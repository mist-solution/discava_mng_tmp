<template>
  <v-container class="p-0 p-sm-2">
    <v-card class="main-cont">
      <v-card-title>
        <h3 class="h4 p-2 m-0 font-weight-bold">{{ name }}</h3>
    </v-card-title>
  </v-card>
</v-container>
</template>

<script>
export default {
  props:{
    name: String,
  },
}
</script>