<script setup></script>

<template>
  <main>
    <MainArticle v-if="featuredArticle" :article="featuredArticle" />
    <section class="section">
      <div class="section__inner">
        <h2 class="section__heading">Popular topics</h2>
        <CategoriesList />
        <div class="section__blogs">
          <ArticleComponent
            v-for="article in articlesPopularTopics"
            :key="article.id"
            :article="article"
          />
        </div>
        <section class="relatedList relatedList--home">
          <div class="relatedList__inner">
            <h2 class="relatedList__heading">
              <h3 class="relatedList__heading">Editor’s Pick</h3>
            </h2>
            <div class="relatedList__articles">
              <ArticleCard
                v-for="article in articlesEditorsPick"
                :key="article.id"
                :article="article"
              />
            </div>
          </div>
        </section>
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

export default {
  components: {
    MainArticle,
    ArticleComponent,
    ArticleCard,
    CategoriesList
  },

  data() {
    return {
      articlesPopularTopics: [],
      articlesEditorsPick: []
    }
  },
  computed: {
    featuredArticle() {
      if (this.articlesPopularTopics.length) {
        return this.articlesPopularTopics[0]
      } else {
        return null
      }
    }
  },
  created() {
    ArticleService.all('created_at', 'desc', 8)
      .then((response) => {
        this.articlesPopularTopics = response.data.data
      })
      .catch((error) => {
        handleError(error)
      })
    ArticleService.all('created_at', 'desc', 3)
      .then((response) => {
        this.articlesEditorsPick = response.data.data
      })
      .catch((error) => {
        handleError(error)
      })
  }
}
</script>
