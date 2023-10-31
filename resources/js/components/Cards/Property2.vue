<template>
    <div class="card-sm card-2">
        <router-link :to="{ name: 'property.view', params: {slug: property.slug } }">
            <template v-if="property.thumbnail">
                <div class="thumb" :style="{ background: `url(/images/listings/${property.slug}/${property.thumbnail})` }" style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div class="thumb"></div>
            </template>
            <div class="details">
                <h2>{{ property.name }}</h2>
                <div v-if="property.sub_zone" class="location">
                    <span class="spec">{{ property.sub_zone.name }}, </span>
                    <span class="spec">{{ property.sub_zone.zone.county.name }}</span>
                </div>
                <p class="timestamp">Added {{ property.time_ago }}</p>
                <div class="info-rating-grp">
                    <p v-if="property.rating != 0" class="rating">Rating: {{ property.rating }}/5</p>
                    <p v-else class="rating">Rating: not rated</p>
                    <ComponentRatingStars :rating="property.rating" />
                </div>
            </div>
        </router-link>
    </div>
</template>

<script setup>
import ComponentRatingStars from '../Misc/RatingStars.vue';

const props = defineProps({
    property: Object,
})
</script>