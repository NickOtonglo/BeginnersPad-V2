<template>
    <div class="nav-drawer closed" id="navDrawer">
        <i id="navDrawerClose" class="fas fa-times fa-2x"></i>
        <div class="nav-drawer-category">
            <ul>
                <li><a href="../help.html"><i class="fas fa-question-circle"></i> Help</a></li>
                <li><a href="#"><i class="fas fa-user-circle"></i> Manage account</a></li>
                <li><a href="../sign-in.html"><i class="fas fa-sign-out-alt"></i> Sign out</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>Menu</p>
            <ul>
                <li class="selected"><a href="/beginner/dashboard.html">Dashboard</a></li>
                <li><a href="/beginner/view-listings.html">Listings</a></li>
                <li><a href="/beginner/tour-appointments.html">Tour appointments</a></li>
                <li><a href="/beginner/my-reviews.html">My reviews</a></li>
                <li><a href="/beginner/favourites.html">Favourites</a></li>
                <li><a href="/beginner/property-history.html">Property history</a></li>
                <li><a href="/beginner/view-tickets.html">My tickets</a></li>
            </ul>
        </div>
        <div class="nav-drawer-category">
            <p>Premium</p>
            <ul>
                <li><a href="/beginner/waiting-list.html">Waiting list <i class="fas fa-star"></i></a></li>
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