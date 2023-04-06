<template>
  <main>
    <article class="mainArticle">
      <div class="aboutArticle__inner">
        <ul class="mainArticle__categories">
          <li
            class="mainArticle__category"
            v-for="category in article.categories"
            :key="category.id"
          >
            <RouterLink
              :to="{
                name: 'categoryArticles',
                params: { slug: category.slug }
              }"
              class="mainArticle__category-link"
              >{{ category.name }}</RouterLink
            >
          </li>
        </ul>
        <h2 class="mainArticle__heading">
          <a href="#" class="mainArticle__heading-link">
            {{ article.title }}
          </a>
        </h2>
        <span class="mainArticle__sub-text" v-if="article.author">
          {{ article.author.name }}
        </span>
      </div>
    </article>
    <section class="section">
      <div class="section__inner">
        <div class="sectionArticle">
          <div class="sectionArticle__time">
            <span>{{ dateFormatted }}</span>
            <span class="mainArticle__content-divider"></span>
          </div>
          <div class="sectionArticle__content">
            <p v-html="article.content"></p>

            <ul class="aboutArticle__categories">
              <li
                class="aboutArticle__category"
                v-for="category in article.categories"
                :key="category.id"
              >
                <RouterLink
                  :to="{
                    name: 'categoryArticles',
                    params: { slug: category.slug }
                  }"
                  class="aboutArticle__category-link"
                  >{{ category.name }}</RouterLink
                >
              </li>
            </ul>
            <reactionsVue :model="article" />
            <div class="sectionArticle__Author">
              <div class="blog__content-author">
                <div>
                  <img
                    class="author__image"
                    :src="article.author.avatar_path"
                    alt="Author"
                  />
                </div>
                <div class="author__details">
                  <h4 class="author__heading">
                    {{ article.author.name }}
                  </h4>
                </div>
              </div>
            </div>
            <div class="comments">
              <div class="comments__heading">
                <h2>Comments:</h2>
              </div>
              <form class="comments__form" @submit.prevent="newComment">
                <div>
                  <img
                    :src="article.author.avatar_path"
                    alt="Author"
                    class="comments__contents-img"
                  />
                </div>
                <div class="comments__contents-input">
                  <input
                    type="text"
                    class="input"
                    placeholder="Write a comment"
                    v-model="formdata.content"
                  />
                  <button type="submit" class="btn__comment">Send</button>
                </div>
              </form>
            </div>
            <div class="article__comment" v-if="comments.length">
              <ArticleComment
                v-for="comment in comments"
                :key="comment.id"
                :comment="comment"
              />
            </div>
            <div v-else>
              <p>No comments yet.</p>
            </div>
          </div>
          <div class="sectionArticle-empty"></div>
        </div>

        <section class="relatedList relatedList--home">
          <div class="relatedList__inner">
            <h2 class="relatedList__heading">
              <h3 class="relatedList__heading">Related Articles</h3>
            </h2>
            <div class="relatedList__articles">
              <ArticleCard
                v-for="article in articles"
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
import ArticleCard from '@/components/article/ArticleCard.vue'
import reactionsVue from '@/components/general/reactions.vue'
import ArticleComment from '@/components/article/ArticleComment.vue'
import ArticleService from '@/services/ArticleService'
import Comments from '@/services/Comments'
import ArticleCardMixin from '@/mixins/ArticleCardMixin'
import handleError from '@/helpers/handleError'
import { mapStores } from 'pinia'
import { useAuthStore } from '@/store/Auth'
import { useModalStore } from '@/store/Modal'
import Swal from 'sweetalert2'
export default {
  components: {
    ArticleCard,
    reactionsVue,
    ArticleComment
  },
  mixins: [ArticleCardMixin],

  data() {
    return {
      articles: [],
      article: {},
      comments: [],
      formdata: {
        content: null
      }
    }
  },

  computed: {
    ...mapStores(useAuthStore, useModalStore),

    user() {
      return this.authStore.user
    }
  },

  async created() {
    const response = await ArticleService.show(this.$route.params.slug)
    this.article = response.data

    ArticleService.all('created_at', 'desc', 3)
      .then((response) => {
        this.articles = response.data.data
      })
      .catch((error) => {
        handleError(error)
      })

    Comments.getArticlesComments(this.$route.params.slug)
      .then((response) => {
        this.comments = response.data
      })
      .catch((error) => {
        handleError(error)
      })
  },
  methods: {
    async newComment() {
      if (!Object.keys(this.user).length) {
        this.modalStore.openModal('Login')
        return
      }
      try {
        const response = await Comments.addNewComment(
          this.$route.params.slug,
          this.formdata
        )
        console.log({ comments: response.data })

        this.comments = [response.data, ...this.comments]
        this.formdata.content = ''

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
          title: 'Comments added successfully'
        })
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Incomplete comment details'
        })
      }
    }
  }
}
</script>
  