<template>
    <h3 class="section-title">Sub-zone name</h3>

    <section class="section-zones" id="sectionViewZone">
        <div class="container">
            <div class="panel-grp">
                <div class="panel">
                    <div class="zone-map">
                        <div id="map"></div>
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
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: 4.0/5</p>
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: 4.0/5</p>
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: not rated</p>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: 4.0/5</p>
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: 4.0/5</p>
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: not rated</p>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: not rated</p>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: 4.0/5</p>
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: 4.0/5</p>
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                            <div class="card-sm card-2">
                                <a href="/admin/manage-listing.html">
                                    <div class="thumb"></div>
                                    <div class="details">
                                        <h2>Listing name</h2>
                                        <div class="location">
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location,</span>
                                            <span class="spec">Location</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                        <div class="info-rating-grp">
                                            <p class="rating">Rating: 4.0/5</p>
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>  
                            </div>
                        </div>
                        <div class="section-more">
                            <a href="/admin/listing-applications.html">View more <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <EditSubZone ref="editSubZoneRef" />
</template>

<script setup>
import operateModal from '../../composables/modal';
import { onMounted, ref } from 'vue';
import EditSubZone from '../Modals/EditSubZone.vue';
import subZonesMaster from '../../composables/subzones';

const editSubZoneRef = ref(null)
const { subZone, getSubZone, route, getNatures, deleteSubZone } = subZonesMaster()
const request = ref(`/api/zones/${route.params.zone_id}/sub-zones/${route.params.sub_id}`)

function click(element) {
    element.openModal();
}

onMounted(() => {
    getSubZone(request.value)
    
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