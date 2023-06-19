<template>
    <ul id="navMenu" class="nav-menu authed">
        <div class="badge">
            <span class="badge-mark"></span>
            <li><router-link :to="{ name: '' }" href="/help"><i class="fas fa-question-circle"></i> Help</router-link></li>
        </div>
        <div class="badge">
            <span class="badge-mark">1</span>
            <li><router-link :to="{ name: 'users.account' }" href="/manage-account"><i class="fas fa-user-circle"></i> Account</router-link></li>
        </div>
        <div class="badge" id="navDrawerOpen">
            <span class="badge-mark">3</span>
            <li><i class="fas fa-bars"></i></li>
        </div>
    </ul>
</template>