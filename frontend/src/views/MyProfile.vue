<template>
  <main>
    <ProfileHead>
      <RouterLink to="/edit-Profile" class="profile__details--link"
        >Edit Profile</RouterLink
      >
    </ProfileHead>
    <section class="section">
      <div class="section__inner">
        <section class="relatedList relatedList--home">
          <div class="relatedList__inner">
            <h2 class="relatedList__heading">
              <h3 class="relatedList__heading">My Articles</h3>
            </h2>
            <div class="relatedList__articles">
              <article class="articleCard__button">
                <RouterLink to="/add-article">
                  <div class="articleCard__imagebox--button">
                    <div class="articleCard__imagebox--button-img">
                      <img src="@/assets/images/addArticle.svg" />
                      <h4 class="articleCard__imagebox--button-text">
                        Add New Article
                      </h4>
                    </div>
                  </div>
                </RouterLink>
              </article>
              <ArticleCard
                v-for="article in articles"
                :key="article.id"
                :article="article"
              >
                <RouterLink
                  :to="{ name: 'edit-article', params: { slug: article.slug } }"
                >
                  <img
                    src="@/assets/images/editArticle.svg"
                    class="article__imagebox--edit-link"
                  />
                </RouterLink>
              </ArticleCard>
            </div>
            <div
              v-if="articles.length === 0"
              class="relatedList__articles--empty"
            >
              <h2>You have no articles!!</h2>
            </div>
          </div>
        </section>
      </div>
    </section>
  </main>
</template>
  
  <script>
import ProfileHead from '@/components/general/ProfileHead.vue'
import ArticleCard from '@/components/article/ArticleCard.vue'
import ArticleService from '@/services/ArticleService.js'
import { mapStores } from 'pinia'
import { useAuthStore } from '@/store/Auth'
import handleError from '@/helpers/handleError'
export default {
  components: {
    ArticleCard,
    ProfileHead
  },
  data() {
    return {
      articles: []
    }
  },
  computed: {
    ...mapStores(useAuthStore),
    user() {
      return this.authStore.user
    }
  },
  async created() {
    this.getUserArticles()
  },
  methods: {
    async getUserArticles() {
      const token = localStorage.getItem('token')

      if (!token) {
        this.$router.push('/')
      }
      try {
        const response = await ArticleService.userArticlebyId(this.user.id)
        this.articles = response.data.data
      } catch (error) {
        handleError(error)
      }
    }
  }
}
</script>
  