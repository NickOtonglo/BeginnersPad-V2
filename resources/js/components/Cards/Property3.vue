<template>
    <router-link :to="{ name: 'property.view', params: { slug: property.slug } }">
        <div v-if="property.thumbnail" class="thumb" :style="{ background: `url(/images/listings/${property.slug}/${property.thumbnail})` }" style="background-size: cover;"></div>
        <div v-else class="thumb" style="background-size: cover;"></div>
        <div class="details">
            <h3 class="txt-single-line">{{ property.name }}</h3>
            <div class="location">
                <span class="spec">{{ property.sub_zone.name }}, </span>
                <span class="spec">{{ property.sub_zone.zone.name }}, </span>
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
    <button v-if="closeable" @click="$emit('closed')" class="btn-link btn-close"><i class="fas fa-times"></i></button>
</template>

<script setup>
const props = defineProps({
    property: Object,
    closeable: Boolean,
})
</script>