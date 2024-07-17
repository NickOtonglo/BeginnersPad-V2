<template>
    <div class="nav-drawer-category">
        <p>Menu</p>
        <ul>
            <li :class="route.meta.name == 'Dashboard' ? 'selected' : ''">
                <router-link :to="{ name: 'dashboard.index' }" @click="closeDrawer" href="/dashboard">Dashboard</router-link>
            </li>
            <li :class="route.meta.name == 'Listings' ? 'selected' : ''">
                <router-link :to="{ name: 'properties.index' }" @click="closeDrawer" href="/listings">Listings</router-link>
            </li>
            <li :class="route.meta.name == 'My listings' ? 'selected' : ''">
                <router-link :to="{ name: 'properties.mine' }" @click="closeDrawer" href="/listings/my-listings">My listings</router-link>
            </li>
            <li :class="route.meta.name == 'Favourites' ? 'selected' : ''">
                <router-link :to="{ name: 'favourites.index' }" @click="closeDrawer" href="/favourites">Favourites</router-link>
            </li>
            <li :class="route.meta.name == 'Tickets' ? 'selected' : ''">
                <router-link :to="{ name: 'tickets.list' }" @click="closeDrawer" href="/help/tickets">My tickets</router-link>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router';

const route = useRoute()
const router = useRouter()

const props = defineProps({
    closeDrawer: Function,
})
</script>