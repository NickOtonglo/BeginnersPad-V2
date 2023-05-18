<template>
    <!-- Navbar -->
    <nav>
        <h1><a href="index.html">Beginners Pad</a></h1>
        <i id="navToggle" class="fas fa-bars fa-2x toggle"></i>
        <NavbarGuest />
    </nav>

    <router-view></router-view>
</template>

<script setup>
import NavbarAuth from './Navbar/Authenticated.vue'
import NavbarGuest from './Navbar/Guest.vue'
</script>