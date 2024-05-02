<template>
  <div class="q-pa-md row justify-center items-start q-gutter-md">
    <q-card class="my-card" v-for="(data, index) in systemData" :key="index">
      <q-card-section class="bg-primary text-white">
        <div class="text-h6">Name: {{ data.name }}</div>
        <div class="text-subtitle2">Tuned Model: {{ data.tuned_model }}</div>
      </q-card-section>

      <q-card-actions vertical align="center">
        <q-btn flat @click="redirectToSystem(data.id)">Select</q-btn>
      </q-card-actions>
    </q-card>
  </div>
</template>

<script setup>
  import { onMounted } from 'vue'
  import { useSystemStore } from 'stores/systems'
  import { useRouter } from 'vue-router';
  import { storeToRefs } from 'pinia'

  const router = useRouter();
  const systemStore = useSystemStore();
  const { id, name, tuned_model, systemData } = storeToRefs(systemStore)

  onMounted( () => {
    systemStore.listSystem();
  });

  const redirectToSystem = (systemId) => {
    router.push(`/system/${systemId}`);
  };

</script>

<style lang="sass" scoped>
.my-card
  width: 100%
  max-width: 30rem
</style>
