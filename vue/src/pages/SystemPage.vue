<template>
    <div class="text-center q-pa-md">
      <div class="text-h6">Name: {{ name }}</div>
      <div class="text-h7">Tuned Model: {{ tuned_model }}</div>
    </div>
  <div class="q-pa-md row justify-center">
    <div style="width: 100%; max-width: 50rem" class="bg-grey-1 shadow-2">
      <div class="q-pa-md">

        <template v-for="(message, index) in chatMessages" :key="index">
            <!-- Render different chat message based on sent status -->
            <q-chat-message
              v-if="message.sent"
              :name="message.name"
              :avatar="message.avatar"
              sent
              :text-color="message.textColor"
              :bg-color="message.bgColor"
            >
              <div>{{ message.content }}</div>

            </q-chat-message>

            <q-chat-message
              v-else
              :name="message.name"
              :avatar="message.avatar"
              :text-color="white"
              :bg-color="primary"
            >
              <div>{{ message.content }}</div>
            </q-chat-message>
          </template>

          <q-chat-message
              v-if="loading"
              sent
              text-color="white"
              bg-color="primary"
            >
              <q-spinner-dots size="2rem" />
            </q-chat-message>

        <q-input v-model="inputMessage" placeholder="Type your message..." outlined clearable @keydown.enter="sendMessage" />
      </div>
    </div>
  </div>
</template>

<script setup>
    import { onMounted, onBeforeMount, ref } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { useSystemStore } from 'stores/systems'
    import { storeToRefs } from 'pinia'
    import { useAppStore } from 'stores/app'

    // todo: refactor and utilize pinia
    const route = useRoute();

    const appStore = useAppStore()
    const systemStore = useSystemStore();

    const { id, name, tuned_model, loading, systemData } = storeToRefs(systemStore)
    const isAuthenticated = appStore.isAuthenticated
    const profile_picture = ref('')
    const email = ref('')
    const inputMessage = ref('')
    const chatMessages = ref([
      {
        name: "FAQ SYSTEM",
        avatar: 'https://cdn.quasar.dev/logo-v2/svg/logo.svg',
        sent: true,
        textColor: 'white',
        bgColor: 'primary',
        content: 'How can I help you today?',
      },
    ]);

    onBeforeMount( async () => {
      systemStore.setId(route.params.systemId)
      await systemStore.showSystem(id.value)

      const data = JSON.parse(isAuthenticated)
      email.value = data.email
      profile_picture.value = data.profile_picture
    })

    const sendMessage = async () => {
      if (inputMessage.value.trim() !== '') {
        chatMessages.value.push({
          name: email.value,
          avatar: profile_picture.value,
          sent: false,
          textColor: 'black',
          bgColor: 'amber',
          content: inputMessage.value,
        });

        const message = inputMessage.value
        inputMessage.value = '';

        const requestData = {
          "model": tuned_model.value,
          "message": message
        }

        const response = await systemStore.chat(requestData)
        chatMessages.value.push({
          name: name.value,
          avatar: 'https://cdn.quasar.dev/logo-v2/svg/logo.svg',
          sent: true,
          textColor: 'white',
          bgColor: 'primary',
          content: response.result,
        });
      }
    };
</script>

<style lang="sass" scoped>
.my-emoticon
  vertical-align: middle
  height: 2em
  width: 2em
</style>
