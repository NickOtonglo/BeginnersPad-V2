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
        <div class="nav-drawer closed" id="navDrawer">
            <i id="navDrawerClose" class="fas fa-times fa-2x"></i>
            <div class="nav-drawer-category">
                <ul>
                    <li><a href="/help.html"><i class="fas fa-question-circle"></i> Help</a></li>
                    <li><a href="#"><i class="fas fa-user-circle"></i> Manage account</a></li>
                    <li><a href="#" @click="userLogin.logout"><i class="fas fa-sign-out-alt"></i> Sign out</a></li>
                </ul>
            </div>
            <NavDrawerAdmin v-if="user.role <= 'Admin'" />
            <NavDrawerLister v-if="user.role == 'Lister'" />
            <NavDrawerBeginner v-if="user.role == 'Beginner'" />
        </div>
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
import loginUser from '../composables/login'
import operateNavDrawer from '../composables/nav-drawer';
import { ref, onMounted, onBeforeMount } from 'vue';
import axios from 'axios';

const userLogin = loginUser()
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

onMounted(() => {
    operateNavDrawer()
})

</script>