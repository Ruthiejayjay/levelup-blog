<template>
  <AppModal v-if="modalStore.activeModal === 'login'" title="Login">
    <Form :handleCallback="handleLogin" v-slot="slotProps" :data="credentials">
      <Input
        v-model="credentials.email"
        name="email"
        placeholder="Enter your email"
        type="email"
        required="true"
        label="Email"
      />
      <Input
        v-model="credentials.password"
        name="password"
        placeholder="Enter your password"
        type="password"
        required="true"
        label="Password"
      />
      <a
        href="#"
        class="modal__link"
        @click.prevent="modalStore.openModal('register')"
        >I am not a user</a
      >
      <AppButton type="submit" :isLoading="slotProps.isLoading"
        >Login</AppButton
      >
    </Form>
  </AppModal>
</template>

<script>
import AppModal from '@/components/general/AppModal.vue'
import AppButton from '@/components/general/AppButton.vue'
import Input from '@/components/general/Input.vue'
import Form from '@/components/general/Form.vue'
import Auth from '@/services/Auth.js'
import { mapStores } from 'pinia'
import { useModalStore } from '@/store/Modal'

export default {
  name: 'LoginModal',
  components: { AppModal, AppButton, Input, Form },
  data() {
    return {
      showRegisterModal: false,
      invalidCredentials: false,
      isLoading: false,
      credentials: {
        email: 'test@example.com',
        password: 'password'
      }
    }
  },
  computed: {
    ...mapStores(useModalStore)
  },

  methods: {
    async handleLogin() {
      const response = await Auth.login(this.credentials)
      localStorage.setItem('token', response.data)
      this.$router.push({ name: 'my-profile' })
      this.modalStore.closeModal()
    }
  }
}
</script>