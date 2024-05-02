import { defineStore } from 'pinia'
import { api } from 'boot/axios'
import { Loading } from 'quasar'
import { setLoading, setNotify } from './partials'

export const useSystemStore = defineStore('systems', {
  state: () => ({
    id: '',
    name: '',
    tuned_model: '',
    systemData: [],
    loading: false
  }),

  actions: {
    async listSystem () {
      setLoading()
      const { status, data, response } = await api.get('/gemini/system')
      if (status === 200) {
        this.systemData = data.result
      } else {
        setNotify(response.data.message, 'red', 'top')
      }
      Loading.hide()
    },
    async showSystem (id) {

      setLoading()
      const { status, data, response } = await api.get(`/gemini/system/${id}`)
      if (status === 200) {
        console.log(this.name)
        this.name = data.result.name
        this.tuned_model = data.result.tuned_model
        console.log(this.name)
      } else {
        setNotify(response.data.message, 'red', 'top')
      }
      Loading.hide()
    },
    async chat (requestData) {
      this.loading = true
      const { status, data, response } = await api.post(`/gemini/chat/`, requestData)
      if (status === 200) {
        this.loading = false
        return data
      } else {
        setNotify(response.data.message, 'red', 'top')
      }
    },
    setId (payload) {
      this.id = payload
    }
  }
})
