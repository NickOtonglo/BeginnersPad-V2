<template>
    <div class="card">
        <router-link :to="{ name: 'property.view', params: {slug: property.slug } }">
            <template v-if="property.thumbnail">
                <div class="image" :style="{ background: `url(/images/listings/${property.slug}/${property.thumbnail})` }" style="background-size: cover;">
                    <template v-if="property.brand && property.brand.avatar">
                        <img :src="`/images/brand/avatar/${property.brand.username}/${property.brand.avatar}`" alt="">
                    </template>
                    <template v-else>
                        <img src="/images/static/avatar.png" alt="">
                    </template>
                </div>
            </template>
            <template v-else>
                <div class="image">
                    <img src="/images/static/avatar.png" alt="">
                </div>
            </template>
            <div class="card-info">
                <h4>{{ property.name }}</h4>
                <p class="location">Location: {{ property.sub_zone.name }}, {{ property.sub_zone.zone.county.name }}</p>
                <p class="type">Listing type: for rent</p>
                <p class="price">KES {{ property.window.rent_min }} - {{ property.window.rent_max }}</p>
                <p class="timestamp">Added {{ property.time_ago }}</p>
            </div>
        </router-link>
    </div>
</template>

<script setup>
const props = defineProps({
    property: Object,
})
</script>