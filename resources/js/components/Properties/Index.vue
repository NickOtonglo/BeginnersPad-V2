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

    <SearchBar 
        @search-initiated="filterData" 
        @search-cancelled="filterData" />

    <!-- Listings -->
    <section class="section-listings">
        <div class="container">
            <div v-if="user.role == 'Admin' || user.role == 'Super Admin' || user.role == 'System Admin'" class="top-buttons">
                <div class="btn-grp horizontal">
                    <button 
                        @click="btnSelected='All', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}/status/all`)" 
                        :class="btnSelected == 'All' ? 'selected' : ''">All</button>
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
                    <select v-model="subZone.name" :hidden="!zone.name" @change="btnSelected = '', getPaginationDataWithRequest(1, 'properties', `/api/listings/sub-zone/${subZone.name}`)" class="btn-dropdown">
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
            <div class="cards">
                <template v-for="item in properties">
                    <CardProperty :property="item" />
                </template>
            </div>
            <template v-if="!properties.length">
                <p style="text-align: center;">-no listings-</p>
            </template>
        </div>
        <Pagination v-if="propertiesCount > 25" :totalPages="total_pages"
                    :perPage="per_page"
                    :currentPage="current_page"
                    @pagechanged="onPageChange" />
    </section>
</template>

<script setup>
import { ref, onBeforeMount, watch } from 'vue'
import pagination from '../../composables/pagination'
import userMaster from '../../composables/users'
import SearchBar from '../Search/SearchBar.vue'
import CardProperty from '../Cards/Property1.vue';
import zonesMaster from '../../composables/zones';
import subZonesMaster from '../../composables/subzones';

const request = ref(`/api/listings`)
// const btnSelected = ref('All')
const btnSelected = ref('')

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
const { user, getUserData } = userMaster() 
const { getZones, zones, zone } = zonesMaster()
const { getSubZones, subZones, subZone } = subZonesMaster()

function filterData(input) {
    zone.value.name = ''
    if (!input) {
        search_global.value = ''
        // btnSelected.value = 'All'
    } else {
        search_global.value = input
        // btnSelected.value = ''
    }
    if (user.value.role == 'Admin' || user.value.role == 'Super Admin' || user.value.role == 'System Admin') {
        getPaginationDataWithRequest(current_page.value, 'properties', `${request.value}/status/all`)
    } else {
        getPaginationDataWithRequest(current_page.value, 'properties', `${request.value}`)
    }
}

onBeforeMount(() => {
    getZones(`/api/zones`)
    filterData('')
    getUserData()
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