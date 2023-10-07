<template>
    <section class="section-listing-reviews" id="sectionMyReviews">
        <div class="container">
            <div class="listing-reviews">
                <h3 class="section-title">My reviews</h3>
                <!-- <div v-show="isLoading" class="lds-dual-ring"></div> -->
                <div v-if="reviews" class="reviews-list">
                    <div v-for="review in reviews" class="review-item">
                        <h4>{{ review.property.name }}</h4>
                        <ComponentRatingStars :rating="review.rating" />
                        <p class="time">{{ review.time_ago }}</p>
                        <h3 class="occupant">{{ user.username }} (verified occupant)</h3>
                        <p class="review">{{ review.review }}</p>
                        <router-link :to="{ name: 'review.view', params: { slug: review.property.slug } }" class="link">Manage <i class="fas fa-chevron-right"></i></router-link>
                    </div>
                </div>
                <template v-if="!reviews.length">
                    <p style="text-align: center;">-no reviews-</p>
                </template>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import propertyReviewsMaster from '../../composables/property_reviews';
import userMaster from '../../composables/users'
import ComponentRatingStars from '../Misc/RatingStars.vue'

const { getReviews, reviews, isLoading } = propertyReviewsMaster()
const { getUserData, user } = userMaster()

onBeforeMount(() => {
    getReviews(`/api/reviews`)
    getUserData()
})
</script>