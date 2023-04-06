<template>
  <div class="comments__contents">
    <div class="comments__contents-img">
      <img
        :src="comment.author.avatar_path"
        alt="Author"
        class="blog__author"
      />
    </div>
    <div class="comments__contents-content">
      <h4 class="comments__contents-author">{{ comment.author.name }}</h4>
      <p class="comments__contents-time">{{ dateFormatted }}</p>
      <p class="comments__contents-para">
        {{ comment.content }}
      </p>
      <reactionsVue :model="comment" />
    </div>
  </div>
</template>
<script>
import reactionsVue from '../general/reactions.vue'
import CommentCardMixin from '../../mixins/CommentCardMixin'
export default {
  components: {
    reactionsVue
  },
  props: {
    comment: {
      type: Object,
      required: true
    }
  },
  mixins: [CommentCardMixin]
}
</script>