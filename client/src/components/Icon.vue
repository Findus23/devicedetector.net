<template>
    <img v-if="icon" :src="icon" :title="title"
         role="presentation" :alt="title" class="icon" width="48" height="48">
</template>
<script setup lang="ts">
import {  } from "vue";

defineProps<{
    icon?: string
    title?: string
}>();
</script>

<style lang="scss">
    .icon {
        width: 48px;
        height: 48px;
    }
</style>
