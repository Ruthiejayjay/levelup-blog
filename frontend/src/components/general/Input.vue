<template>
  <div class="form__inputWrapper">
    <label class="form__label" :for="name">{{ label }}</label>
    <input
      :type="type"
      :id="name"
      :name="name"
      class="form__input"
      :class="{ 'form__input--hasError': errorStore.errors[name] }"
      v-model="inputValue"
      :disabled="disabled"
    />
    <p class="form__inputError" v-if="errorStore.errors[name]">
      {{ errorStore.errors[name][0] }}
    </p>
  </div>
</template>

<script>
import { mapStores } from 'pinia'
import { useErrorStore } from '@/store/Error'
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
    },
    disabled: {
      type: Boolean,
      default: false
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