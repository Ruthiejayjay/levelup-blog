import { defineStore } from 'pinia'

export const useErrorStore = defineStore('error', {
    state: () => {
        return {
            errors: {}
        }
    },
    actions: {
        setErrors(errors) {
            this.errors = errors
        },
        clearErrors() {
            this.errors = {}
        },
        deleteError(key) {
            delete this.errors[key]
        }
    }
})
