<template>
    <!-- Showcase -->
    <section class="showcase-listing" id="section-showcase">
        <div class="showcase-listing-img-group">
            <template v-if="property.files && property.files[0]">
                <div ref="show_1" class="showcase-listing-img-1" :style="{ background: `url(/images/listings/${property.slug}/${property.files[0].name})` }" style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div ref="show_1" class="showcase-listing-img-1"></div>
            </template>
            <template v-if="property.files && property.files[1]">
                <div ref="show_2" class="showcase-listing-img-2" :style="{ background: `url(/images/listings/${property.slug}/${property.files[1].name})` }" style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div ref="show_2" class="showcase-listing-img-2"></div>
            </template>
            <template v-if="property.files && property.files[2]">
                <div ref="show_3" class="showcase-listing-img-3" :style="{ background: `url(/images/listings/${property.slug}/${property.files[2].name})` }" style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div ref="show_3" class="showcase-listing-img-3"></div>
            </template>
            <template v-if="property.files && property.files[3]">
                <div ref="show_4" class="showcase-listing-img-4" :style="{ background: `url(/images/listings/${property.slug}/${property.files[3].name})` }" style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div ref="show_4" class="showcase-listing-img-4"></div>
            </template>
            <template v-if="property.files && property.files[4]">
                <div ref="show_5" class="showcase-listing-img-5" :style="{ background: `url(/images/listings/${property.slug}/${property.files[4].name})` }" style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div ref="show_5" class="showcase-listing-img-5"></div>
            </template>
            <template v-if="property.files && property.files[5]">
                <div ref="show_6" class="showcase-listing-img-6" :style="{ background: `url(/images/listings/${property.slug}/${property.files[5].name})` }" style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div ref="show_6" class="showcase-listing-img-6"></div>
            </template>
            <template v-if="property.files && property.files[6]">
                <div ref="show_6" class="showcase-listing-img-7" :style="{ background: `url(/images/listings/${property.slug}/${property.files[6].name})` }" style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div ref="show_7" class="showcase-listing-img-7"></div>
            </template>
            <template v-if="property.files && property.files[7]">
                <div ref="show_8" class="showcase-listing-img-8" :style="{ background: `url(/images/listings/${property.slug}/${property.files[7].name})` }" style="background-size: cover;"></div>
            </template>
            <template v-else>
                <div ref="show_8" class="showcase-listing-img-8"></div>
            </template>
        </div>

        <div>
            <!-- directive -->
            <div class="images" v-viewer>
                <img v-for="src in images" :key="src" :src="src">
            </div>
            <!-- component -->
            <viewer :images="images">
                <img v-for="src in images" :key="src" :src="src">
            </viewer>
        </div>
        <!-- API -->
        <div @click="openImageBrowser" class="more-images" id="toggleShowcase">
            <i class="fas fa-images"></i>
            <span>View images</span>
        </div>
    </section>

    <!-- Nav -->
    <div class="secondary-nav">
        <ul>
            <li><a href="#section-showcase">Basic</a></li>
            <li><a href="#units-available">Units</a></li>
            <li><a href="#lister-details">Lister</a></li>
            <li><a href="#listing-actions">Actions</a></li>
            <li><a href="#listing-stats">Stats</a></li>
            <li><a href="#listing-features">Features</a></li>
            <li><a href="#map-view">Map</a></li>
            <li><a href="#nearby-places">Places</a></li>
            <li><a href="#listing-reviews">Reviews</a></li>
        </ul>
    </div>

    <section class="section-listing-primary">
        <div class="container">
            <h3>Primary information</h3>
            <div class="listing-info-main">
                <div class="info-name">
                    <h1 class="name">{{ property.name }}</h1>
                    <div class="info-actions">
                        <div><i class="fas fa-share-alt" id="modalTrigger1"></i></div>
                        <div><i class="fas fa-heart"></i></div>
                        <router-link v-if="user.username === property.user_name" :to="{ name: 'property.manage', params: {slug: property.slug } }"><i class="fas fa-edit"></i></router-link>
                    </div>
                </div>
                <p v-if="property.sub_zone" class="location">{{ property.sub_zone.name }}, {{ property.sub_zone.zone.name }}, {{ property.sub_zone.zone.county.name }}</p>
            </div>
            <div class="listing-info-aux" v-if="property.window">
                <div class="aux-grp">
                    <p class="label">Rent range</p>
                    <h3 class="data">KES {{ property.window.rent_min }} - {{ property.window.rent_max }}</h3>
                </div>
                <div class="aux-grp">
                    <p class="label">Floor size</p>
                    <h3 class="data">{{ property.window.floor_size_min }} - {{ property.window.floor_size_max }} sq M</h3>
                </div>
                <div class="aux-grp">
                    <p class="label">Bedrooms</p>
                    <h3 class="data">{{ property.window.bedrooms_min }} - {{ property.window.bedrooms_max }}</h3>
                </div>
                <div class="aux-grp">
                    <p class="label">Bathrooms</p>
                    <h3 class="data">{{ property.window.bathrooms_min }} - {{ property.window.bathrooms_max }}</h3>
                </div>
            </div>
            <div class="listing-info-description">
                <p v-if="!property.description"><b>Description goes here...</b></p>
                <p v-else>{{ property.description }}</p>
            </div>
        </div>
    </section>

    <section class="section-listing-secondary">
        <div class="container">        
            <div class="panel-grp">
                <div class="panel">
                    <div class="listing-units-list" id="units-available">
                        <div class="title-grp">
                            <h3>Units available</h3>
                        </div>
                        <div class="listing-units-grp">
                            <template v-if="units" v-for="unit in units">
                                <div class="card-sm card-unit">
                                    <router-link :to="{ name: 'unit.manage', params: {slug: property.slug, unit_slug: unit.slug } }">
                                        <div class="details">
                                            <h2>{{ unit.name }}</h2>
                                            <div class="specs">
                                                <span class="spec">{{ unit.bedrooms }} bed | </span>
                                                <span class="spec">{{ unit.bathrooms }} bath | </span>
                                                <span class="spec">{{ unit.floor_area }}sq M</span>
                                            </div>
                                            <div class="deposit">
                                                <span class="label">Initial deposit: </span>
                                                <span v-if="unit.init_deposit == 0" class="data">not required</span>
                                                <span v-else class="data">{{ unit.init_deposit }} ({{ unit.init_deposit_period }} months)</span>
                                            </div>
                                            <div class="price">
                                                <span class="label">KES </span>
                                                <span class="data">{{ unit.price }}</span>
                                            </div>
                                            <p class="timestamp">Added {{ unit.time_ago }}</p>
                                        </div>
                                        <template v-if="unit.thumbnail">
                                            <div class="thumb" :style="{ background: `url(/images/listings/${property.slug}/${unit.slug}/${unit.thumbnail})` }" style="background-size: cover;"></div>
                                        </template>
                                        <template v-else>
                                            <div class="thumb" :style="{ background: `url(/images/static/thumb_unit.jpg` }" style="background-size: cover;"></div>
                                        </template>
                                    </router-link>  
                                </div>
                            </template>
                            <template v-if="!units.length">
                                <p style="text-align: center;">-no units-</p>
                            </template>
                            <template v-if="unitsCount > 5">
                                <Pagination :totalPages="total_pages"
                                            :perPage="per_page"
                                            :currentPage="current_page"
                                            @pagechanged="onPageChange" />
                            </template>
                        </div>
                    </div>
                    <div class="lister-details" id="lister-details">
                        <h3>Lister information</h3>
                        <div class="details">
                            <div class="header">
                                <div>
                                    <h2 class="name">{{ property.brand.name }}</h2>
                                    <p class="timestamp">Joined on {{ property.brand.created_at }}</p>
                                </div>
                                <template v-if="property.brand.avatar">
                                    <img :src="'/images/brand/avatar/' + property.brand.username + '/' + property.brand.avatar" alt="">
                                </template>
                                <template v-else>
                                    <img src="/images/static/avatar.png" alt="">
                                </template>
                            </div>
                            <p class="listings-count">{{ property.brand.properties_count }} listings posted</p>
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
                            <div class="section-more">
                                <router-link v-if="user.username === property.user_name" :to="{ name: 'users.account' }" href="/manage-account">Manage brand <i class="fas fa-chevron-right"></i></router-link>
                            </div>
                        </div>
                    </div>
                    <div class="listing-actions" id="listing-actions">
                        <h3>Listing actions</h3>
                        <div class="btn-grp vertical">
                            <button>Make private (hide)</button>
                            <button>Submit for approval</button>
                            <button>Withdraw submission</button>
                            <button onclick="window.location.href='/lister/manage-listing.html';">Edit listing</button>
                            <button id="btnAddUnit">Add unit</button>
                            <button>Delete</button>
                        </div>
                    </div>
                    <div class="listing-actions" id="listing-other-actions">
                        <h3>Other actions</h3>
                        <div class="btn-grp vertical">
                            <button>Beginner applications</button>
                            <button>Tour requests</button>
                            <button>Occupation log</button>
                            <button>Management log</button>
                            <button>Banned users</button>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div v-if="property.features && property.features.length" class="listing-features">
                        <div class="title-grp">
                            <h3>Communial features</h3>
                        </div>
                        <div class="features" id="listing-features">
                            <ul v-for="feature in property.features">
                                <li><span>{{ feature.item }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="listing-map" id="map-view">
                        <h3>Location</h3>
                        <div id="map"></div>
                    </div>
                    <div class="listing-nearby-places" id="nearby-places">
                        <h3>Nearby schools</h3>
                        <div class="places-list">
                            <div class="place" id="sch1">
                                <h3 class="title" id="sch1-title">Place name</h3>
                                <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, assumenda.</p>
                                <p class="location">Location, Location, Location</p>
                                <p class="distance">0 km</p>
                            </div>
                            <div class="place" id="sch2">
                                <h3 class="title" id="sch2-title">Place name</h3>
                                <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, assumenda.</p>
                                <p class="location">Location, Location, Location</p>
                                <p class="distance">0 km</p>
                            </div>
                            <div class="place" id="sch3">
                                <h3 class="title" id="sch3-title">Place name</h3>
                                <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, assumenda.</p>
                                <p class="location">Location, Location, Location</p>
                                <p class="distance">0 km</p>
                            </div>
                        </div>
                    </div>
                    <div class="listing-nearby-places">
                        <h3>Nearby markets</h3>
                        <div class="places-list">
                            <div class="place" id="mkt1">
                                <h3 class="title">Place name</h3>
                                <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, assumenda.</p>
                                <p class="location">Location, Location, Location</p>
                                <p class="distance">0 km</p>
                            </div>
                            <div class="place" id="mkt2">
                                <h3 class="title">Place name</h3>
                                <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, assumenda.</p>
                                <p class="location">Location, Location, Location</p>
                                <p class="distance">0 km</p>
                            </div>
                            <div class="place" id="mkt3">
                                <h3 class="title">Place name</h3>
                                <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, assumenda.</p>
                                <p class="location">Location, Location, Location</p>
                                <p class="distance">0 km</p>
                            </div>
                        </div>
                    </div>
                    <div class="listing-nearby-places">
                        <h3>Nearby bus stops</h3>
                        <div class="places-list">
                            <div class="place" id="bus1">
                                <h3 class="title">Place name</h3>
                                <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, assumenda.</p>
                                <p class="location">Location, Location, Location</p>
                                <p class="distance">0 km</p>
                            </div>
                            <div class="place" id="bus2">
                                <h3 class="title">Place name</h3>
                                <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, assumenda.</p>
                                <p class="location">Location, Location, Location</p>
                                <p class="distance">0 km</p>
                            </div>
                            <div class="place" id="bus3">
                                <h3 class="title">Place name</h3>
                                <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, assumenda.</p>
                                <p class="location">Location, Location, Location</p>
                                <p class="distance">0 km</p>
                            </div>
                        </div>
                    </div>
                    <div class="listing-reviews" id="listing-reviews">
                        <h3>Reviews</h3>
                        <div class="reviews-list">
                            <div class="review-item">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <p class="time">4 hours ago</p>
                                <h3 class="occupant">Verified occupant</h3>
                                <p class="reveiw txt-triple-line">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci officiis unde amet nobis consectetur velit, eius
                                quaerat! Adipisci non alias expedita suscipit!</p>
                            </div>
                            
                            <div class="review-item">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <p class="time">4 hours ago</p>
                                <h3 class="occupant">Verified occupant</h3>
                                <p class="reveiw txt-triple-line">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci officiis unde amet nobis consectetur velit, eius
                                quaerat! Adipisci non alias expedita suscipit!</p>
                            </div>
                            
                            <div class="review-item">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <p class="time">4 hours ago</p>
                                <h3 class="occupant">Verified occupant</h3>
                                <p class="reveiw txt-triple-line">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci officiis unde amet nobis consectetur velit, eius
                                quaerat! Adipisci non alias expedita suscipit!</p>
                            </div>
                            
                            <div class="review-item">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <p class="time">4 hours ago</p>
                                <h3 class="occupant">Verified occupant</h3>
                                <p class="reveiw txt-triple-line">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci officiis unde amet nobis consectetur velit, eius
                                quaerat! Adipisci non alias expedita suscipit!</p>
                            </div>
                        </div>
                        <div class="section-more">
                            <a href="/view-listing-reviews.html">View more reviews <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <CreateUnit ref="createUnitRef" />
    <EditPropertyPrimary ref="editPrimaryRef"/>
    <EditPropertyFeatures ref="editFeaturesRef"/>
</template>

<script setup>
import propertiesMaster from '../../composables/properties';
import { onBeforeMount, onMounted, ref } from 'vue';
import CreateUnit from '../Modals/CreateUnit.vue';
import EditPropertyFeatures from '../Modals/EditPropertyFeatures.vue';
import EditPropertyPrimary from '../Modals/EditPropertyPrimary.vue'
import Pagination from '../Misc/Pagination.vue'
import pagination from '../../composables/pagination';
import userMaster from '../../composables/users';
import { api as viewerApi } from "v-viewer"

const { 
    property, 
    route, 
    getProperty,
} = propertiesMaster()

const { 
    total_pages,
    per_page,
    current_page,
    units,
    unitsCount,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()

const createUnitRef = ref(null)
const editPrimaryRef = ref(null)
const editFeaturesRef = ref(null)
const unitsRequest = `/api/listings/${route.params.slug}/units`
const { getUserData, user } = userMaster()
const imagesList = () => {
    let images = [];
    for (let i=0; i<property.value.files.length; i++) {
        images.push(`/images/listings/${property.value.slug}/${property.value.files[i].name}`)
    }
    return images
}

onBeforeMount(() => {
    getProperty(`/api/listings/my-listings/${route.params.slug}`)
    getPaginationDataWithRequest(current_page.value, 'property_units', unitsRequest)
    getUserData()
})

function openImageBrowser() {
    viewerApi({
        images: imagesList(),
        options: {
            inline: false, 
            button: true, 
            navbar: false, 
            title: false, 
            toolbar: true, 
            tooltip: false, 
            movable: false, 
            zoomable: true, 
            rotatable: true, 
            scalable: true, 
            transition: true, 
            fullscreen: true, 
            keyboard: true
        }
    })
}

function click(element) {
    element.openModal();
}

</script>