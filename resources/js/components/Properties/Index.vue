<template>
    <section class="showcase-small">
        <div class="showcase-overlay">
            <div class="container">
                <div>
                    <h2>Property listings</h2>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cum ex corporis aut porro vitae nam iusto neque est</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-blank">
        
    </section>

    <!-- Search bar -->
    <section id="searchBar" ref="header">
        <div class="container">
            <form @submit.prevent="getPaginationDataWithRequest(1, 'properties', request)" class="search-bar">
                <div class="search-bar-grp">
                    <input v-model="search_global" type="text" class="search-input" placeholder="search...">
                    <div ref="btnClearSearch" v-show="search_global !== ''" @click="search_global = '', getPaginationDataWithRequest(1, 'properties', request)" class="search-button">
                        <i class="fas fa-xmark"></i>
                    </div>
                    <div @click="getPaginationDataWithRequest(1, 'properties', request)" class="search-button">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Listings -->
    <section class="section-listings">
        <div class="container">
            <div class="container-btn-dropdown">
                <select class="btn-dropdown" name="listing_sort" id="listing_sort">
                    <option value="" selected>Sort by newest</option>
                    <option value="">Sort by oldest</option>
                    <option value="">Sort by cheapest</option>
                    <option value="">Sort by priciest</option>
                    <option value="">Sort by largest area</option>
                    <option value="">Sort by most rooms</option>
                </select>
            </div>
            <div id="isLoading">
                <div v-show="isLoading" class="lds-dual-ring"></div>
                <span v-if="isLoading">Loading...</span>
            </div>
            <div class="cards">
                <template v-for="property in properties">
                    <div class="card">
                        <a href="/view-listing.html">
                            <div class="image">
                                <img src="images/logo.png" alt="">
                            </div>
                            <div class="card-info">
                                <h4>{{ property.name }}</h4>
                                <p class="location">Location: {{ property.sub_zone.name }} ({{ property.sub_zone.zone.county.name }})</p>
                                <p class="type">Listing type</p>
                                <p class="price">KES 1000 - 2000</p>
                                <p class="timestamp">Added {{ property.time_ago }}</p>
                            </div>
                        </a>
                    </div>
                </template>
            </div>
            <template v-if="!properties.length">
                <p style="text-align: center;">-no listings-</p>
            </template>
        </div>
        <Pagination :totalPages="total_pages"
                    :perPage="per_page"
                    :currentPage="current_page"
                    @pagechanged="onPageChange" />
    </section>
</template>

<script setup>
import { ref, onBeforeMount, watch } from 'vue'
import pagination from '../../composables/pagination'

const btnClearSearch = ref(null)

const { 
    search_global,
    total_pages,
    per_page,
    current_page,
    properties,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()
const request = ref(`/api/listings`)

onBeforeMount(() => {
    getPaginationDataWithRequest(current_page.value, 'properties', request.value)
})

watch(search_global, (current, previous) => {
    // To show instant results during search, uncomment the line below
    // getPaginationData(1, 'properties')
})

</script>