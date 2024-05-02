<template>
  <q-layout>

    <q-page-container>
      <login-page/>
    </q-page-container>

  </q-layout>
</template>

<script setup>
import { defineComponent } from 'vue';
import LoginPage from '../pages/LoginPage.vue';

defineComponent({
  name: 'DashboardPage',
  components: {
    'login-page': LoginPage
  },
  setup() {
    return {};
  }
})

</script>
