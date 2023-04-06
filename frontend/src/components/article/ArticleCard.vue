<template>
  <article class="articleCard">
    <div class="articleCard__imagebox">
      <RouterLink
        :to="{ name: 'article', params: { slug: article.slug } }"
        class="articleCard__imagebox-link"
      >
        <img
          :src="article.avatar_path"
          alt="alt for image"
          class="articleCard__image"
        />
      </RouterLink>
      <div class="articleCard__imagebox--top">
        <slot></slot>

        <Categories
          class="categoriesList--articleCard"
          :categories="article.categories"
        />
      </div>
      <div class="articleCard__content-text articleCard__content-text--related">
        <time class="articleCard__content-time">{{ dateFormatted }}</time>
        <h3 class="articleCard__content-title">
          <RouterLink
            :to="{ name: 'article', params: { slug: article.slug } }"
            class="
              articleCard__content-title-link
              articleCard__content-title-link--related
            "
            >{{ article.title }}</RouterLink
          >
        </h3>
        <p class="articleCard__content-desc">
          {{ shortContent }}
        </p>
      </div>
    </div>
  </article>
</template>

<script>
import Categories from '@/components/article/Categories.vue'
import ArticleCardMixin from '@/mixins/ArticleCardMixin'

export default {
  name: 'ArticleCardBig',
  components: {
    Categories
  },
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  mixins: [ArticleCardMixin]
}
</script>
     