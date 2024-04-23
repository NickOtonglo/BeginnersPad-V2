<template>
    <h3 class="section-title">{{ subZone.name }}</h3>

    <section class="section-zones" id="sectionViewZone">
        <div class="container">
            <div class="panel-grp">
                <div class="panel">
                    <div v-if="subZone && properties" class="zone-map">
                        <Map :subZone="subZone" :properties="properties" />
                    </div>
                    <div class="panel-item bordered">
                        <div class="title-grp">
                            <h3>Sub-zone details</h3>
                            <div class="info-actions">
                                <a @click="click(editSubZoneRef)" href="#">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a @click="deleteSubZone(request)" href="#">
                                    <i class="fas fa-xmark"></i>
                                </a>
                            </div>
                        </div>
                        <div class="data">
                            <ul>
                                <li>{{ subZone.name }} (ID <span>{{ subZone.id }}</span>)</li>
                                <li>County: <span>{{ subZone.zone.county.name }}</span></li>
                                <li>Zone: <span>{{ subZone.zone.name }} (ID {{ subZone.zone.id }})</span></li>
                                <li>Role/nature: <span>{{ subZone.nature.category }}</span></li>
                                <li>Coordinates: <span>{{ subZone.lat }}, {{ subZone.lng }}</span></li>
                                <li>Area radius: <span>{{ subZone.radius }} km</span></li>
                                <li>Timezone: <span>{{ subZone.zone.timezone }}</span></li>
                                <li>Added on: <span>{{ subZone.timestamp }}</span></li>
                                <li>Listings: <span>0</span></li>
                                <li v-if="subZone.description">Description: <span>{{ subZone.description }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="section-more">
                        <router-link :to="{ name: 'zone.view', params: {id: route.params.zone_id } }"><i class="fas fa-chevron-left"></i> View zone</router-link>
                    </div>
                    <div class="charts">
                        <h3>Relative occupancy chart</h3>
                        <div class="chart" style="height: 300px;width: 250px;">
                            <canvas id="chartDashListingsBeginner" width="250" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div class="listing-units-list">
                        <h3>Listings in this sub-zone</h3>
                        <div class="listing-units-grp" id="sectionZoneListingUnits">
                            <template v-for="(item, index) in properties">
                                <CardProperty v-if="index <= 8" :property="item" />
                            </template>
                        </div>
                        <div v-if="properties.length > 8" class="section-more">
                            <a href="/admin/listing-applications.html">View more <i class="fas fa-chevron-right"></i></a>
                        </div>
                        <template v-if="!properties.length">
                            <p style="text-align: center;">-no sub-zones-</p>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="sectionTable">
        <div class="container">
            <div class="table-grp">
                <h4 class="table-title">Sub-zone log</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Sub-zone</th>
                        <th>Action</th>
                        <th>Performed by</th>
                        <th>Comments</th>
                        <th>Time</th>
                    </tr>
                    <template v-for="(item, index) in subZone.logs">
                        <tr>
                            <td>{{ index+1 }}</td>
                            <td>{{ item.name }}</td>
                            <template v-if="item.method == 'POST'">
                                <td>sub-zone created</td>
                            </template>
                            <template v-else-if="item.method == 'PATCH' && item.name">
                                <td>sub-zone updated</td>
                            </template>
                            <template v-else-if="item.method == 'DELETE' || (item.method == 'PATCH' && !item.name)">
                                <td>sub-zone deleted</td>
                            </template>
                            <td>@{{ item.action_by }}</td>
                            <td>{{ item.comment }}</td>
                            <td>{{ item.time_ago }}</td>
                        </tr>
                    </template>
                    <template v-if="subZone.logs && !subZone.logs.length">
                        <tr style="text-align: center;">-no logs-</tr>
                    </template>
                </table>
            </div>
        </div>
    </section>

    <EditSubZone ref="editSubZoneRef" />
</template>

<script setup>
import operateModal from '../../composables/modal';
import { onMounted, ref } from 'vue';
import EditSubZone from '../Modals/EditSubZone.vue';
import CardProperty from '../Cards/Property2.vue'
import subZonesMaster from '../../composables/subzones';
import propertiesMaster from '../../composables/properties'
import Map from '../Maps/SubZoneView.vue'

const editSubZoneRef = ref(null)
const { subZone, getSubZone, route, getNatures, deleteSubZone } = subZonesMaster()
const { getProperties, properties } = propertiesMaster()
const request = ref(`/api/zones/${route.params.zone_id}/sub-zones/${route.params.sub_id}`)

function click(element) {
    element.openModal();
}

onMounted(() => {
    getSubZone(request.value)
    getProperties(`/api/zones/${route.params.zone_id}/sub-zones/${route.params.sub_id}/listings`)
    getNatures()
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