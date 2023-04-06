<template>
  <div class="form__inputWrapper">
    <label
      :class="[
        'form__label',
        { 'form__label--hasError': errorStore.errors[name] }
      ]"
      :for="name"
      >{{ label }}</label
    >
    <textarea
      v-model="inputValue"
      :type="type"
      :id="name"
      :name="name"
      class="form__input form__input--textarea"
      :class="{ 'form__input--hasError': errorStore.errors[name] }"
      :placeholder="placeholder"
    >
    </textarea>
    <p class="form__inputError" v-if="errorStore.errors[name]">
      {{ errorStore.errors[name][0] }}
    </p>
  </div>
</template>
  
  <script>
import { mapStores } from 'pinia'
import { useErrorStore } from '@/store/error'

export default {
  props: {
    modelValue: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    type: {
      type: String,
      default: 'text'
    },
    placeholder: {
      type: String,
      default: ''
    }
  },
  computed: {
    inputValue: {
      get() {
        return this.modelValue
      },
      set(value) {
        this.$emit('update:modelValue', value)
      }
    },
    ...mapStores(useErrorStore)
  }
}
</script>
  