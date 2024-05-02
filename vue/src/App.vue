<template>
  <div>
    <LandingPage v-if="isAuthenticated" />
    <LoginPage v-else />
  </div>
</template>

<script setup>
import { storeToRefs } from 'pinia'
import { useAppStore } from 'stores/app'
import LoginPage from './layouts/LoginLayout.vue'
import LandingPage from './layouts/LandingLayout.vue'

const store = useAppStore()
const { isAuthenticated } = storeToRefs(store)
</script>
