<script setup></script>

<template>
  <main>
    <MainArticle v-if="featuredArticle" :article="featuredArticle" />
    <section class="section">
      <div class="section__inner">
        <h2 class="section__heading">Popular topics</h2>
        <CategoriesList />
        <div class="section__blogs" v-if="articles.data.length">
          <ArticleComponent
            v-for="article in articles.data"
            :key="article.id"
            :article="article"
          />
        </div>
        <div class="section__blogs" v-else>
          <p>No articles found</p>
        </div>
        <InfiniteLoading
          v-if="this.isLastPage === false"
          @infinite="loadArticles"
        />
      </div>
    </section>
  </main>
</template>

<script>
import ArticleComponent from '@/components/article/ArticleComponent.vue'
import MainArticle from '@/components/article/MainArticle.vue'
import ArticleCard from '@/components/article/ArticleCard.vue'
import CategoriesList from '@/components/general/CategoriesList.vue'
import ArticleService from '@/services/ArticleService'
import handleError from '@/helpers/handleError'
import InfiniteLoading from 'v3-infinite-loading'
import 'v3-infinite-loading/lib/style.css'

export default {
  components: {
    MainArticle,
    ArticleCard,
    ArticleComponent,
    CategoriesList,
    InfiniteLoading
  },

  data() {
    return {
      articles: {
        data: []
      },
      isLoading: false
    }
  },
  computed: {
    featuredArticle() {
      if (this.articles.data.length) {
        return this.articles.data[0]
      } else {
        return {}
      }
    },

    isLastPage() {
      return this.articles.current_page === this.articles.last_page
    }
  },
  async created() {
    this.isLoading = true
    try {
      const response = await ArticleService.all(
        'created_at',
        'desc',
        8,
        1,
        this.getCategorySlug()
      )
      this.articles = response.data
    } catch (error) {
      handleError(error)
    }
  },
  methods: {
    async loadArticles() {
      this.isLoading
      if (this.isLastPage) {
        return
      }

      try {
        const response = await ArticleService.all(
          'created_at',
          'desc',
          8,
          this.articles.current_page + 1,
          this.getCategorySlug()
        )
        this.articles.data = this.articles.data.concat(response.data.data)
        this.articles.current_page = response.data.current_page
        this.articles.last_page = response.data.last_page
      } catch (error) {
        handleError(error)
      }
    },
    getCategorySlug() {
      let categorySlug = this.$route.params.slug
      if (this.$route.params.slug === 'all') {
        categorySlug = null
      }

      return categorySlug
    }
  }
}
</script>
