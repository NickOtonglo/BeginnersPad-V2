<template>
    <div class="details">
        <div class="header">
            <div>
                <h2 class="name">{{ property.brand.name }}</h2>
                <p class="timestamp">Joined on {{ property.brand.created_at }}</p>
            </div>
            <template v-if="property.brand.avatar">
                <img :src="'/images/brand/avatar/' + property.brand.username + '/' + property.brand.avatar" alt="">
            </template>
            <template v-else>
                <img src="/images/static/avatar.png" alt="">
            </template>
        </div>
        <p class="listings-count">{{ property.brand.properties_count }} listings posted</p>
        <div class="info-rating-grp">
            <p v-if="property.brand.rating != 0" class="rating">Rating: {{ property.brand.rating }}/5</p>
            <p v-else class="rating">Rating: not rated</p>
            <ComponentRatingStars v-if="property.brand.rating" :rating="property.brand.rating" />
        </div>
        <div class="section-more">
            <router-link v-if="user.username === property.user_name" :to="{ name: 'users.account' }">Manage brand <i class="fas fa-chevron-right"></i></router-link>
        </div>
    </div>
</template>

<script setup>
import ComponentRatingStars from '../Misc/RatingStars.vue'
const props = defineProps({
    property: Object,
    user: Object
})
</script>