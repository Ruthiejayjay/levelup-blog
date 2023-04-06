<template>
  <article class="mainArticle">
    <div class="mainArticle__inner">
      <ul class="mainArticle__categories">
        <li
          class="mainArticle__category"
          v-for="category in article.categories"
          :key="category.id"
        >
          <RouterLink
            :to="{ name: 'categoryArticles', params: { slug: category.slug } }"
            class="mainArticle__category-link"
            >{{ category.name }}</RouterLink
          >
        </li>
      </ul>
      <h2 class="mainArticle__heading">
        <RouterLink
          :to="{ name: 'article', params: { slug: article.slug } }"
          class="mainArticle__heading-link"
        >
          {{ article.title }}
        </RouterLink>
      </h2>
      <p class="mainArticle__content">
        <time class="mainArticle__content-time">{{ dateFormatted }}</time>
        <span></span>
        <span class="mainArticle__content-text">{{ shortContent }} </span>
      </p>
    </div>
  </article>
</template>
<script>
import { parseISO, format } from 'date-fns'
import ArticleCardMixin from '@/mixins/ArticleCardMixin'
export default {
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  mixins: [ArticleCardMixin]
}
</script>