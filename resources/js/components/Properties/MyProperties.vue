<template>
    <div class="fab-container">
        <button @click="click" id="modalTrigger" class="fab btn-primary"><i class="fas fa-plus"></i> Add listing</button>
    </div>

    <SearchBar 
        @search-initiated="filterData" 
        @search-cancelled="filterData" />

    <section class="section-listings" id="sectionMyListings">
        <div class="container">
            <div class="top-buttons">
                <div class="btn-grp horizontal">
                    <button 
                        @click="btnSelected='All', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/all`)" 
                        :class="btnSelected == 'All' ? 'selected' : ''">All</button>
                    <button 
                        @click="btnSelected='Unpublished', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/unpublished`)" 
                        :class="btnSelected == 'Unpublished' ? 'selected' : ''">Not submitted</button>
                    <button 
                        @click="btnSelected='Pending', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/pending`)" 
                        :class="btnSelected == 'Pending' ? 'selected' : ''">Pending</button>
                    <button 
                        @click="btnSelected='Published', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/published`)" 
                        :class="btnSelected == 'Published' ? 'selected' : ''">Published</button>
                    <button 
                        @click="btnSelected='Rejected', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/rejected`)" 
                        :class="btnSelected == 'Rejected' ? 'selected' : ''">Rejected</button>
                    <button 
                        @click="btnSelected='Suspended', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/suspended`)" 
                        :class="btnSelected == 'Suspended' ? 'selected' : ''">Suspended</button>
                    <button 
                        @click="btnSelected='Hidden', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/private`)" 
                        :class="btnSelected == 'Hidden' ? 'selected' : ''">Hidden/Private</button>
                </div>
                <div class="btn-grp vertical">
                    <button 
                        @click="btnSelected='All', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/all`)" 
                        :class="btnSelected == 'All' ? 'selected' : ''">All</button>
                    <button 
                        @click="btnSelected='Unpublished', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/unpublished`)" 
                        :class="btnSelected == 'Unpublished' ? 'selected' : ''">Not submitted</button>
                    <button 
                        @click="btnSelected='Pending', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/pending`)" 
                        :class="btnSelected == 'Pending' ? 'selected' : ''">Pending</button>
                    <button 
                        @click="btnSelected='Published', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/published`)" 
                        :class="btnSelected == 'Published' ? 'selected' : ''">Published</button>
                    <button 
                        @click="btnSelected='Rejected', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/rejected`)" 
                        :class="btnSelected == 'Rejected' ? 'selected' : ''">Rejected</button>
                    <button 
                        @click="btnSelected='Suspended', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/suspended`)" 
                        :class="btnSelected == 'Suspended' ? 'selected' : ''">Suspended</button>
                    <button 
                        @click="btnSelected='Hidden', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/private`)" 
                        :class="btnSelected == 'Hidden' ? 'selected' : ''">Hidden/Private</button>
                </div>
            </div>
            <div class="container-btn-dropdown multi">
                <div class="container-btn-dropdown" id="dropdown-zones">
                    <select v-model="zone.name" @change="getSubZones(`/api/zones/${zone.name}/sub-zones`)" class="btn-dropdown">
                        <option value="" disabled>--select zone--</option>
                        <template v-for="zone in zones">
                            <option :value="zone.id">{{ zone.name }} ({{ zone.county.name }})</option>
                        </template>
                    </select>
                    <select v-model="subZone.name" :hidden="!zone.name" @change="btnSelected = '', getPaginationDataWithRequest(1, 'properties', `${request}/sub-zone/${subZone.name}`)" class="btn-dropdown">
                        <option value="" disabled>--select sub-zone--</option>
                        <template v-for="subZone in subZones">
                            <option :value="subZone.id">{{ subZone.name }}</option>
                        </template>
                    </select>
                </div>
                <select v-model="filter_sort" @change="btnSelected = '', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}`)" class="btn-dropdown">
                    <option value="">Sort by default</option>
                    <option value="desc">Sort by newest</option>
                    <option value="asc">Sort by oldest</option>
                </select>
            </div>
            <div id="isLoading">
                <div v-show="isLoading" class="lds-dual-ring"></div>
                <span v-if="isLoading">Loading...</span>
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
import SearchBar from '../Search/SearchBar.vue'
import CreateProperty from '../Modals/CreateProperty.vue';
import operateModal from '../../composables/modal'
import CardProperty from '../Cards/Property2.vue';
import userMaster from '../../composables/users'
import zonesMaster from '../../composables/zones';
import subZonesMaster from '../../composables/subzones';

const { user, getUserData } = userMaster() 
const { getZones, zones, zone } = zonesMaster()
const { getSubZones, subZones, subZone } = subZonesMaster()

const btnClearSearch = ref(null)
const childComponentRef = ref(null);

const { 
    search_global,
    filter_sort,
    total_pages,
    per_page,
    current_page,
    properties,
    propertiesCount,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()
// const request = ref(`/api/listings/my-listings`)
const request = ref(`/api/listings/my-listings`)

function click() {
    childComponentRef.value.openModal();
}

function filterData(input) {
    zone.value.name = ''
    if (!input) {
        search_global.value = ''
        // btnSelected.value = 'All'
    } else {
        search_global.value = input
        // btnSelected.value = ''
    }
    getPaginationDataWithRequest(current_page.value, 'properties', `${request.value}`)
}

onBeforeMount(() => {
    // getPaginationDataWithRequest(current_page.value, 'properties', request.value)
    getZones(`/api/zones`)
    filterData('')
    getUserData()
})

onMounted(() => {
    operateModal(document.querySelector('#modal'))
})

watch(search_global, (current, previous) => {
    // To show instant results during search, uncomment the line below
    // getPaginationData(1, 'properties')
})

</script>

<style scoped>
.container-btn-dropdown#dropdown-zones {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
}
</style>