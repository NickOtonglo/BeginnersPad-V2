<template>
    <div class="nav-drawer closed" id="navDrawer">
        <i id="navDrawerClose" class="fas fa-times fa-2x"></i>
        <div class="nav-drawer-category">
            <ul>
                <li><a href="/help.html"><i class="fas fa-question-circle"></i> Help</a></li>
                <li><a href="#"><i class="fas fa-user-circle"></i> Manage account</a></li>
                <li><a href="/sign-in.html"><i class="fas fa-sign-out-alt"></i> Sign out</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>Menu</p>
            <ul>
                <li class="selected"><a href="/lister/dashboard.html">Dashboard</a></li>
                <li><a href="/view-listings.html">Listings</a></li>
                <li><a href="/lister/my-listings.html">My listings</a></li>
                <li><a href="/lister/favourites.html">Favourites</a></li>
                <li><a href="/lister/view-beginner-applications.html">Beginner applications</a></li>
                <li><a href="/lister/view-property-applications.html">My listing applications</a></li>
                <li><a href="/lister/view-tickets.html">My tickets</a></li>
                <li><a href="/lister/banned-users.html">Banned users</a></li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import operateNavDrawer from '../../composables/nav-drawer';

onMounted(() => {
    operateNavDrawer()
})

</script>