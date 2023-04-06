<template>
  <button class="btn" :type="type" :disabled="isLoading">
    <slot></slot>
    <span v-if="isLoading" class="btn__loader"></span>
  </button>
</template>
<script>
export default {
  name: 'AppButton',
  props: {
    type: {
      type: String,
      default: 'button'
    },
    isLoading: {
      type: Boolean,
      default: false
    }
  }
}
</script>