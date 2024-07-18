<template>
    <div class="nav-drawer-category">
        <p>Menu</p>
        <ul>
            <li :class="route.meta.name == 'Dashboard' ? 'selected' : ''">
                <router-link :to="{ name: 'dashboard.index' }" @click="closeDrawer" href="/dashboard">Dashboard</router-link>
            </li>
            <li :class="route.meta.name == 'Favourites' ? 'selected' : ''">
                <router-link :to="{ name: 'favourites.index' }" @click="closeDrawer" href="/favourites">Favourites</router-link>
            </li>
        </ul>
    </div>
    <div class="nav-drawer-category">
        <p>Listings</p>
        <ul>
            <li :class="route.meta.name == 'Listings' ? 'selected' : ''">
                <router-link :to="{ name: 'properties.index' }" @click="closeDrawer" href="/listings">Manage</router-link>
            </li>
            <li :class="route.meta.name == 'Listings logs' ? 'selected' : ''">
                <router-link :to="{ name: 'properties.logs' }" @click="closeDrawer" href="/listings/logs">Management logs</router-link>
            </li>
            <li :class="route.meta.name == 'Review logs' ? 'selected' : ''">
                <router-link :to="{ name: 'reviews.logs' }" @click="closeDrawer" href="/reviews/listings/logs">Review removal logs</router-link>
            </li>
        </ul>
    </div>
    <div class="nav-drawer-category">
        <p>Users</p>
        <ul>
            <li :class="route.meta.name == 'Users' ? 'selected' : ''">
                <router-link :to="{ name: 'users.index' }" @click="closeDrawer" href="/users">Manage</router-link>
            </li>
            <li :class="route.meta.name == 'User logs' ? 'selected' : ''">
                <router-link :to="{ name: 'users.logs' }" @click="closeDrawer" href="/users/logs">Logs</router-link>
            </li>
        </ul>
    </div>
    <div class="nav-drawer-category">
        <p>Zones</p>
        <ul>
            <li :class="route.meta.name == 'Zones' ? 'selected' : ''">
                <router-link :to="{ name: 'zones.index' }" @click="closeDrawer" href="/zones">Manage</router-link>
            </li>
        </ul>
    </div>
    <div class="nav-drawer-category">
        <p>Tags & articles</p>
        <ul>
            <li :class="route.meta.name == 'Articles' ? 'selected' : ''">
                <router-link :to="{ name: 'articles.index' }" @click="closeDrawer" href="/articles">View articles</router-link>
            </li>
            <li :class="route.meta.name == 'My articles' ? 'selected' : ''">
                <router-link :to="{ name: 'articles.mine' }" @click="closeDrawer" href="/articles/my-articles/manage">My articles</router-link>
            </li>
            <li :class="route.meta.name == 'Tags' ? 'selected' : ''">
                <router-link :to="{ name: 'tags.index' }" @click="closeDrawer" href="/tags">Manage tags</router-link>
            </li>
        </ul>
    </div>
    <div class="nav-drawer-category">
        <p>Help & tickets</p>
        <ul>
            <li :class="route.meta.name == 'Tickets' ? 'selected' : ''">
                <router-link :to="{ name: 'tickets.list' }" @click="closeDrawer" href="/help/tickets">View tickets</router-link>
            </li>
            <li :class="route.meta.name == 'Help FAQs' ? 'selected' : ''">
                <router-link :to="{ name: 'help.faq' }" @click="closeDrawer" href="/help/faq">Manage FAQs</router-link>
            </li>
        </ul>
    </div>
    <div class="nav-drawer-category">
        <p>System</p>
        <ul>
            <li><a href="#">Manage</a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="#">System logs</a></li>
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