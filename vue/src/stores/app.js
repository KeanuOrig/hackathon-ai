import { defineStore } from 'pinia'
import { api } from 'boot/axios'
import { Loading } from 'quasar'
import { setLoading, setNotify } from './partials'

export const useAppStore = defineStore('app', {
  state: () => ({
    title: 'Dashboard',
    isDrawerOpen: false,
    isMiniMode: false,
    isAuthenticated: localStorage.getItem('auth-data') || false,
    userDetails: JSON.parse(localStorage.getItem('auth-data')) || {},
    signout: false,
    timeLogin: 0,
  }),

  actions: {
    async googleLogin () {
      const newWindow = this.openWindow('', 'message')
      setTimeout(() => {
        api.get('/google/login')
          .then((response) => {
            const urlAccountSelection = response.data
            newWindow.location.href = urlAccountSelection
          })
          .catch(() => {})
      }, 2000)
    },
    openWindow (url, title, options = {}) {
      if (typeof url === 'object') {
        options = url
        url = ''
      }

      options = { url, title, width: 600, height: 720, ...options }

      const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
      const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
      const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
      const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height

      options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
      options.top = ((height / 2) - (options.height / 2)) + dualScreenTop

      const optionsStr = Object.keys(options).reduce((acc, key) => {
        acc.push(`${key}=${options[key]}`)
        return acc
      }, []).join(',')

      const newWindow = window.open(url, title, optionsStr)

      if (window.focus) {
        newWindow.focus()
      }
      return newWindow
    },
    setLogin (payload) {
      this.timeLogin = payload
    }
  }
})
