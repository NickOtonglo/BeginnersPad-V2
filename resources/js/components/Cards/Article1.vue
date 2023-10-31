<template>
    <router-link :to="{ name: 'article.view', params: { slug: article.slug } }">
        <h3 class="title-main txt-single-line">{{ article.title}}</h3>
        <p class="text-main txt-six-line">{{ article.preview }}</p>
    </router-link>
    <button v-if="closeable" @click="$emit('closed')" class="btn-link btn-close"><i class="fas fa-times"></i></button>
</template>

<script setup>
const props = defineProps({
    article: Object,
    closeable: Boolean,
})
</script>