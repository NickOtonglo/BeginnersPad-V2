<template>
    <section class="section-listing-info-header">
        <div class="container">
            <div class="header-grp">
                <div :style="{ background: `url(/images/listings/${property.slug}/${property.thumbnail})` }"
                    style="background-size: cover;" class="thumb"></div>
                <div class="details">
                    <h3 class="txt-single-line">{{ property.name }}</h3>
                    <div v-if="property.sub_zone" class="location txt-single-line">
                        <span class="spec">{{ property.sub_zone.name }}, </span>
                        <span class="spec">{{ property.sub_zone.zone.name }}, </span>
                        <span class="spec">{{ property.sub_zone.zone.county.name }}</span>
                    </div>
                    <p class="timestamp">Added on {{ property.timestamp }}</p>
                    <div class="info-rating-grp">
                        <p v-if="property.rating != 0" class="rating">Rating: {{ property.rating }}/5</p>
                        <p v-else class="rating">Rating: not rated</p>
                        <ComponentRatingStars :rating="property.rating" />
                    </div>
                    <div class="section-more">
                        <router-link :to="{ name: 'property.view', params: { slug: property.slug } }"><i
                                class="fas fa-chevron-left"></i> View listing</router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-listing-reviews">
        <div class="container">
            <div class="listing-reviews">
                <h3>Reviews</h3>
                <div v-for="(item) in reviews" class="reviews-list">
                    <div class="review-item">
                        <ComponentRatingStars :rating="item.rating" />
                        <p class="time">{{ item.time_ago }}</p>
                        <h3 v-if="review && item.id == review.id" @click="click(editReviewRef)" class="occupant active">
                            {{ user.username }} (me) - tap to edit</h3>
                        <h3 v-else class="occupant">Verified occupant</h3>
                        <p class="review">{{ item.review }}</p>
                        <div v-if="user.role === 'Admin' || user.role === 'Super Admin' || user.role === 'System Admin'"
                            class="remove-review">
                            <span @click="review = item, click(removeReviewRef)">Remove <i class="fas fa-chevron-right"></i></span>
                        </div>
                    </div>
                </div>
                <p v-if="!reviews.length" style="text-align: center;">- no reviews -</p>
            </div>
        </div>
    </section>

    <EditReview v-if="review" ref="editReviewRef" :review="review" />
    <RemoveReview :review="review" ref="removeReviewRef" />
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import propertiesMaster from '../../composables/properties';
import propertyReviewsMaster from '../../composables/property_reviews';
import userMaster from '../../composables/users'
import EditReview from '../Modals/EditReview.vue';
import RemoveReview from '../Modals/RemoveReview.vue';
import ComponentRatingStars from '../Misc/RatingStars.vue'

const { 
    property, 
    route, 
    getProperty,
} = propertiesMaster()

const { reviews, review, getReviews, getMyReview } = propertyReviewsMaster()
const { getUserData, user } = userMaster()

const editReviewRef = ref(null)
const removeReviewRef = ref(null)

onBeforeMount(() => {
    getProperty(`/api/listings/${route.params.slug}`)
    getReviews(`/api/listings/${route.params.slug}/reviews`)
    getMyReview(`/api/listings/${route.params.slug}/reviews`)
    getUserData()
})

function click(element) {
    element.openModal();
}

</script>

<style scoped>
.section-listing-reviews .reviews-list {
    border-bottom: 1px dashed #666;
}
.section-listing-reviews .reviews-list:last-child {
    border-bottom: none;
}
.occupant.active {
    cursor: pointer;
}
.occupant.active:hover {
    color: var(--color-primary);
}
.remove-review {
    text-align: right;
}

.remove-review span {
    cursor: pointer;
}

.remove-review span:hover {
    font-weight: bold;
    text-decoration: underline;
}
</style>