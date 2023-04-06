<template>
  <header class="header">
    <div class="header__inner">
      <h1 class="header__title">
        <RouterLink to="/" class="header__title-link">
          LevelUp Blog
        </RouterLink>
      </h1>
      <nav class="header__nav">
        <ul class="header__nav-list">
          <li class="header__nav-item">
            <RouterLink to="/" class="header__nav-item-link">Home</RouterLink>
          </li>
          <li class="header__nav-item" v-if="authStore.isLoggedIn">
            <RouterLink
              :to="{ name: 'my-profile' }"
              class="header__nav-item-link"
              >My Profile</RouterLink
            >
          </li>
          <li class="header__nav-item" v-if="authStore.isLoggedIn">
            <a
              href="#"
              @click.prevent="logUserOut"
              class="header__nav-item-link"
            >
              Logout
            </a>
          </li>

          <li class="header__nav-item" v-if="authStore.isGuest">
            <a
              href="#"
              @click.prevent="modalStore.openModal('login')"
              class="header__nav-item-link"
            >
              Login
            </a>
          </li>
          <li class="header__nav-item" v-if="authStore.isGuest">
            <a
              href="#"
              @click.prevent="modalStore.openModal('register')"
              class="header__nav-item-link"
            >
              Register
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script>
import { mapStores } from 'pinia'
import { useModalStore } from '@/store/Modal'
import { useAuthStore } from '@/store/Auth'
import { useRouter } from 'vue-router'
export default {
  name: 'AppHeader',
  computed: {
    ...mapStores(useModalStore, useAuthStore)
  },
  methods: {
    logUserOut() {
      this.authStore.logoutUser()
      this.$router.push('/')
    }
  }
}
</script>

<style>
</style>