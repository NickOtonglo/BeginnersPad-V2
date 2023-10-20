<template>
    <ViewUser v-if="user.role == 'Beginner' || user.role == 'Lister'" :user="user" />
    <ViewAdmin v-if="user.role == 'Admin' || user.role == 'Super Admin' || user.role == 'System Admin'" :user="user" />
</template>

<script setup>
import ViewUser from './ViewUser.vue';
import ViewAdmin from './ViewAdmin.vue';
import userMaster from '../../composables/users';
import { onBeforeMount } from 'vue';

const { user, getUserData } = userMaster()

onBeforeMount(() => {
    getUserData()
})
</script>