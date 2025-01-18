<script setup lang="ts">
import Sidebar from "./components/Sidebar.vue";
import { RouterView } from 'vue-router';
</script>

<template>
  <div class="container">
    <Sidebar />
    <RouterView />
  </div>
</template>

<style scoped>
.container {
  display: flex;
}
</style>