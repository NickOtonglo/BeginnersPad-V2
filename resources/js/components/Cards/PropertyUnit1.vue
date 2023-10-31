<template>
    <div class="card-sm card-unit">
        <router-link :to="{ name: 'unit.view', params: { slug: property.slug, unit_slug: unit.slug } }">
            <div class="details">
                <h2>{{ unit.name }}</h2>
                <div class="specs">
                    <span class="spec">{{ unit.bedrooms }} bed | </span>
                    <span class="spec">{{ unit.bathrooms }} bath | </span>
                    <span class="spec">{{ unit.floor_area }}sq M</span>
                </div>
                <div class="deposit">
                    <span class="label">Initial deposit: </span>
                    <span v-if="unit.init_deposit == 0" class="data">not required</span>
                    <span v-else class="data">KES {{ unit.init_deposit }} ({{ unit.init_deposit_period }} months)</span>
                </div>
                <div class="price">
                    <span class="label">KES </span>
                    <span class="data">{{ unit.price }}</span>
                </div>
                <p class="timestamp">Added {{ unit.time_ago }}</p>
            </div>
            <template v-if="unit.thumbnail">
                <div class="thumb"
                    :style="{ background: `url(/images/listings/${property.slug}/${unit.slug}/${unit.thumbnail})` }"
                    style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div class="thumb" :style="{ background: `url(/images/static/thumb_default.jpg` }"
                    style="background-size: cover;"></div>
            </template>
        </router-link>
    </div>
</template>

<script setup>
const props = defineProps({
    property: Object,
    unit: Object,
})
</script>