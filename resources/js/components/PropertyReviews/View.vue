<template>
    <section class="section-listing-info-header">
        <div class="container">
            <div class="header-grp">
                <div :style="{ background: `url(/images/listings/${property.slug}/${property.thumbnail})` }" style="background-size: cover;" class="thumb"></div>
                <div class="details">
                    <h3 class="txt-single-line">{{ property.name }}</h3>
                    <div v-if="property.sub_zone" class="location txt-single-line">
                        <span class="spec">{{ property.sub_zone.name }}, </span>
                        <span class="spec">{{ property.sub_zone.zone.name }}, </span>
                        <span class="spec">{{ property.sub_zone.zone.county.name }}</span>
                    </div>
                    <p class="timestamp">Added on {{ property.timestamp }}</p>
                    <div class="info-rating-grp">
                        <p class="rating">Rating: {{ property.rating }}/5</p>
                        <ComponentRatingStars :rating="property.rating" />
                    </div>
                    <div class="section-more">
                        <router-link :to="{ name: 'property.view', params: { slug: property.slug } }"><i class="fas fa-chevron-left"></i> View listing</router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-listing-reviews" id="sectionMyReview">
        <div class="container">
            <div class="listing-reviews">
                <h3>My Review</h3>
                <div class="reviews-list">
                    <div class="review-item">
                        <p class="time">{{ review.time_ago }}</p>
                        <h3 class="occupant">{{ user.username }} (verified occupant)</h3>
                        <p class="reveiw">{{ review.review }}</p>
                        <div class="info-rating-grp">
                            <p class="rating">Your rating: {{ review.rating }}/5</p>
                            <ComponentRatingStars :rating="review.rating" />
                        </div>
                        <button @click="click(editReviewRef)" class="btn-link">Edit this review</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <EditReview v-if="review" ref="editReviewRef" :review="review" />
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import propertiesMaster from '../../composables/properties';
import propertyReviewsMaster from '../../composables/property_reviews';
import userMaster from '../../composables/users'
import EditReview from '../Modals/EditReview.vue';
import ComponentRatingStars from '../Misc/RatingStars.vue'
import { onBeforeUpdate } from 'vue';

const { 
    property, 
    route, 
    getProperty,
} = propertiesMaster()

const { review, getMyReview } = propertyReviewsMaster()
const { getUserData, user } = userMaster()

const editReviewRef = ref(null)

onBeforeMount(() => {
    getProperty(`/api/listings/${route.params.slug}`)
    getMyReview(`/api/listings/${route.params.slug}/reviews`)
    getUserData()
})
onBeforeUpdate(() => {
    document.title = property.value.name+' - '+route.meta.name+' | '+localStorage.getItem('title')
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
</style>