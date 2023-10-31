<template>
    <router-link :to="{ name: 'unit.view', params: { slug: unit.parent_slug, unit_slug: unit.slug } }">
        <div v-if="unit.thumbnail" class="thumb" :style="{ background: `url(/images/listings/${unit.parent_slug}/${unit.slug}/${unit.thumbnail})` }" style="background-size: cover;"></div>
        <div v-else class="thumb" style="background-size: cover;"></div>
        <div class="details">
            <h3 class="txt-single-line">{{ unit.name }}</h3>
            <div class="specs">
                <span class="spec">{{ unit.bedrooms }} bed, </span>
                <span class="spec">{{ unit.bathrooms }} bath, </span>
                <span class="spec">{{ unit.floor_area }}sq M</span>
            </div>
            <div class="deposit">
                <span class="label">Initial deposit: </span>
                <span v-if="unit.init_deposit == 0" class="data">not required</span>
                <span v-else class="data">KES {{ unit.init_deposit }}</span>
            </div>
            <div class="price">
                <span class="label">KES </span>
                <span class="data">{{ unit.price }}</span>
            </div>
            <p class="timestamp">Added {{ unit.time_ago }}</p>
        </div>
    </router-link>
    <button v-if="closeable" @click="$emit('closed')" class="btn-link btn-close"><i class="fas fa-times"></i></button>
</template>

<script setup>
const props = defineProps({
    unit: Object,
    closeable: Boolean,
})
</script>