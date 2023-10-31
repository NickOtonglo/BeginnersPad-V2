<template>
    <template v-if="clickable">
        <router-link :to="{ name: 'user.manage', params: { username: user.username } }">
            <div class="card-user">
                <h4 class="title">User profile</h4>
                <div class="details">
                    <template v-if="user.avatar">
                        <img :src="'/images/user/avatar/' + user.username + '/' + user.avatar" alt="">
                    </template>
                    <template v-else>
                        <img src="/images/static/avatar.png" alt="">
                    </template>
                    <div class="text">
                        <h3 class="name">{{ user.firstname }} {{ user.lastname }}</h3>
                        <h4 class="username">@{{ user.username }}</h4>
                        <p class="account">Account: <span>{{ user.role }}</span></p>
                        <p class="time">Account status: <span>{{ user.status }}</span></p>
                    </div>
                </div>
            </div>
        </router-link>
    </template>
    <template v-else>
        <div class="card-user">
            <h4 class="title">User profile</h4>
            <div class="details">
                <template v-if="user.avatar">
                    <img :src="'/images/user/avatar/' + user.username + '/' + user.avatar" alt="">
                </template>
                <template v-else>
                    <img src="/images/static/avatar.png" alt="">
                </template>
                <div class="text">
                    <h3 class="name">{{ user.firstname }} {{ user.lastname }}</h3>
                    <h4 class="username">@{{ user.username }}</h4>
                    <p class="account">Account: <span>{{ user.role }}</span></p>
                    <p class="time">Status: <span>{{ user.status }}</span></p>
                </div>
            </div>
        </div>
    </template>
</template>

<script setup>
const props = defineProps({
    user: Object,
    clickable: Boolean,
})
</script>

<style scoped>
.card-user {
    cursor: pointer;
}
a:link {
    text-decoration: none!important;
    font-weight: normal;
}
</style>