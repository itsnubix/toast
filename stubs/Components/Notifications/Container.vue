<template>
  <div
    class="
      fixed
      inset-0
      flex flex-col
      space-y-1
      px-4
      py-6
      pointer-events-none
      sm:p-6
      items-center
      justify-end
      sm:items-end sm:justify-start
      transition
      ease-in-out
      duration-300
    "
  >
    <transition-group
      enter-active-class="transform ease-out duration-300 transition"
      enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
      enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
      leave-active-class="transform transition ease-in-out duration-300"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0 translate-y-8 sm:translate-y-0 sm:translate-x-10"
    >
      <simple
        v-for="notification in notifications"
        :key="notification.id()"
        :notification="notification"
        @dismiss="dismiss(notification)"
      >
        <template v-if="notification.important()" #actions>
          <button
            class="
              bg-white
              rounded-md
              text-sm
              font-medium
              text-indigo-600
              hover:text-indigo-500
              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
            "
            @click.prevent="confirm(notification)"
          >
            Confirm
          </button>
          <button
            class="
              bg-white
              rounded-md
              text-sm
              font-medium
              text-gray-700
              hover:text-gray-500
              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
            "
            @click.prevent="dismiss(notification)"
          >
            Dismiss
          </button>
        </template>
      </simple>
    </transition-group>
  </div>
</template>

<script>
import ToastNotification from '@/Mixins/toastNotification'
import Simple from '@/Components/Notifications/Simple'

export default {
  components: {
    Simple,
  },
  mixins: [ToastNotification],
}
</script>
