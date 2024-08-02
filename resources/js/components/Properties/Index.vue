<template>
    <section class="showcase-small">
        <div class="showcase-overlay">
            <div class="container">
                <div>
                    <h2>Property listings</h2>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cum ex corporis aut porro vitae nam
                        iusto neque est</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-blank">

    </section>

    <SearchBar @search-initiated="filterData" @search-cancelled="filterData" />

    <!-- Listings -->
    <section class="section-listings">
        <div class="container">
            <div v-if="user.role == 'Admin' || user.role == 'Super Admin' || user.role == 'System Admin'"
                class="top-buttons">
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
                </div>
            </div>
            <div class="top-buttons">
                <div class="btn-grp horizontal">
                    <button
                        @click="
                            filterDataIsProperties = true, 
                            getPaginationDataWithRequest(1, 'properties', `${request}`)"
                        :class="filterDataIsProperties ? 'selected' : ''">Properties</button>
                    <button
                        @click="
                            filterDataIsProperties = false, 
                            preFilterUnits(search_global, subZone.name, [['bed', 0], ['bath', 0], ['area', 0], ['price_min', 0], ['price_max', 0]])"
                        :class="!filterDataIsProperties ? 'selected' : ''">Units</button>
                </div>
                <div class="btn-grp vertical">
                    <button
                        @click="
                            filterDataIsProperties = true, 
                            getPaginationDataWithRequest(1, 'properties', `${request}`)"
                        :class="filterDataIsProperties ? 'selected' : ''">Properties</button>
                    <button
                        @click="
                            filterDataIsProperties = false, 
                            preFilterUnits(search_global, subZone.name, [['bed', 0], ['bath', 0], ['area', 0], ['price_min', 0], ['price_max', 0]])"
                        :class="!filterDataIsProperties ? 'selected' : ''">Units</button>
                </div>
            </div>
            <div v-show="filterDataIsProperties" class="container-btn-dropdown multi">
                <div class="container-btn-dropdown" id="dropdown-zones">
                    <select v-model="zone.name" @change="getSubZones(`/api/zones/${zone.name}/sub-zones`)"
                        class="btn-dropdown">
                        <option value="" disabled>--select zone--</option>
                        <template v-for="zone in zones">
                            <option :value="zone.id">{{ zone.name }} ({{ zone.county.name }})</option>
                        </template>
                    </select>
                    <select v-model="subZone.name" :hidden="!zone.name"
                        @change="btnSelected = '', getPaginationDataWithRequest(1, 'properties', `/api/listings/sub-zone/${subZone.name}`)"
                        class="btn-dropdown">
                        <option value="" disabled>--select sub-zone--</option>
                        <template v-for="subZone in subZones">
                            <option :value="subZone.id">{{ subZone.name }}</option>
                        </template>
                    </select>
                </div>
                <select v-model="filter_sort"
                    @change="btnSelected = '', zone.name = '', getPaginationDataWithRequest(1, 'properties', `${request}`)"
                    class="btn-dropdown">
                    <option value="">Sort by default</option>
                    <option value="desc">Sort by newest</option>
                    <option value="asc">Sort by oldest</option>
                </select>
            </div>
            <div v-show="!filterDataIsProperties">
                <form @submit.prevent="preFilterUnits(search_global, subZone.name, [
                                                        ['bed', unit.bedrooms], 
                                                        ['bath', unit.bathrooms], 
                                                        ['area', unit.floor_area], 
                                                        ['price_min', unit.price_min], 
                                                        ['price_max', unit.price_max]
                                                    ])">
                    <div class="form-group">
                        <div class="input-horizontal">
                            <div class="collection">
                                <input v-model="unit.bedrooms" type="number" min="0" name="bedrooms" placeholder="No. of bedrooms">
                                <div v-for="message in validationErrors?.bedrooms" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                            <div class="collection">
                                <input v-model="unit.bathrooms" type="number" min="0" name="bathrooms" placeholder="No. of bathrooms">
                                <div v-for="message in validationErrors?.bathrooms" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                            <div class="collection">
                                <input v-model="unit.floor_area" type="number" min="1" name="floor_area" placeholder="Floor area in sq M">
                                <div v-for="message in validationErrors?.floor_area" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                            <div class="collection">
                                <input v-model="unit.price_min" type="number" min="1" name="price_min" placeholder="Min price">
                                <div v-for="message in validationErrors?.price_min" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                            <div class="collection">
                                <input v-model="unit.price_max" type="number" min="1" name="price_max" placeholder="Max price">
                                <div v-for="message in validationErrors?.price_max" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                        </div>
                        <button :disabled="isLoading" class="btn-submit" type="submit">
                            <div v-show="isLoading" class="lds-dual-ring"></div>
                            <span v-if="isLoading">Loading...</span>
                            <span v-else>Apply</span>
                        </button>
                    </div>
                </form>
            </div>
            <div id="isLoading">
                <div v-show="isLoading" class="lds-dual-ring"></div>
                <span v-if="isLoading">Loading...</span>
            </div>
            <div v-if="filterDataIsProperties" class="cards">
                <template v-for="item in properties">
                    <CardProperty :property="item" />
                </template>
            </div>
            <div v-else class="cards">
                <template v-if="user.role" v-for="item in units">
                    <CardUnit :unit="item" />
                </template>
                <template v-else>
                    <div></div>
                    <h1 style="text-align: center;">Sign-in to see results</h1>
                    <div></div>
                </template>
            </div>
            <template v-if="!properties.length">
                <p style="text-align: center;">-no listings-</p>
            </template>
        </div>
        <Pagination v-if="filterDataIsProperties && propertiesCount > 25" :totalPages="total_pages" :perPage="per_page"
            :currentPage="current_page" @pagechanged="onPageChange" />
        <Pagination v-if="!filterDataIsProperties && unitsCount > 25" :totalPages="total_pages" :perPage="per_page"
            :currentPage="current_page" @pagechanged="onPageChange" />
    </section>
