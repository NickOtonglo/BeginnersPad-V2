<template>
    <div class="stars">
        <template v-if="rating >= 1">
            <i class="fas fa-star"></i>
        </template>
        <template v-else-if="rating >= 0.5 && rating < 1">
            <i class="fas fa-star-half-alt"></i>
        </template>
        <template v-else>
            <i class="far fa-star"></i>
        </template>

        <template v-if="rating >= 2">
            <i class="fas fa-star"></i>
        </template>
        <template v-else-if="rating >= 1.5 && rating < 2">
            <i class="fas fa-star-half-alt"></i>
        </template>
        <template v-else>
            <i class="far fa-star"></i>
        </template>

        <template v-if="rating >= 3">
            <i class="fas fa-star"></i>
        </template>
        <template v-else-if="rating >= 2.5 && rating < 3">
            <i class="fas fa-star-half-alt"></i>
        </template>
        <template v-else>
            <i class="far fa-star"></i>
        </template>

        <template v-if="rating >= 4">
            <i class="fas fa-star"></i>
        </template>
        <template v-else-if="rating >= 3.5 && rating < 4">
            <i class="fas fa-star-half-alt"></i>
        </template>
        <template v-else>
            <i class="far fa-star"></i>
        </template>

        <template v-if="rating >= 5">
            <i class="fas fa-star"></i>
        </template>
        <template v-else-if="rating >= 4.5 && rating < 5">
            <i class="fas fa-star-half-alt"></i>
        </template>
        <template v-else>
            <i class="far fa-star"></i>
        </template>
    </div>
</template>

<script setup>
const props = defineProps({
    rating: Number
})
</script>