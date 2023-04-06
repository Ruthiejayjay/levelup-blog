import { defineStore } from 'pinia'
import { useRouter } from 'vue-router'

export const useAuthStore = defineStore('auth', {
    state: () => {
        return {
            user: {},
        }
    },

    getters: {
        isLoggedIn() {
            return Object.keys(this.user).length > 0
        },
        isGuest() {
            return !this.isLoggedIn
        }
    },

    actions: {
        setUser(user) {
            this.user = user
        },
        logoutUser() {
            this.user = {}
            localStorage.removeItem('token')
        }
    }
})