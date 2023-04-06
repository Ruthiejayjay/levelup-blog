<template>
  <div>
    <Form :handleCallback="callback" v-slot="slotProps" :data="formdata">
      <Input
        v-model="formdata.title"
        name="title"
        placeholder="Set Title"
        type="text"
        required="true"
        label="Title"
      />

      <AppButton type="submit" :isLoading="slotProps.isLoading">
        <span v-if="action === 'create'">Publish category</span>
        <span v-else>Update category</span>
      </AppButton>
    </Form>
  </div>
</template>
    
  <script>
import Form from '@/components/general/Form.vue'
import TextArea from '@/components/general/TextArea.vue'
import Input from '@/components/general/Input.vue'
import AppButton from '@/components/general/AppButton.vue'
export default {
  components: {
    Form,
    Input,
    AppButton,
    TextArea
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
  }
}
</script>
  