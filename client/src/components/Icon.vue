<template>
    <img v-if="icon" :src="icon" :title="title"
         role="presentation" :alt="title" class="icon" width="48" height="48">
</template>
<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  props: {
    icon: {
      type: String
    },
    title: {
      type: String
    }
  },
  // props: ["icon", "title"],
  name: "Icon"
});
</script>

<style lang="scss">
    .icon {
        width: 48px;
        height: 48px;
    }
</style>
