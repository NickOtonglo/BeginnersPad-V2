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
            <li :class="route.meta.name == 'My reviews' ? 'selected' : ''">
                <router-link :to="{ name: 'reviews.mine' }" @click="closeDrawer" href="/reviews">My reviews</router-link>
            </li>
            <li :class="route.meta.name == 'Favourites' ? 'selected' : ''">
                <router-link :to="{ name: 'favourites.index' }" @click="closeDrawer" href="/favourites">Favourites</router-link>
            </li>
            <li :class="route.meta.name == 'Tickets' ? 'selected' : ''">
                <router-link :to="{ name: 'tickets.list' }" @click="closeDrawer" href="/help/tickets">My tickets</router-link>
            </li>
        </ul>
    </div>
    <div class="nav-drawer-category">
        <p>Premium</p>
        <ul>
            <li :class="route.meta.name == 'Waiting list' ? 'selected' : ''">
                <router-link :to="{ name: 'waiting-list.index' }"  @click="closeDrawer" href="/premium/waiting-list">
                    <i class="fas fa-star"></i> Waiting list</router-link>
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