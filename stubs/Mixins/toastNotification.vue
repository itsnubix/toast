<script>
import Message from '@/Models/Message'

export default {
  props: {
    src: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      notifications: [],
    }
  },
  watch: {
    src: {
      handler() {
        this.src.forEach(this.pushNotification)
      },
      deep: true,
    },
  },
  mounted() {
    if (this.src === null) return

    this.src.forEach(this.pushNotification)

    this.$toast.listen(this.pushNotification)
  },
  methods: {
    confirm(notification) {
      this.notifications = this.notifications.filter((n) => n.id() !== notification.id())
    },
    dismiss(notification) {
      this.notifications = this.notifications.filter((n) => n.id() !== notification.id())
    },
    pushNotification(message) {
      this.notifications.push(Message.make(message))
    },
  },
}
</script>
