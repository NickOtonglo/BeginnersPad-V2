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
    </section>
</template>

<script setup>
import { ref } from 'vue';

const input = ref('')
</script>