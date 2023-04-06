<template>
  <div>
    <Header>
      <h2 class="profile__details--name">Article Editor</h2>
      <div class="profile__details--divider"></div>
      <RouterLink to="/my-Profile" class="profile__details--link"
        >Back to Profile</RouterLink
      >
    </Header>
    <div class="profile__form">
      <h2 class="profile__form--title-article">Add Content</h2>
      <ArticleForm
        action="create"
        :formdata="formdata"
        :callback="newArticleWithImage"
      >
        <Input
          name="image"
          placeholder="Set Image"
          type="file"
          label="Image"
          @change="onFileSelected"
        />
      </ArticleForm>
    </div>
  </div>
</template>

<script>
import Header from '@/components/general/Header.vue'
import ArticleForm from '@/components/forms/ArticleForm.vue'
import Input from '@/components/general/Input.vue'
import ArticleService from '@/services/ArticleService'
import Swal from 'sweetalert2'
export default {
  components: { Header, ArticleForm, Input },
  data() {
    return {
      formdata: {
        title: '',
        content: '',
        categories_id: [],
        image: null
      }
    }
  },
  methods: {
    onFileSelected(event) {
      this.formdata.image = event.target.files[0]
    },

    async newArticleWithImage() {
      try {
        const response = await ArticleService.addNewArticleWithImage(
          this.formdata
        )

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'success',
          title: 'Article creation Successful'
        })
        this.$router.push({
          name: 'article',
          params: { slug: response.data.slug }
        })
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Incomplete article details'
        })
      }
    }
  }
}
</script>
