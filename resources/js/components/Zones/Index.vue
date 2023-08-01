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
                <div class="card-generic">
                    <a href="/admin/manage-zone.html">
                        <div class="text">
                            <h4>Zone name (ID <span>000</span>)</h4>
                            <p>County: <span>county name</span></p>
                            <p>State: <span>state name</span></p>
                            <p>Coordinates: <span>0.000, 0.000</span></p>
                            <p>Radius: <span>0 km</span></p>
                            <p>Timezone: <span>GMT +3</span></p>
                            <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                        </div>
                    </a>
                </div>
                <div class="card-generic">
                    <a href="/admin/manage-zone.html">
                        <div class="text">
                            <h4>Zone name (ID <span>000</span>)</h4>
                            <p>County: <span>county name</span></p>
                            <p>State: <span>state name</span></p>
                            <p>Coordinates: <span>0.000, 0.000</span></p>
                            <p>Radius: <span>0 km</span></p>
                            <p>Timezone: <span>GMT +3</span></p>
                            <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                        </div>
                    </a>
                </div>
                <div class="card-generic">
                    <a href="/admin/manage-zone.html">
                        <div class="text">
                            <h4>Zone name (ID <span>000</span>)</h4>
                            <p>County: <span>county name</span></p>
                            <p>State: <span>state name</span></p>
                            <p>Coordinates: <span>0.000, 0.000</span></p>
                            <p>Radius: <span>0 km</span></p>
                            <p>Timezone: <span>GMT +3</span></p>
                            <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                        </div>
                    </a>
                </div>
                <div class="card-generic">
                    <a href="/admin/manage-zone.html">
                        <div class="text">
                            <h4>Zone name (ID <span>000</span>)</h4>
                            <p>County: <span>county name</span></p>
                            <p>State: <span>state name</span></p>
                            <p>Coordinates: <span>0.000, 0.000</span></p>
                            <p>Radius: <span>0 km</span></p>
                            <p>Timezone: <span>GMT +3</span></p>
                            <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                        </div>
                    </a>
                </div>
                <div class="card-generic">
                    <a href="/admin/manage-zone.html">
                        <div class="text">
                            <h4>Zone name (ID <span>000</span>)</h4>
                            <p>County: <span>county name</span></p>
                            <p>State: <span>state name</span></p>
                            <p>Coordinates: <span>0.000, 0.000</span></p>
                            <p>Radius: <span>0 km</span></p>
                            <p>Timezone: <span>GMT +3</span></p>
                            <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                        </div>
                    </a>
                </div>
                <div class="card-generic">
                    <a href="/admin/manage-zone.html">
                        <div class="text">
                            <h4>Zone name (ID <span>000</span>)</h4>
                            <p>County: <span>county name</span></p>
                            <p>State: <span>state name</span></p>
                            <p>Coordinates: <span>0.000, 0.000</span></p>
                            <p>Radius: <span>0 km</span></p>
                            <p>Timezone: <span>GMT +3</span></p>
                            <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                        </div>
                    </a>
                </div>
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