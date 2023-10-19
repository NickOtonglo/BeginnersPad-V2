<template>
    <section id="searchBar">
        <div class="container">
            <form @submit.prevent="$emit('searchInitiated', input)" class="search-bar">
                <div class="search-bar-grp">
                    <input v-model="input" type="text" class="search-input" placeholder="search...">
                    <div v-show="input !== ''" @click="input = '', $emit('searchCancelled')" class="search-button">
                        <i class="fas fa-xmark"></i>
                    </div>
                    <div @click="$emit('searchInitiated', input)" class="search-button">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
        </div>
        <div v-if="categoriesList" class="categories-grp">
            <template v-for="(item, index) in categoriesList">
                <div :class="categorySelected == item.name ? 'selected' : ''" class="category">
                    <button @click="$emit('categorySelected', item.name)">{{ item.name }}</button>
                </div>
            </template>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';

const input = ref('')
const props = defineProps({
    categoriesList: Array,
    categorySelected: String,
})
</script>

<style scoped>
.categories-grp {
    padding: 3px;
}
</style>