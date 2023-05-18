<template>
    <ul id="navMenu" class="nav-menu">
        <div class="badge">
            <span class="badge-mark"></span>
            <li><a href="help.html"><i class="fas fa-question-circle"></i> Help</a></li>
        </div>
        <div class="badge">
            <span class="badge-mark"></span>
            <li><router-link :to="{ name: 'auth.register' }" href="/sign-up"><i class="fas fa-user-plus"></i> Sign Up</router-link></li>
        </div>
        <div class="badge">
            <span class="badge-mark"></span>
            <li><router-link :to="{ name: 'auth.login' }" href="/sign-in"><i class="fas fa-sign-in-alt"></i> Sign In</router-link></li>
        </div>
    </ul>
</template>