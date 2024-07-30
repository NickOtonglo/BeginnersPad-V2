<template>
    <template v-if="user.avatar">
        <img :src="'/images/user/avatar/' + user.username + '/' + user.avatar" alt="">
    </template>
    <template v-else>
        <img src="/images/static/avatar.png" alt="">
    </template>
</template>

<script setup>
const props = defineProps({
    user: Object,
})
</script>