<template>
  <q-layout>
    <q-page-container>
      <navigation></navigation>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import navigation from '../components/NavigationBar.vue'

</script>

<style scoped>
.q-page-container {
  padding-top: 0px;
}
</style>
