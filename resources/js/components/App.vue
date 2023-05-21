<template>
    <!-- Navbar -->
    <nav>
        <h1><router-link :to="{ name: 'app.home' }" href="/">Beginners Pad</router-link></h1>
        <i id="navToggle" class="fas fa-bars fa-2x toggle"></i>
        <NavbarGuest />
    </nav>

    <router-view></router-view>
</template>

<script setup>
import NavbarAuth from './Navbar/Authenticated.vue'
import NavbarGuest from './Navbar/Guest.vue'
</script>