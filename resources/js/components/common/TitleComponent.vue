<template>
    <v-card class="main-cont sp-title mb-0 mb-sm-5">
      <v-card-title class="pl-0 pl-sm-4">
        <h3 class="h4 p-2 pl-0 pl-sm-4 m-0 font-weight-bold">{{ name }}</h3>
    </v-card-title>
  </v-card>
</template>
<style scoped>

@media (max-width: 599.9px){
  .sp-title{
    box-shadow: unset;
    background: unset;
  }
  .h4{
    font-size:1.1rem;
  }
}

</style>
<script>
export default {
  props:{
    name: String,
  },
}
</script>