</template>

<script setup>
import { ref, onBeforeMount, watch, onBeforeUpdate } from 'vue'
import pagination from '../../composables/pagination'
import userMaster from '../../composables/users'
import SearchBar from '../Search/SearchBar.vue'
import CardProperty from '../Cards/Property1.vue';
import CardUnit from '../Cards/PropertyUnit3.vue';
import zonesMaster from '../../composables/zones';
import subZonesMaster from '../../composables/subzones';

const request = ref(`/api/listings`)
// const btnSelected = ref('All')
const btnSelected = ref('')
const filterDataIsProperties = ref(true)

const { 
    search_global,
    filter_sort,
    total_pages,
    per_page,
    current_page,
    properties,
    propertiesCount,
    filterUnits, 
    units, 
    unitsCount, 
    onPageChange,
    getPaginationDataWithRequest,
} = pagination()
const { user, getUserData } = userMaster() 
const { getZones, zones, zone } = zonesMaster()
const { getSubZones, subZones, subZone, route } = subZonesMaster()
const unit = ref({
    bedrooms: '',
    bathrooms: '',
    floor_area: '',
    price_min: '',
    price_max: '',
})
const unitFilterRequest = ref(``)

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

function preFilterUnits(searchData, subZoneId, dataArray) {
    if (!subZoneId) {
        unitFilterRequest.value = `/api/listings/units/all`
    } else {
        unitFilterRequest.value = `/api/listings/units/sub-zone/${subZoneId}`
    }

    let specs = []
    specs[0] = dataArray[0]
    specs[1] = dataArray[1]
    specs[2] = dataArray[2]
    specs[3] = dataArray[3]
    specs[4] = dataArray[4]

    let unitParams = []
    unitParams[0] = searchData
    unitParams[1] = specs

    localStorage.setItem('dataArray', JSON.stringify(unitParams))
    getPaginationDataWithRequest(current_page.value, 'property_units_filtered', unitFilterRequest.value)
    // filterUnits(unitFilterRequest.value, dataArray)
}

onBeforeMount(() => {
    getZones(`/api/zones`)
    filterData('')
    getUserData()
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
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
.btn-submit {
    width: unset;
    margin: auto;
}
.collection {
    min-width: 150px;
}
</style>