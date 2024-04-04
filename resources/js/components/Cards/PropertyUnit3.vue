<template>
    <div class="card">
        <router-link :to="{ name: 'unit.view', params: { slug: unit.property.slug, unit_slug: unit.slug } }">
            <template v-if="unit.property.thumbnail">
                <div class="image" :style="{ background: `url(/images/listings/${unit.property.slug}/${unit.slug}/${unit.thumbnail})` }" style="background-size: cover;">
                    <template v-if="unit.property.brand && unit.property.brand.avatar">
                        <img :src="`/images/brand/avatar/${unit.property.brand.username}/${unit.property.brand.avatar}`" alt="">
                    </template>
                    <template v-else>
                        <img src="/images/static/avatar.png" alt="">
                    </template>
                </div>
            </template>
            <template v-else>
                <div class="image" :style="{ background: `url(/images/static/thumb_default.jpg` }" style="background-size: cover;">
                    <template v-if="unit.property.brand && unit.property.brand.avatar">
                        <img :src="`/images/brand/avatar/${unit.property.brand.username}/${unit.property.brand.avatar}`" alt="">
                    </template>
                    <template v-else>
                        <img src="/images/static/avatar.png" alt="">
                    </template>
                </div>
            </template>
            <div class="card-info">
                <p>{{ unit.bedrooms }} bed | {{ unit.bathrooms }} bath | {{ unit.floor_area }}sq M</p>
                <h4>{{ unit.name }}, {{ unit.property.name }}</h4>
                <p class="location">Location: {{ unit.property.sub_zone.name }}, {{ unit.property.sub_zone.zone.county.name }}</p>
                <p class="price">KES {{ unit.price }}</p>
                <p class="timestamp">Added {{ unit.time_ago }}</p>
            </div>
        </router-link>
    </div>
</template>

<script setup>
const props = defineProps({
    // property: Object,
    unit: Object,
})
</script>