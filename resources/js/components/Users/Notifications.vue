<template>
    <section class="section-read">
        <div class="container">
            <div id="isLoading">
                <div v-show="isLoading" class="lds-dual-ring"></div>
                <span v-if="isLoading">Loading...</span>
            </div>
            <div class="list anchor-no-text-decoration">
                <h3 class="section-title">Notifications</h3>
                <template v-for="(notification, index) in notifications">
                    <router-link 
                        @click="setNotificationToRead(`/api/notifications/key/${notification.id}`), notification.read = 1"
                        v-if="notification.dest && !isNaN(+notification.dest_link)" 
                        :to="notification.dest_link ? { name: notification.dest, params: { id: notification.dest_link } } : { name: notification.dest }"
                        class="data-2 link" :class="notification.read == 0 ? 'bold' : ''">
                        <div class="text">
                            <h5>{{ notification.time_ago }}</h5>
                            <h4>{{ notification.title }}</h4>
                            <p>{{ notification.body }}</p>
                        </div>
                    </router-link>
                    <router-link 
                        @click="setNotificationToRead(`/api/notifications/key/${notification.id}`), notification.read = 1"
                        v-if="notification.dest && isNaN(+notification.dest_link)" 
                        :to="notification.dest_link ? { name: notification.dest, params: { slug: notification.dest_link } } : { name: notification.dest }"
                        class="data-2 link" :class="notification.read == 0 ? 'bold' : ''">
                        <div class="text">
                            <h5>{{ notification.time_ago }}</h5>
                            <h4>{{ notification.title }}</h4>
                            <p>{{ notification.body }}</p>
                        </div>
                    </router-link>
                    <div @click="setNotificationToRead(`/api/notifications/key/${notification.id}`), notification.read = 1" 
                        v-if="!notification.dest" class="data-2 link" :class="notification.read == 0 ? 'bold' : ''">
                        <div class="text">
                            <h5>{{ notification.time_ago }}</h5>
                            <h4>{{ notification.title }}</h4>
                            <p>{{ notification.body }}</p>
                        </div>
                    </div>
                </template>
            </div>
            <template v-if="!notifications.length">
                <p style="text-align: center;">-no notifications-</p>
            </template>
            <!-- <Pagination :totalPages="total_pages" :perPage="per_page" :currentPage="current_page"
                @pagechanged="onPageChange" /> -->
        </div>
    </section>
</template>
<script setup>
import { onBeforeUpdate, onMounted, ref } from 'vue';
import notificationsMaster from '../../composables/notifications';
import userMaster from '../../composables/users';

const {
    notifications, 
    getNotifications, 
    setNotificationToRead, 
} = notificationsMaster()
const { route } = userMaster()

onMounted(() => {
    getNotifications(`/api/notifications`)
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})
</script>