<template>
  <div class="section__categories">
    <ul class="section__categories-list">
      <li
        class="section__categories-item"
        v-for="category in categories"
        :key="category.slug"
      >
        <RouterLink
          :to="{ name: 'categoryArticles', params: { slug: category.slug } }"
          class="section__categories-link section__categories-link"
          :class="{
            'section__categories-link--active':
              category.slug === $route.params.slug
          }"
          >{{ category.name }}</RouterLink
        >
      </li>
      <li class="section__categories-item--last">
        <RouterLink
          :to="{ name: 'categoryArticles', params: { slug: 'all' } }"
          class="section__categories-link section__categories-link"
          :class="{
            'section__categories-link--active': 'all' === $route.params.slug
          }"
          >View All</RouterLink
        >
      </li>
    </ul>
  </div>
</template>
<script>
import Categories from '@/services/Categories'
import handleError from '@/helpers/handleError'

export default {
  data() {
    return {
      categories: []
    }
  },
  created() {
    Categories.all('created_at', 'desc', 3)
      .then((response) => {
        this.categories = response.data.data
      })
      .catch((error) => {
        handleError(error)
      })
  }
}
</script>
