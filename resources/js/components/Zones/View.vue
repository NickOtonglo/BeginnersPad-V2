<template>
    <div class="fab-container">
        <button @click="click(createSubRef)" class="fab btn-primary"><i class="fas fa-plus"></i> Add sub-zone</button>
    </div>

    <h3 class="section-title">{{ zone.name }}</h3>

    <section class="section-zones" id="sectionViewZone">
        <div class="container">
            <div class="panel-grp">
                <div class="panel">
                    <div v-if="zone" class="zone-map">
                        <Map :zone="zone" :subZones="subZones" />
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
                                <li>Sub-zones: <span>{{ zone.sub_zone_count }}</span></li>
                                <li>Properties: <span>{{ zone.property_count }}</span></li>
                                <li v-if="zone.description">Description: <span>{{ zone.description }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="section-more">
                        <a href="#">View listings in this zone <i class="fas fa-chevron-right"></i></a>
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
                        <select v-model="filter_sort" @change="getPaginationDataWithRequest(1, 'sub-zones', request)" class="btn-dropdown">
                        <option value="">Sort by default</option>
                        <option value="desc">Sort by newest</option>
                        <option value="asc">Sort by oldest</option>
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
                    <template v-if="!subZones.length">
                        <p style="text-align: center;">-no sub-zones-</p>
                    </template>
                    <template v-if="subZonesCount > 14">
                        <Pagination :totalPages="total_pages"
                                    :perPage="per_page"
                                    :currentPage="current_page"
                                    @pagechanged="onPageChange"
                        />
                    </template>
                    <!-- <template v-if="!subZones.length">
                        <p style="text-align: center;">-no sub-zones-</p>
                    </template> -->
                </div>
            </div>
        </div>
    </section>

    <section id="sectionTable">
        <div class="container">
            <div class="table-grp">
                <h4 class="table-title">Zone log</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Zone</th>
                        <th>Action</th>
                        <th>Performed by</th>
                        <th>Comments</th>
                        <th>Time</th>
                    </tr>
                    <template v-for="(item, index) in zone.logs">
                        <tr>
                            <td>{{ index+1 }}</td>
                            <td>{{ item.name }}</td>
                            <template v-if="item.method == 'POST'">
                                <td>zone created</td>
                            </template>
                            <template v-else-if="item.method == 'PATCH' && item.name">
                                <td>zone updated</td>
                            </template>
                            <template v-else-if="item.method == 'DELETE' || (item.method == 'PATCH' && !item.name)">
                                <td>zone deleted</td>
                            </template>
                            <td>@{{ item.action_by }}</td>
                            <td>{{ item.comment }}</td>
                            <td>{{ item.time_ago }}</td>
                        </tr>
                    </template>
                    <template v-if="zone.logs && !zone.logs.length">
                        <tr style="text-align: center;">-no logs-</tr>
                    </template>
                </table>
            </div>
        </div>
    </section>

    <EditZone ref="editZoneRef" />
    <CreateSub ref="createSubRef" />
</template>

<script setup>
import { onMounted, ref } from 'vue';
import zonesMaster from '../../composables/zones';
import EditZone from '../Modals/EditZone.vue'
import CreateSub from '../Modals/CreateSubZone.vue'
import Pagination from '../Misc/Pagination.vue'
import pagination from '../../composables/pagination';
import Map from '../Maps/ZoneView.vue'

const editZoneRef = ref(null);
const createSubRef = ref(null)
const { zone, getZone, route, getCounties, deleteZone } = zonesMaster()
const request = `/api/zones/${route.params.id}/sub-zones`

const { 
    filter_sort,
    total_pages,
    per_page,
    current_page,
    subZones,
    subZonesCount,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()

function click(element) {
    element.openModal();
}

onMounted(() => {
    getZone('/api/zones/' + route.params.id)
    getPaginationDataWithRequest(current_page.value, 'sub-zones', request)
    // getSubZones('/api/zones/' + route.params.id + '/sub-zones')
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
.table-grp table td {
    overflow: auto;
    text-overflow: unset;
    max-width: unset;
}
</style>