<script setup lang="ts">
  import logo from './../assets/img/logo.svg';
</script>

<template>
  <div class="sidebar">
    <div class="logo-container">
      <img class="logo" :src="logo" alt="Vue 3 + Vite" />
    </div>
  </div>
</template>

<style scoped>
  .sidebar {
    
    background-color: #05472A;
    height: 100vh;
    width: 60px;
  }

  .logo-container {
    height: 60px;
    margin: 5px 5px;
    border-bottom: #F5F7F9 1px solid;
  }
</style>