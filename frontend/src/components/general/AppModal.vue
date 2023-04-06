<template>
  <div class="modal">
    <div class="modal__inner">
      <div class="modal__close" @click="modalStore.closeModal()">X</div>
      <h3 class="modal__title">{{ title }}</h3>
      <div class="modal__content">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
import { mapStores } from 'pinia'
import { useModalStore } from '@/store/Modal'

export default {
  props: {
    title: {
      type: String,
      required: true
    }
  },
  computed: {
    ...mapStores(useModalStore)
  }
}
</script>