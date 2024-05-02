import { boot } from 'quasar/wrappers'
import axios from 'axios'
// import { Dialog } from 'quasar'

// Be careful when using SSR for cross-request state pollution
// due to creating a Singleton instance here;
// If any client changes this (global) instance, it might be a
// good idea to move this instance creation inside of the
// "export default () => {}" function below (which runs individually
// for each client)

const baseDomain = process.env.VUE_APP_BASE_URL

const baseURL = `${baseDomain}`

const config = {
  baseURL
}

const api = axios.create(config)

api.interceptors.request.use((config) => {
  const authData = JSON.parse(localStorage.getItem('auth-data'))
  config.headers.Accept = 'application/json'
  config.headers['Content-Type'] = 'application/json'
  if (authData) {
    config.headers.Authorization = `Bearer ${authData.token}`
  }
  return config
})

api.interceptors.response.use(
  response => {
    return response
  },
  err => {
    if (Object.prototype.hasOwnProperty.call(err, 'response')) {
      if (err.response.status === 401) {
        // Dialog({
        //   dark: true,
        //   title: 'Unautheticated',
        //   message: 'Your token has been expired.',
        //   persistent: true
        // }).onOk(() => {
        localStorage.removeItem('auth-data')
        // window.location.href = '/'
        //   window.location.href = '/maintenance'
        // })
      }
      return err
    }
    return Promise.reject(err)
  }
)

export default boot(({ app }) => {
  app.config.globalProperties.$api = api
})

export { api }
