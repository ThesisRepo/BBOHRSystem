<template>
  <div
  >
  <h1>dddf</h1>
  </div>
</template>
<script>
import { mixin as clickaway } from 'vue-clickaway';
export default {
  props: ['id'],
  mixins: [ clickaway ],
  data() {
    return {
      isDropdownActive: false,
    }
  },
  methods: {
    away() {
      this.isDropdownActive = false;
    }
  }
};
</script>
<style scoped>
div{
  position:absolute;
}
</style>