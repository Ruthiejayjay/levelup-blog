<template>
  <div>
    <Header>
      <h2 class="profile__details--name">{{ category.title }}</h2>
      <div class="profile__details--divider"></div>
      <RouterLink to="/my-Profile" class="profile__details--link"
        >Back to Profile</RouterLink
      >
    </Header>
    <div class="profile__form">
      <h2 class="profile__form--title-article">Edit Content</h2>
      <CategoryForm
        action="edit"
        :formdata="formdata"
        :callback="handleUpdateCategory"
      >
      </CategoryForm>
    </div>
  </div>
</template>
  
  <script>
import Header from '@/components/general/Header.vue'
import Categories from '@/services/Categories'
import CategoryForm from '@/components/forms/CategoryForm.vue'
import Swal from 'sweetalert2'
export default {
  components: {
    Header,
    CategoryForm
  },
  data() {
    return {
      category: {},
      formdata: {
        title: '',
        content: ''
      }
    }
  },
  async created() {
    const response = await Categories.show(this.$route.params.slug)
    this.category = response.data
    Object.keys(this.formdata).forEach((key) => {
      this.formdata[key] = this.category[key]
    })
  },
  methods: {
    async updateCategory() {
      await Categories.handleUpdateCategory(this.category.slug, this.formdata)
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
        title: 'Category Update Successful'
      })
      this.$router.push({ name: 'my-profile' })
    }
  }
}
</script>
  