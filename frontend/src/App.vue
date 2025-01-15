<script setup lang="ts">

</script>

<template>
  <div id="app">
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<style scoped>
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #f8f9fa;
}

nav a {
  margin-right: 1rem;
  text-decoration: none;
  color: #007bff;
}

nav a:hover {
  text-decoration: underline;
}

main {
  padding: 1rem;
}
</style>
