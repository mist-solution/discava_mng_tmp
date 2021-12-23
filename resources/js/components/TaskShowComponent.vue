<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <form>
          <div class="form-group row border-bottom">
            <label for="id" class="col-sm-3 col-form-label">ID</label>
            <input
              type="text"
              class="col-sm-9 form-control-plaintext"
              readonly
              id="id"
              v-bind:value="taskId"
            />
          </div>
          <div class="form-group row border-bottom">
            <label for="title" class="col-sm-3 col-form-label">Title</label>
            <input
              type="text"
              class="col-sm-9 form-control-plaintext"
              readonly
              id="title"
              v-bind:value="title"
            />
          </div>
          <div class="form-group row border-bottom">
            <label for="content" class="col-sm-3 col-form-label">Content</label>
            <input
              type="text"
              class="col-sm-9 form-control-plaintext"
              readonly
              id="content"
              v-bind:value="Content"
            />
          </div>
          <div class="form-group row border-bottom">
            <label for="person-in-charge" class="col-sm-3 col-form-label"
              >Person In Charge</label
            >
            <input
              type="text"
              class="col-sm-9 form-control-plaintext"
              readonly
              id="person-in-charge"
              v-bind:value="PIC"
            />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
 
 <script>
export default {
  props: {
    taskId: String,
    title: String,
    Content: String,
    PIC: String,
  },
  mounted() {
    console.log(this.$route.params.taskId);
    console.log(this.$route.params.title);
    console.log(this.$route.params.Content);
    console.log(this.$route.params.PIC);
  },
};
</script>