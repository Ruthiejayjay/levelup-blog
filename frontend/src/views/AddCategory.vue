<template>
  <div>
    <Header>
      <h2 class="profile__details--name">Category Editor</h2>
      <div class="profile__details--divider"></div>
      <RouterLink to="/my-Profile" class="profile__details--link"
        >Back to Profile</RouterLink
      >
    </Header>
    <div class="profile__form">
      <h2 class="profile__form--title-article">Add Content</h2>
      <CategoryForm
        action="create"
        :formdata="formdata"
        :callback="newCategory"
      >
      </CategoryForm>
    </div>
  </div>
</template>
  
  <script>
import Header from '@/components/general/Header.vue'
import CategoryForm from '@/components/forms/CategoryForm.vue'
import Categories from '@/services/Categories'
import Swal from 'sweetalert2'
export default {
  components: { Header, CategoryForm },
  data() {
    return {
      formdata: {
        title: '',
        content: '',
        categories_id: {}
      }
    }
  },
  methods: {
    async newCategory() {
      try {
        const response = await Categories.addNewCategory(this.formdata)
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
          title: 'Category creation Successful'
        })
        this.$router.push({ name: 'my-profile' })
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Incomplete category details'
        })
      }
    }
  }
}
</script>
  