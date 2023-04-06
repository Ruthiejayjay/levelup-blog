<template>
  <article class="blog">
    <div class="blogCard__imagebox">
      <RouterLink
        :to="{ name: 'article', params: { slug: article.slug } }"
        class="bolgCard__image-link"
      >
        <img :src="article.avatar_path" alt="Title" class="blogCard__image" />
      </RouterLink>
      <Categories
        class="categoriesList--articleCard"
        :categories="article.categories"
      />
    </div>
    <div class="blog__content">
      <div class="blog__date">{{ dateFormatted }}</div>
      <h3 class="blog__heading">
        {{ article.title }}
      </h3>
      <p class="blog__text">
        {{ shortContent }}
      </p>
      <div class="blog__content-author">
        <div class="author__image">
          <img
            :src="article.author.avatar_path"
            alt="Author"
            class="blog__author"
          />
        </div>
        <div class="author__details">
          <h4 class="author__heading">{{ article.author.name }}</h4>
          <p>Thinker & Designer</p>
        </div>
      </div>
    </div>
  </article>
</template>
    
    <script>
import Categories from '@/components/article/Categories.vue'
import ArticleCardMixin from '@/mixins/ArticleCardMixin'
export default {
  name: 'Article',
  components: {
    Categories
  },
  mixins: [ArticleCardMixin],
  props: {
    article: {
      type: Object,
      required: true
    }
  }
}
</script>
    
    