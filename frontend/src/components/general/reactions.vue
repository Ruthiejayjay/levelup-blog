<template>
  <div class="reactions">
    <div class="reaction">
      <div class="tooltip">Like</div>
      <span class="reaction__span"
        ><i class="fa-regular fa-2x fa-thumbs-up"></i
      ></span>
    </div>
    <div class="reaction">
      <div class="tooltip">Love</div>
      <span class="reaction__span"
        ><i class="fa-regular fa-2x fa-heart"></i
      ></span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    model: {
      type: Object,
      required: true
    },
    reactions: {
      type: Array,
      required: false,
      default: []
    }
  }
}
</script>

<style>
</style>