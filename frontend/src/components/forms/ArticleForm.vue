<template>
  <div>
    <Form :handleCallback="callback" v-slot="slotProps" :data="formdata">
      <slot></slot>
      <label for="" class="article__selector">Category:</label>
      <Multiselect
        v-model="formdata.categories_id"
        :options="options"
        select="option"
        mode="tags"
        valueProp="id"
        label="name"
      />
      <Input
        v-model="formdata.title"
        name="title"
        placeholder="Set Title"
        type="text"
        required="true"
        label="Title"
      />

      <QuillEditor
        v-if="formdata.content !== undefined"
        v-model:content="formdata.content"
        contentType="html"
        theme="snow"
      />

      <AppButton type="submit" :isLoading="slotProps.isLoading">
        <span v-if="action === 'create'">Publish article</span>
        <span v-else>Update article</span>
      </AppButton>
    </Form>
  </div>
</template>
  
<script>
import Form from '@/components/general/Form.vue'
import TextArea from '@/components/general/TextArea.vue'
import Input from '@/components/general/Input.vue'
import AppButton from '@/components/general/AppButton.vue'
import { QuillEditor } from '@vueup/vue-quill'
import Multiselect from '@vueform/multiselect'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import Categories from '@/services/Categories.js'
export default {
  components: {
    Form,
    Input,
    AppButton,
    TextArea,
    QuillEditor,
    Multiselect
  },
  data() {
    return {
      categories: null,
      options: []
    }
  },

  props: {
    action: {
      type: String,
      default: 'create'
    },
    formdata: {
      type: Object,
      required: true
    },
    callback: {
      type: Function,
      required: true
    }
  },
  async created() {
    const response = await Categories.all()
    this.options = response.data.data
  }
}
</script>
<style src="@vueform/multiselect/themes/default.css">
</style>
