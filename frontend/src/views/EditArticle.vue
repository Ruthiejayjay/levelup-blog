<template>
  <div>
    <Header>
      <h2 class="profile__details--name">{{ article.title }}</h2>
      <div class="profile__details--divider"></div>
      <RouterLink to="/my-Profile" class="profile__details--link"
        >Back to Profile</RouterLink
      >
    </Header>
    <div class="profile__form">
      <h2 class="profile__form--title-article">Edit Content</h2>
      <ArticleForm
        action="edit"
        :formdata="formdata"
        :callback="updateArticleContents"
      >
        <Input
          name="image"
          placeholder="Set Image"
          type="file"
          label="Image"
          @change="onFileSelected"
          required="false"
        />

        <h4>Categories:</h4>

        <ul class="aboutArticle__categories">
          <li
            class="aboutArticle__category"
            v-for="category in article.categories"
            :key="category.id"
          >
            <AppButton
              class="aboutArticle__category-link"
              @click.prevent="detachCategory(category.id)"
            >
              {{ category.name }} <i class="fa-solid fa-minus"></i>
            </AppButton>
          </li>
          <div v-if="article.categories && article.categories.length === 0">
            <p>Add a category</p>
          </div>
        </ul>
      </ArticleForm>
    </div>
  </div>
</template>

<script>
import Header from '@/components/general/Header.vue'
import ArticleService from '@/services/ArticleService'
import Input from '@/components/general/Input.vue'
import ArticleForm from '@/components/forms/ArticleForm.vue'
import Categories from '@/components/article/Categories.vue'
import AppButton from '@/components/general/AppButton.vue'
import Swal from 'sweetalert2'
export default {
  components: {
    Header,
    ArticleForm,
    Input,
    Categories,
    AppButton
  },
  data() {
    return {
      article: {},
      isLoading: false,
      formdata: {
        title: '',
        content: undefined,
        categories_id: [],
        image: ''
      }
    }
  },
  async created() {
    const response = await ArticleService.show(this.$route.params.slug)
    this.article = response.data
    Object.keys(this.formdata).forEach((key) => {
      this.formdata[key] = this.article[key]
    })
  },
  methods: {
    onFileSelected(event) {
      this.formdata.image = event.target.files[0]
    },
    async updateArticleContents() {
      await ArticleService.handleUpdateArticleWithImage(
        this.article.slug,
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
        title: 'Article Update Successful'
      })
      this.$router.push({ name: 'my-profile' })
    },
    async detachCategory(category_id) {
      try {
        this.article.categories = this.article.categories.filter(
          (category) => category.id !== category_id
        )
        const response = await ArticleService.removeCategory(
          this.$route.params.slug,
          category_id
        )
        this.article = response.data
      } catch (error) {}
    }
  }
}
</script>

