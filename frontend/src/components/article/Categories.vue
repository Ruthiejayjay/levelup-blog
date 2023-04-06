<template>
  <ul class="categoriesList">
    <li
      class="categoryList__item"
      v-for="category in categories"
      :key="category.id"
    >
      <RouterLink
        :to="{ name: 'categoryArticles', params: { slug: category.slug } }"
        class="categoryList__item-link"
        >{{ category.name }}</RouterLink
      >
    </li>
  </ul>
</template>
    <script>
export default {
  name: 'Categories',
  props: {
    categories: {
      type: Array,
      required: true
    }
  }
}
</script>
    