<template></template>

<script>
import { onBeforeUpdate } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute()

onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})
</script>