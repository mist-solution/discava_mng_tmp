<template>
  <div class="container">
    <div class="row justify-body-center">
      <v-card>
        <v-row>
          <v-col class="mt-3">
            <v-card-title>タイトル：{{ this.announce.title }}</v-card-title>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-card-text>本文：
              <p v-html="announce.body">
              </p>
            </v-card-text>
          </v-col>
        </v-row>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    announceId: String,
  },
  data: function () {
    return {
      announce: {},
    };
  },
  methods: {
    getannounce() {
      this.$axios.post("/webapi/announce/detail/" + this.announceId).then((res) => {
        this.announce = res.data;
        console.log(this.announce)
      });
    },
  },
  mounted() {
    this.getannounce();
  },
};
</script>