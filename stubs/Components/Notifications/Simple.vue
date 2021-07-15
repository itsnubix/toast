<template>
  <div
    aria-live="assertive"
    class="
      max-w-sm
      w-full
      bg-white
      shadow-lg
      rounded-lg
      pointer-events-auto
      ring-1 ring-black ring-opacity-5
      overflow-hidden
      transition
      duration-300
      ease-in-out
    "
  >
    <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
      <div
        v-if="notification.body() && show"
        class="
          max-w-sm
          w-full
          bg-white
          shadow-lg
          rounded-lg
          pointer-events-auto
          ring-1 ring-black ring-opacity-5
          overflow-hidden
        "
      >
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg
                v-if="notification.type() === 'success'"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-green-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                aria-hidden="true"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>

              <svg
                v-if="notification.type() === 'info'"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                aria-hidden="true"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>

              <svg
                v-if="notification.type() === 'warning'"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-yellow-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                />
              </svg>
              <svg
                v-if="notification.type() === 'danger'"
                class="h-6 w-6 text-red-400"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p class="text-sm font-medium text-gray-900">
                {{ notification.title() || notification.body() }}
              </p>
              <p v-if="notification.title()" class="mt-1 text-sm text-gray-500">
                {{ notification.body() }}
              </p>
              <div v-if="$slots.actions" class="mt-3 flex space-x-7">
                <slot name="actions" />
              </div>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
              <button
                class="
                  bg-white
                  rounded-md
                  inline-flex
                  text-gray-400
                  hover:text-gray-500
                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                "
                @click.stop="dismiss"
              >
                <span class="sr-only">Close</span>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  aria-hidden="true"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Message from '@/Models/Message'

export default {
  props: {
    notification: {
      type: Message,
      required: true,
    },
  },
  emits: ['dismiss'],
  data() {
    return {
      timeout: null,
      show: true,
    }
  },
  mounted() {
    if (!this.notification.important())
      this.timeout = setTimeout(() => this.dismiss(), this.notification.timeout() || 10000)

    this.show = true
  },
  methods: {
    dismiss() {
      this.show = false
      this.$emit('dismiss', { id: this.notification.id() })
    },
  },
}
</script>
