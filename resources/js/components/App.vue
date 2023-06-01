<template>
    <!-- Navbar -->
    <nav>
        <h1><router-link :to="{ name: 'app.home' }" href="/">Beginners Pad</router-link></h1>
        <i id="navToggle" class="fas fa-bars fa-2x toggle"></i>
        <template v-if="userAuth.isAuthenticated.value">
            <NavbarAuth />
        </template>
        <template v-else>
            <NavbarGuest />
        </template>
    </nav>

    <!-- Filler -->
    <div id="pageFiller"></div>

    <!-- Nav drawer -->
    <template v-if="isUserFetched">
        <NavDrawerAdmin v-if="user.role <= 'Admin'" />
        <NavDrawerLister v-if="user.role == 'Lister'" />
        <NavDrawerBeginner v-if="user.role == 'Beginner'" />
    </template>
    <!-- beginner -->
    <!-- lister -->
    <!-- admin -->

    <router-view></router-view>
</template>

<script setup>
import NavbarAuth from './Navbar/Authenticated.vue'
import NavbarGuest from './Navbar/Guest.vue'
import NavDrawerAdmin from './NavDrawer/Admin.vue'
import NavDrawerLister from './NavDrawer/Lister.vue'
import NavDrawerBeginner from './NavDrawer/Beginner.vue'
import checkAuth from '../composables/checkAuth';
import { ref, reactive, onMounted, onBeforeMount } from 'vue';
import axios from 'axios';

const userAuth = checkAuth()
const user = ref({
    username: '',
    role: '',
})
const isUserFetched = ref(false)

function getUserData() {
    if (userAuth.isAuthenticated.value) {
        axios.get('/api/user')
            .then(response => user.value = response.data)
            .catch(error => console.log(error))
            .finally(isUserFetched.value = true)
    }
}

onBeforeMount(() => {
    getUserData()
})

</script>