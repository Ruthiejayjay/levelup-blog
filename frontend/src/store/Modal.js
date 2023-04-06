import { defineStore } from 'pinia'

export const useModalStore = defineStore('modal', {
    state: () => {
        return {
            activeModal: null
        }
    },

    actions: {
        openModal(modal) {
            this.activeModal = modal
        },
        closeModal() {
            this.activeModal = null
        }
    }
})