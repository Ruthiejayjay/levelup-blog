<template>
  <div>
    <ProfileHead>
      <RouterLink to="/my-Profile" class="profile__details--link"
        >Back to Profile</RouterLink
      >
    </ProfileHead>
    <div class="profile__form">
      <h2 class="profile__form--title">Edit Your Profile</h2>
      <img
        @click="showAvatarUpload = !showAvatarUpload"
        :src="user.avatar_path"
        alt=""
        class="profileimg__image profileimg__image--hero"
      />
      <myUpload
        field="img"
        @crop-success="cropSuccess"
        v-model="showAvatarUpload"
        :width="300"
        :height="300"
        img-format="png"
        langType="en"
      />
      <Form
        :handleCallback="updateUserDetails"
        v-slot="slotProps"
        :data="profileDetails"
      >
        <Input
          v-model="profileDetails.email"
          name="email"
          :placeholder="user.email"
          type="email"
          required="true"
          label="Email"
          :disabled="true"
        />
        <Input
          v-model="profileDetails.name"
          name="name"
          :placeholder="user.name"
          type="text"
          label="Name"
        />
        <Input
          v-model="profileDetails.slug"
          name="slug"
          :placeholder="user.slug"
          type="text"
          label="Username"
        />
        <Input
          v-model="profileDetails.password"
          name="password"
          :placeholder="user.password"
          type="password"
          label="Password"
          :disabled="true"
        />
        <AppButton type="submit" :isLoading="slotProps.isLoading"
          >Update</AppButton
        >
      </Form>
    </div>
  </div>
</template>

<script>
import ProfileHead from '@/components/general/ProfileHead.vue'
import Form from '@/components/general/Form.vue'
import Input from '@/components/general/Input.vue'
import AppButton from '@/components/general/AppButton.vue'
import Auth from '@/services/Auth.js'
import { mapStores } from 'pinia'
import { useAuthStore } from '@/store/Auth'
import myUpload from 'vue-image-crop-upload'
export default {
  components: { ProfileHead, Form, Input, AppButton, myUpload },
  data() {
    return {
      isLoading: false,
      showAvatarUpload: false,
      profileDetails: {
        email: '',
        name: '',
        slug: ''
      }
    }
  },
  computed: {
    ...mapStores(useAuthStore),
    user() {
      return this.authStore.user
    }
  },
  async created() {
    Object.keys(this.profileDetails).forEach((key) => {
      this.profileDetails[key] = this.user[key]
    })
  },
  methods: {
    async updateUserDetails() {
      const response = await Auth.handleUpdateUserDetails(
        this.user.id,
        this.profileDetails
      )
      this.authStore.setUser(response.data)
      this.$router.push({ name: 'my-profile' })
    },
    async cropSuccess(imgDataUrl, field) {
      const avatar = this.dataUrlToFile(imgDataUrl, field)
      const response = await Auth.handleUpdateUserDetailsWithAvatar(
        this.user.id,
        avatar
      )
      this.authStore.setUser(response.data)
    },
    dataUrlToFile(dataurl, filename) {
      let arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n)
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n)
      }
      return new File([u8arr], filename, { type: mime })
    }
  }
}
</script>

<style>
</style>