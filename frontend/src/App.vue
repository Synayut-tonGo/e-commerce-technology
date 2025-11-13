<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div>
    <RouterLink to="/dashboard">Dashboard</RouterLink>
    <RouterLink to="/login">Login</RouterLink>
  </div>
  <div>
    <RouterView />
  </div>
</template>