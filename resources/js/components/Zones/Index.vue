<template>
    <div class="fab-container">
        <button @click="click" id="modalTrigger" class="fab btn-primary"><i class="fas fa-plus"></i> Add zone</button>
    </div>

    <div class="section-showcase-map">
        <!-- https://developers.google.com/maps/documentation/javascript/examples/polygon-simple#maps_polygon_simple-css -->
        <div id="map"></div>
    </div>

    <h3 class="section-title">Zones</h3>

    <!-- Search bar -->
    <section id="searchBar" ref="header">
        <div class="container">
            <form @submit.prevent="getPaginationData(1, 'zones')" class="search-bar">
                <div class="search-bar-grp">
                    <input v-model="search_global" type="text" class="search-input" placeholder="search...">
                    <div ref="btnClearSearch" v-show="search_global !== ''" @click="search_global = '', getPaginationData(1, 'zones')" class="search-button">
                        <i class="fas fa-xmark"></i>
                    </div>
                    <div @click="getPaginationData(1, 'zones')" class="search-button">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="section-zones">
        <div class="container">
            <div class="container-btn-dropdown">
                <select class="btn-dropdown" name="listing_sort" id="listing_sort">
                    <option value="" selected>Sort by newest</option>
                    <option value="">Sort by oldest</option>
                    <option value="">Sort by rating</option>
                    <option value="">Sort by popularity</option>
                </select>
            </div>
            <div class="cards">
                <template v-for="zone in zones">
                    <div class="card-generic">
                        <router-link :to="{ name: 'zone.view', params: {id: zone.id } }">
                            <div class="text">
                                <h4>{{ zone.name }} (ID <span>{{ zone.id }}</span>)</h4>
                                <p>County: <span>{{ zone.county.name }}</span></p>
                                <p>Coordinates: <span>{{ zone.lat }}, {{ zone.lng }}</span></p>
                                <p>Radius: <span>{{ zone.radius }} km</span></p>
                                <p>Timezone: <span>{{ zone.timezone }}</span></p>
                                <p class="txt-sm">Added on: <span>{{ zone.timestamp }}</span></p>
                            </div>
                        </router-link>
                    </div>
                </template>
            </div>
        </div>
        <Pagination :totalPages="total_pages"
                        :perPage="per_page"
                        :currentPage="current_page"
                        @pagechanged="onPageChange"
            />
    </section>

    <CreateZone ref="childComponentRef" />
</template>

<script setup>
import { onMounted, ref, onBeforeMount, watch } from 'vue';
import zonesMaster from '../../composables/zones';
import CreateZone from '../Modals/CreateZone.vue'
import operateModal from '../../composables/modal'
import pagination from '../../composables/pagination';

const childComponentRef = ref(null);
const btnClearSearch = ref(null)

const { 
    search_global,
    total_pages,
    per_page,
    current_page,
    zones,
    onPageChange,
    getPaginationData
} = pagination()

function click() {
    childComponentRef.value.openModal();
}

onBeforeMount(() => {
    getPaginationData(current_page.value, 'zones')
})

onMounted(() => {
    operateModal(document.querySelector('#modal'))
})

watch(search_global, (current, previous) => {
    // To show instant results during search, uncomment the line below
    // getPaginationData(1, 'zones')
})
</script>