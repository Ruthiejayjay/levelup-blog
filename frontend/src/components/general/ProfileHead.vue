<template>
  <Header>
    <div class="profile__img">
      <img :src="user.avatar_path" alt="" class="profileimg__image" />
    </div>
    <div class="profile__details">
      <h2 class="profile__details--name">{{ user.name }}</h2>
      <h4 class="profile__details--email">{{ user.email }}</h4>
      <div class="profile__details--divider"></div>
      <slot></slot>
    </div>
  </Header>
</template>

<script>
import { mapStores } from 'pinia'
import { useAuthStore } from '@/store/Auth'
import Header from '@/components/general/Header.vue'

export default {
  components: { Header },
  computed: {
    ...mapStores(useAuthStore),
    user() {
      return this.authStore.user
    }
  }
}
</script>

<style>
</style>