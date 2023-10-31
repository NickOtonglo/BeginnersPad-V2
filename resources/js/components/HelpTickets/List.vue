<template>
    <MyTickets v-if="user.role == 'Beginner' || user.role == 'Lister' || user.role == 'Unset'" />
    <Manage v-if="user.role == 'Admin' || user.role == 'Super Admin' || user.role == 'System Admin'" :user="user" />
</template>

<script setup>
import MyTickets from './MyTickets.vue';
import Manage from './Manage.vue';
import userMaster from '../../composables/users';
import { onBeforeMount } from 'vue';

const { user, getUserData } = userMaster()

onBeforeMount(() => {
    getUserData()
})
</script>