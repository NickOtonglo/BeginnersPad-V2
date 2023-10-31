<template>
    <div class="fab-container">
        <button @click="click" id="modalTrigger" class="fab btn-primary"><i class="fas fa-plus"></i> Add listing</button>
    </div>

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

    <section class="section-listings" id="sectionMyListings">
        <div class="container">
            <div class="top-buttons">
                <div class="btn-grp horizontal">
                    <button class="selected">All</button>
                    <button>Not submitted</button>
                    <button>Pending</button>
                    <button>Approved</button>
                    <button>Rejected</button>
                    <button>Suspended</button>
                    <button>Hidden/Private</button>
                </div>
                <div class="btn-grp vertical">
                    <button class="selected">All</button>
                    <button>Not submitted</button>
                    <button>Pending</button>
                    <button>Approved</button>
                    <button>Rejected</button>
                    <button>Suspended</button>
                    <button>Hidden/Private</button>
                </div>
            </div>
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
            <div class="listing-units-list">
                <div class="listing-units-grp">
                    <template v-for="property in properties">
                        <CardProperty :property="property" />
                    </template>
                </div>
                <template v-if="!properties.length">
                    <p style="text-align: center;">-no listings-</p>
                </template>
            </div>
        </div>
        <Pagination :totalPages="total_pages"
                    :perPage="per_page"
                    :currentPage="current_page"
                    @pagechanged="onPageChange" />
    </section>

    <CreateProperty ref="childComponentRef" />
</template>

<script setup>
import { ref, onBeforeMount, watch, onMounted } from 'vue'
import pagination from '../../composables/pagination'
import CreateProperty from '../Modals/CreateProperty.vue';
import operateModal from '../../composables/modal'
import CardProperty from '../Cards/Property2.vue';

const btnClearSearch = ref(null)
const childComponentRef = ref(null);

const { 
    search_global,
    total_pages,
    per_page,
    current_page,
    properties,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()
const request = ref(`/api/listings/my-listings`)

function click() {
    childComponentRef.value.openModal();
}

onBeforeMount(() => {
    getPaginationDataWithRequest(current_page.value, 'properties', request.value)
})

onMounted(() => {
    operateModal(document.querySelector('#modal'))
})

watch(search_global, (current, previous) => {
    // To show instant results during search, uncomment the line below
    // getPaginationData(1, 'properties')
})

</script>