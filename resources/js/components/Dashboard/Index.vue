<template>
    <section class="section-dash">
        <!-- Dashboard navbar -->
        <NavDashBeginner v-if="user && user.role == 'Beginner'" />
        <NavDashLister v-if="user && user.role == 'Lister'" />
        <NavDashAdmin v-if="user && user.role == 'Admin' || user && user.role == 'Super Admin' || user && user.role == 'System Admin'" />

        <div class="container">
            <div class="dash-grp" id="dashProfile">
                <h5 class="grp-label">Profile</h5>
                    <div class="profile">
                        <div class="profile-1">
                            <UserAvatar :user="user" />
                            <p>Welcome to your dashboard, <span>{{ user.username }}</span>!</p>
                        </div>
                        <div class="profile-2">
                            <p>Your basic info:</p>
                            <ul>
                                <li>Name: <span class="name">{{ user.firstname }} {{ user.lastname }}</span></li>
                                <li>Email address: <span class="name">{{ user.email }}</span></li>
                                <li>Type: <span class="name">{{ user.role }}</span></li>
                                <li>Phone number: <span class="name">{{ user.telephone }}</span></li>
                            </ul>
                            <div>
                                <router-link :to="{ name: 'users.account' }" class="edit">Edit details <i class="fas fa-chevron-right"></i></router-link>
                            </div>
                            <button class="btn-link share">Share your account <i class="fas fa-share-alt"></i></button>
                        </div>
                    </div>
            </div>
            <DashBeginner v-if="user && user.role == 'Beginner'" :data="data" />
            <DashLister v-if="user && user.role == 'Lister'" :data="data" />
            <DashAdmin v-if="user && user.role == 'Admin' || user && user.role == 'Super Admin' || user && user.role == 'System Admin'" :data="data"  />
        </div>
    </section>
</template>

<script setup>
import { onBeforeUpdate, onMounted } from 'vue';
import UserAvatar from '../Misc/UserAvatar.vue';
import userMaster from '../../composables/users';
import DashBeginner from '../Dashboard/Beginner.vue'
import DashLister from '../Dashboard/Lister.vue'
import DashAdmin from '../Dashboard/Admin.vue'
import dashboardMaster from '../../composables/dashboard';
import NavDashBeginner from '../Navbar/DashBeginner.vue'
import NavDashLister from '../Navbar/DashLister.vue'
import NavDashAdmin from '../Navbar/DashAdmin.vue'

const {
    route, 
    user, 
    getUserAccount, 
} = userMaster()

const {
    isLoading, 
    data, 
    getData, 
} = dashboardMaster()

onMounted(() => {
    getUserAccount()
    getData()
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})
</script>