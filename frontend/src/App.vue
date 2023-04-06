

<template>
  <div>
    <AppHeader />
    <RouterView />
    <AppFooter />
    <LoginModal />
    <RegisterModal />
    <notifications position="bottom right" />
  </div>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import AppHeader from './components/general/AppHeader.vue'
import AppFooter from './components/general/AppFooter.vue'
import LoginModal from '@/components/auth/LoginModal.vue'
import RegisterModal from '@/components/auth/RegisterModal.vue'

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
    LoginModal,
    RegisterModal
  }
}
</script>
<style lang="scss">
@import '@/assets/scss/style.scss';
</style>
