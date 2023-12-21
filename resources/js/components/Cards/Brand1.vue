<template>
    <div class="details">
        <div class="header">
            <div>
                <h2 class="name">{{ brand.name }}</h2>
                <p class="timestamp">Joined on {{ brand.created_at }}</p>
            </div>
            <template v-if="brand.avatar">
                <img :src="'/images/brand/avatar/' + brand.username + '/' + brand.avatar" alt="">
            </template>
            <template v-else>
                <img src="/images/static/avatar.png" alt="">
            </template>
        </div>
        <p class="listings-count">{{ brand.properties_count }} listings posted</p>
        <div class="info-rating-grp">
            <p v-if="brand.rating != 0" class="rating">Rating: {{ brand.rating }}/5</p>
            <p v-else class="rating">Rating: not rated</p>
            <ComponentRatingStars v-if="brand.rating" :rating="brand.rating" />
        </div>
        <div v-if="sectionMore" class="section-more">
            <router-link v-if="user.username === brand.username" :to="{ name: 'users.account' }">Manage brand <i class="fas fa-chevron-right"></i></router-link>
        </div>
    </div>
</template>

<script setup>
import ComponentRatingStars from '../Misc/RatingStars.vue'
const props = defineProps({
    brand: Object,
    user: Object,
    sectionMore: Boolean,
})
</script>