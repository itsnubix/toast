import mitt from 'mitt'
import Message from '@/Models/Message'

const emitter = mitt()
function toast(message) {
  emitter.emit('toast', message instanceof Message ? message.internals : message)
}

function listenForToastNotification(callback) {
  emitter.on('toast', callback)
}

export default {
  install: (app) => {
    app.config.globalProperties.$toast = {
      push: toast,
      listen: listenForToastNotification,
    }
  },
}
