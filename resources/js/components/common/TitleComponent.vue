<template>
    <v-card class="main-cont sp-title mb-0 mb-sm-5">
      <v-card-title class="pl-0 pl-sm-4">
        <h3 class="p-3 pl-0 pl-sm-4 m-0 font-weight-bold title-name">{{ name }}</h3>
    </v-card-title>
  </v-card>
</template>
<style scoped>
.title-name {
  color: #707070;
  font-size: clamp(1.375rem, 1.33rem + 0.23vw, 1.5rem);
}
@media (max-width: 599.9px){
  .sp-title{
    box-shadow: unset;
    background: unset;
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