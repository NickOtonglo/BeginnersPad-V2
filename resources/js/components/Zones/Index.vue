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
    <section id="search-bar">
        <div class="container">
            <form class="search-bar">
                <div class="search-bar-grp">
                    <input type="text" class="search-input" placeholder="search...">
                    <div class="search-button">
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
                                <p>County: <span>{{ zone.county_code }}</span></p>
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
    </section>

    <CreateZone ref="childComponentRef" />
</template>

<script setup>
import { onMounted, ref } from 'vue';
import zonesMaster from '../../composables/zones';
import CreateZone from '../Modals/CreateZone.vue'
import operateModal from '../../composables/modal'

const childComponentRef = ref(null);

const { zones, getZones, createZone } = zonesMaster()

function click() {
    childComponentRef.value.openModal();
}

onMounted(() => {
    getZones('api/zones')
    operateModal(document.querySelector('#modal'))
})
</script>