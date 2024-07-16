<template>
    <ul id="navMenu" class="nav-menu authed">
        <div class="badge">
            <span v-if="badges.help > 0" class="badge-mark">{{ badges.help }}</span>
            <li><router-link :to="{ name: 'help.index' }"><i class="fas fa-question-circle"></i> Help</router-link></li>
        </div>
        <div class="badge">
            <span v-if="badges.account > 0" class="badge-mark">{{ badges.account }}</span>
            <li><router-link :to="{ name: 'users.account' }" href="/manage-account"><i class="fas fa-user-circle"></i> Account</router-link></li>
        </div>
        <div @click="openDrawer" class="badge" id="navDrawerOpen">
            <span v-if="badges.chat > 0" class="badge-mark">{{ badges.chat }}</span>
            <li><i class="fas fa-bars"></i></li>
        </div>
    </ul>
</template>

<script setup>
const props = defineProps({
    badges: Object, 
    openDrawer: Function,
})
</script>