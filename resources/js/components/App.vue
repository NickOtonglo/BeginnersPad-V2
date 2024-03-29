<template>
    <!-- Navbar -->
    <nav>
        <h1><router-link :to="{ name: 'app.home' }" href="/">Beginners Pad</router-link></h1>
        <i @click="toggleHiddenNav" id="navToggle" class="fas fa-bars fa-2x toggle"></i>
        <template v-if="userAuth.isAuthenticated.value">
            <NavbarAuth :badges="badges" />
        </template>
        <template v-else>
            <NavbarGuest ref="navGuestRef" />
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
                    <li>
                        <a href="/help">
                            <i class="fas fa-question-circle"></i>
                            <span v-if="badges.help > 0">({{ badges.help }}) Help</span>
                            <span v-else> Help</span>
                        </a>
                    </li>
                    <li>
                        <a href="/manage-account">
                            <i class="fas fa-user-circle"></i>
                            <span v-if="badges.account > 0">({{ badges.account }}) Manage account</span>
                            <span v-else> Manage account</span>
                        </a>
                    </li>
                    <li>
                        <a href="/chats">
                            <i class="fa-solid fa-comments"></i>
                            <span v-if="badges.chat > 0">({{ badges.chat }}) Conversations</span>
                            <span v-else> Conversations</span>
                        </a>
                    </li>
                    <li><a href="#" @click="userLogin.logout"><i class="fas fa-sign-out-alt"></i> Sign out</a></li>
                </ul>
            </div>
            <NavDrawerAdmin v-if="user.role == 'Admin' || user.role == 'Super Admin' || user.role == 'System Admin'" />
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
import notificationsMaster from '../composables/notifications'
import broadcastMaster from '../composables/broadcast'

const userLogin = loginUser()
const userAuth = checkAuth()
const user = ref({
    username: '',
    role: '',
})
const isUserFetched = ref(false)
const navGuestRef = ref(null)

const {
    badges, 
    getBadges, 
} = notificationsMaster()

const {
    broadcastNotifications
} = broadcastMaster()

function getUserData() {
    if (userAuth.isAuthenticated.value) {
        axios.get('/api/user')
            .then(response => user.value = response.data)
            .catch(error => console.log(error))
            .finally(isUserFetched.value = true)
    }
}

function getNotificationsData() {
    if (userAuth.isAuthenticated.value) {
        getBadges(`/api/notifications/badges`)
    }
}

function toggleHiddenNav () {
    if(userAuth.isAuthenticated.value) {
        console.log('open nav drawer')
    } else {
        console.log('unhide menu')
    }
}

onBeforeMount(() => {
    getUserData()
    getNotificationsData()
    broadcastNotifications(localStorage.getItem('user'))
})

onMounted(() => {
    operateNavDrawer()
})

</script>