<template>
  <form class="form" @submit.prevent="handleRequest">
    <slot :isLoading="isLoading"></slot>
  </form>
</template>

<script>
import { mapStores } from 'pinia'
import { useModalStore } from '@/store/Modal'
import { useErrorStore } from '@/store/Error'
import handleError from '@/helpers/handleError'
export default {
  data() {
    return {
      isLoading: false
    }
  },
  props: {
    handleCallback: {
      type: Function,
      required: true
    },
    data: {
      type: Object,
      required: true
    }
  },
  computed: {
    ...mapStores(useModalStore, useErrorStore),
    dataComputed() {
      return Object.assign({}, this.data)
    }
  },
  watch: {
    dataComputed: {
      handler(newValue, oldValue) {
        if (!oldValue) {
          return
        }

        Object.keys(newValue).forEach((key) => {
          if (newValue[key] !== oldValue[key]) {
            this.errorStore.deleteError(key)
          }
        })
      },
      deep: true
    }
  },
  methods: {
    async handleRequest() {
      this.isLoading = true
      this.errorStore.clearErrors()
      try {
        await this.handleCallback()
      } catch (error) {
        handleError(error)
      }
      this.isLoading = false
    }
  }
}
</script>
