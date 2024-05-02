import { Loading, QSpinnerIos, Notify } from 'quasar'

export function setLoading () {
  Loading.show()
  Loading.show({
    spinner: QSpinnerIos,
    spinnerColor: 'blue',
    spinnerSize: 70
  })
}
export function setNotify (message, color, position) {
  Notify.create({
    color,
    message,
    position,
    timeout: 3000
  })
}
