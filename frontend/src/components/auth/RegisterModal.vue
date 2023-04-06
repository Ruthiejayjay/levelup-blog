<template>
  <AppModal v-if="modalStore.activeModal === 'register'" title="Register">
    <Form
      :handleCallback="handleRegister"
      :data="userDetails"
      v-slot="slotProps"
    >
      <Input
        v-model="userDetails.name"
        name="name"
        placeholder="Enter your name"
        label="Name"
      />
      <Input
        v-model="userDetails.email"
        name="email"
        type="email"
        placeholder="Enter your email"
        label="Email"
      />
      <Input
        v-model="userDetails.slug"
        name="slug"
        placeholder="Enter your username"
        label="Username"
      />
      <Input
        v-model="userDetails.password"
        name="password"
        placeholder="Enter your password"
        type="password"
        label="Password"
      />
      <a
        href="#"
        class="modal__link"
        @click.prevent="modalStore.openModal('login')"
        >I am already a user</a
      >
      <AppButton type="submit" :isLoading="slotProps.isLoading"
        >Register</AppButton
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
  components: {
    AppModal,
    AppButton,
    Input,
    Form
  },
  data() {
    return {
      isLoading: false,
      inValidUserDetails: false,
      userDetails: {
        name: '',
        email: '',
        slug: '',
        password: ''
      }
    }
  },
  computed: {
    ...mapStores(useModalStore)
  },

  methods: {
    async handleRegister() {
      const response = await Auth.register(this.userDetails)
      localStorage.setItem('token', response.data.token)
      this.$router.push({ name: 'my-profile' })
      this.modalStore.closeModal()
    }
  }
}
</script>