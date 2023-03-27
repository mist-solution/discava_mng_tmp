<template>
  <div>
    <v-row>
      <!-- タイトル -->
      <v-col>
        <v-card-title class="pl-0">
          <h3 class="p-3 pl-0 m-0 pl-0 font-weight-bold title-name">{{ name }}</h3>
        </v-card-title>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { tr } from 'date-fns/locale';

export default {
  props:{
    name: String,
    tabFlg: Boolean
  },
  data() {
    return {
      tab: null,
    };
  },
  methods: {
  }
}
</script>

<style scoped>
.title-name {
  color: #707070;
  font-size: clamp(1.438rem, 1.369rem + 0.34vw, 1.625rem);
  padding-top: 0 !important;
}

.tab-text {
  font-size: 14px !important;
  font-weight: 700 !important;
  color: #707070 !important;
}
</style>