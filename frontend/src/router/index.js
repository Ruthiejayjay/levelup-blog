import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Article from '../views/Article.vue'
import MyProfile from '../views/MyProfile.vue'
import EditProfile from '../views/EditProfile.vue'
import AddArticle from '../views/AddArticle.vue'
import EditArticle from '../views/EditArticle.vue'
import AddCategory from '../views/AddCategory.vue'
import EditCategory from '../views/EditCategory.vue'
import CategoryArticlesView from '../views/CategoryArticlesView.vue'
import { useAuthStore } from '../store/Auth'
import { useModalStore } from '../store/Modal'
import Auth from '@/services/Auth.js'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/article/:slug',
      name: 'article',
      component: Article
    },
    {
      path: '/my-profile',
      name: 'my-profile',
      component: MyProfile,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/edit-profile',
      name: 'edit-profile',
      component: EditProfile,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/add-article',
      name: 'add-article',
      component: AddArticle,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/edit-article/:slug',
      name: 'edit-article',
      component: EditArticle,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/add-category',
      name: 'add-category',
      component: AddCategory,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/edit-category/:slug',
      name: 'edit-category',
      component: EditCategory,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/category/:slug',
      name: 'categoryArticles',
      component: CategoryArticlesView
    },
  ]
})

router.beforeEach(async (to) => {
  const authStore = useAuthStore()
  const modalStore = useModalStore()

  if (localStorage.getItem('token') !== null && authStore.isGuest) {
    try {
      const response = await Auth.me()
      authStore.setUser(response.data)
    } catch (error) {
    }
  }
  if (to.meta.requiresAuth && authStore.isGuest) {
    modalStore.openModal('login')
    return {
      name: 'home'
    }
  }


})

export default router
