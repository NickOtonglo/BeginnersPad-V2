<template>
    <div class="fab-container">
        <button @click="click(createSubRef)" class="fab btn-primary"><i class="fas fa-plus"></i> Add sub-zone</button>
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
                                <a @click="click(editZoneRef)" href="#">
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
                        <template v-for="subZone in subZones">
                            <div class="card-generic">
                                <router-link :to="{ name: 'sub-zone.view', params: { zone_id: subZone.zone_id, sub_id: subZone.id } }">
                                    <div class="text">
                                        <h4>{{ subZone.name }} (ID <span>{{ subZone.id }}</span>)</h4>
                                        <p>Role/nature: <span>{{ subZone.nature.category }}</span></p>
                                        <p>Coordinates: <span>{{ subZone.lat }}, {{ subZone.lng }}</span></p>
                                        <p>Radius: <span>{{ subZone.radius }} km</span></p>
                                        <p class="txt-sm">Added on: <span>{{ subZone.timestamp }}</span></p>
                                    </div>
                                </router-link>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <EditZone ref="editZoneRef" />
    <CreateSub ref="createSubRef" />
</template>

<script setup>
import { onMounted, ref } from 'vue';
import zonesMaster from '../../composables/zones';
import subZonesMaster from '../../composables/subzones';
import operateModal from '../../composables/modal';
import EditZone from '../Modals/EditZone.vue'
import CreateSub from '../Modals/CreateSubZone.vue'

const editZoneRef = ref(null);
const createSubRef = ref(null)
const { zone, getZone, route, getCounties, deleteZone } = zonesMaster()
const { subZones, getSubZones, createSubZone, subZone } = subZonesMaster()

function click(element) {
    element.openModal();
}

onMounted(() => {
    getZone('/api/zones/' + route.params.id)
    getSubZones('/api/zones/' + route.params.id + '/sub-zones')
    // operateModal(document.querySelector('#modal'))
    getCounties()
})
</script>

<style scoped>
.title-grp {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
.card-generic {
    width: 216px;
}
</style>