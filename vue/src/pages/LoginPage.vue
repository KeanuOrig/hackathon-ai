<template>
  <q-page id="login" class="row flex-center">
    <div class="col-lg-3 col-xs-10">
      <q-card class="text-center">
          <q-card-section>
            <br>
            <div class="text-center">
              <q-img
                width="70%"
                src="../assets/logo.png"
              />
            </div>
            <br><br>
            <q-btn rounded color="blue" class="full-width" label="LOGIN WITH GOOGLE" @click="googleLogin" />
          </q-card-section>
      </q-card>

    </div>
  </q-page>
</template>

<script setup>
import { onMounted, onBeforeMount } from 'vue'
import { useAppStore } from 'stores/app'
import { setNotify } from 'src/stores/partials'

const store = useAppStore()
const { googleLogin } = store

onMounted(() => {
  window.addEventListener('message', onMessage, false)
})
onBeforeMount(() => {
  window.removeEventListener('message', onMessage)
})

function onMessage (event) {
  const parentURL = process.env.VUE_APP_API_URL
  if (event.origin === parentURL) {
    if (event.data.type === 'success') {
      const dateToday = new Date().getTime()
      store.setLogin(dateToday)
      localStorage.setItem('auth-data', JSON.stringify(event.data.data.google))
      window.location.href = '/process'
    } else {
      setNotify(event.data.message, 'red', 'top')
    }
  }
}
</script>

<style scoped>

</style>
