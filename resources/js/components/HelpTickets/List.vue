<template>
    <MyTickets v-if="user.role == 'Beginner' || user.role == 'Lister' || user.role == 'Unset'" />
    <Manage v-if="user.role == 'Admin' || user.role == 'Super Admin' || user.role == 'System Admin'" :user="user" />
</template>

<script setup>
import MyTickets from './MyTickets.vue';
import Manage from './Manage.vue';
import userMaster from '../../composables/users';
import { onBeforeMount, onBeforeUpdate } from 'vue';

const { user, getUserData, route } = userMaster()

onBeforeMount(() => {
    getUserData()
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})
</script>