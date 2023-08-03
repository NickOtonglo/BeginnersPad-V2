<template>
    <div class="fab-container">
        <button id="modalTrigger" class="fab btn-primary"><i class="fas fa-plus"></i> Add sub-zone</button>
    </div>

    <h3 class="section-title">Zone name</h3>

    <section class="section-zones" id="sectionViewZone">
        <div class="container">
            <div class="panel-grp">
                <div class="panel">
                    <div class="zone-map">
                        <div id="map"></div>
                    </div>
                    <div class="panel-item bordered">
                        <div class="title-grp">
                            <h3>Zone details</h3>
                            <div class="info-actions">
                                <a @click="click" href="#">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a @click="deleteZone('/api/zones/' + route.params.id)" href="#">
                                    <i class="fas fa-xmark"></i>
                                </a>
                            </div>
                        </div>
                        <div class="data">
                            <ul>
                                <li>{{ zone.name }} (ID <span>{{ zone.id }}</span>)</li>
                                <li>County: <span>{{ zone.county.name }}</span></li>
                                <li>Coordinates: <span>{{ zone.lat }}, {{ zone.lng }}</span></li>
                                <li>Zone radius: <span>{{ zone.radius }} km</span></li>
                                <li>Timezone: <span>{{ zone.timezone }}</span></li>
                                <li>Added on: <span>{{ zone.timestamp }}</span></li>
                                <li>Sub-zones: <span>0</span></li>
                                <li>Listings: <span>0</span></li>
                                <li v-if="zone.description">Description: <span>{{ zone.description }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="section-more">
                        <a href="/admin/listing-applications.html">View listings in this zone <i class="fas fa-chevron-right"></i></a>
                    </div>
                    <div class="charts">
                        <h3>Relative occupancy chart</h3>
                        <div class="chart" style="height: 300px;width: 250px;">
                            <canvas id="chartDashListingsBeginner" width="250" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="panel">
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
                            <a href="/admin/manage-sub-zone.html">
                                <div class="text">
                                    <h4>Sub-zone name (ID <span>000</span>)</h4>
                                    <p>Role/nature: <span>role</span></p>
                                    <p>Coordinates: <span>0.000, 0.000</span></p>
                                    <p>Radius: <span>0 km</span></p>
                                    <p>Timezone: <span>GMT +3</span></p>
                                    <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="card-generic">
                            <a href="/admin/manage-sub-zone.html">
                                <div class="text">
                                    <h4>Sub-zone name (ID <span>000</span>)</h4>
                                    <p>Role/nature: <span>role</span></p>
                                    <p>Coordinates: <span>0.000, 0.000</span></p>
                                    <p>Radius: <span>0 km</span></p>
                                    <p>Timezone: <span>GMT +3</span></p>
                                    <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="card-generic">
                            <a href="/admin/manage-sub-zone.html">
                                <div class="text">
                                    <h4>Sub-zone name (ID <span>000</span>)</h4>
                                    <p>Role/nature: <span>role</span></p>
                                    <p>Coordinates: <span>0.000, 0.000</span></p>
                                    <p>Radius: <span>0 km</span></p>
                                    <p>Timezone: <span>GMT +3</span></p>
                                    <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="card-generic">
                            <a href="/admin/manage-sub-zone.html">
                                <div class="text">
                                    <h4>Sub-zone name (ID <span>000</span>)</h4>
                                    <p>Role/nature: <span>role</span></p>
                                    <p>Coordinates: <span>0.000, 0.000</span></p>
                                    <p>Radius: <span>0 km</span></p>
                                    <p>Timezone: <span>GMT +3</span></p>
                                    <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="card-generic">
                            <a href="/admin/manage-sub-zone.html">
                                <div class="text">
                                    <h4>Sub-zone name (ID <span>000</span>)</h4>
                                    <p>Role/nature: <span>role</span></p>
                                    <p>Coordinates: <span>0.000, 0.000</span></p>
                                    <p>Radius: <span>0 km</span></p>
                                    <p>Timezone: <span>GMT +3</span></p>
                                    <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="card-generic">
                            <a href="/admin/manage-sub-zone.html">
                                <div class="text">
                                    <h4>Sub-zone name (ID <span>000</span>)</h4>
                                    <p>Role/nature: <span>role</span></p>
                                    <p>Coordinates: <span>0.000, 0.000</span></p>
                                    <p>Radius: <span>0 km</span></p>
                                    <p>Timezone: <span>GMT +3</span></p>
                                    <p class="txt-sm">Added on: <span>01-01-2021 00:00:00</span></p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <EditZone ref="childComponentRef" />
</template>

<script setup>
import { onMounted, ref } from 'vue';
import zonesMaster from '../../composables/zones';
import operateModal from '../../composables/modal';
import EditZone from '../Modals/EditZone.vue'

const childComponentRef = ref(null);
const { zone, getZone, route, getCounties, deleteZone } = zonesMaster()

function click() {
    childComponentRef.value.openModal();
}

onMounted(() => {
    getZone('/api/zones/' + route.params.id)
    operateModal(document.querySelector('#modal'))
    getCounties
})
</script>

<style scoped>
.title-grp {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
</style>