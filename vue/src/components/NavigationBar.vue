<template>
  <div>
    <q-toolbar class="bg-primary glossy text-white">
      <q-avatar>
        <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
      </q-avatar>


      <q-toolbar-title class="cursor-pointer q-pa-sm" @click="redirectToHome">
        FAQ SYSTEM
      </q-toolbar-title>


      <q-avatar v-if="!profile_picture">
        <img src="https://via.placeholder.com/150">
      </q-avatar>
      <q-avatar v-else>
        <img :src="profile_picture" alt="Profile Picture">
      </q-avatar>
    </q-toolbar>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useAppStore } from 'stores/app'
import { useRouter } from 'vue-router';

const router = useRouter();
const store = useAppStore()

const isAuthenticated = store.isAuthenticated
const profile_picture = ref('')

onMounted(() => {
    const data = JSON.parse(isAuthenticated)
    profile_picture.value = data.profile_picture
})

const redirectToHome = () => {
  router.push('/');
};

</script>
