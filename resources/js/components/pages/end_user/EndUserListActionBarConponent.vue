<template>
  <div class="container-fluid mb-3">
    <nav class="navbar">
      <div>
        <router-link v-bind:to="{ name: 'enduser.register' }">
          <button class="btn btn-success">追加</button>
        </router-link>
        <router-link v-bind:to="{ name: 'enduser.register' }">
          <button class="btn btn-success ml-1">削除</button>
        </router-link>
      </div>
    </nav>
  </div>
</template>