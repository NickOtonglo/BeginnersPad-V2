<template>
    <div class="card">
        <router-link :to="{ name: 'unit.view', params: { slug: property.slug, unit_slug: unit.slug } }">
            <template v-if="property.thumbnail">
                <div class="image" :style="{ background: `url(/images/listings/${property.slug}/${unit.slug}/${unit.thumbnail})` }" style="background-size: cover;">
                    <template v-if="property.brand && property.brand.avatar">
                        <img :src="`/images/brand/avatar/${property.brand.username}/${property.brand.avatar}`" alt="">
                    </template>
                </div>
            </template>
            <template v-else>
                <div class="image" :style="{ background: `url(/images/static/thumb_default.jpg` }" style="background-size: cover;">
                    <template v-if="property.brand && property.brand.avatar">
                        <img :src="`/images/brand/avatar/${property.brand.username}/${property.brand.avatar}`" alt="">
                    </template>
                </div>
            </template>
            <div class="card-info">
                <p>{{ unit.bedrooms }} bed | {{ unit.bathrooms }} bath | {{ unit.floor_area }}sq M</p>
                <h4>{{ unit.name }}, {{ property.name }}</h4>
                <p class="location">Location: {{ property.sub_zone.name }}, {{ property.sub_zone.zone.county.name }}</p>
                <p class="price">KES {{ unit.price }}</p>
                <p class="timestamp">Added {{ unit.time_ago }}</p>
            </div>
        </router-link>
    </div>
</template>

<script setup>
const props = defineProps({
    property: Object,
    unit: Object,
})
</script>