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
        <div v-if="property.files && property.files[0]" @click="openImageBrowser" class="more-images" id="toggleShowcase">
            <i class="fas fa-images"></i>
            <span> View images ({{ property.files.length }})</span>
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
                        <div @click="saveFavourite(`/api/favourites`, property, 'Property')"><i class="fas fa-heart" :class="{ active: property.favourite }"></i></div>
                        <router-link v-if="user.username === property.user_name" :to="{ name: 'property.manage', params: {slug: property.slug } }"><i class="fas fa-edit"></i></router-link>
                    </div>
                </div>
                <h1 class="info-rating-grp">
                    <ComponentRatingStars v-if="property.rating" :rating="property.rating" />
                    <p v-if="property.rating != 0" class="rating">({{ property.rating }})</p>
                    <p v-else class="rating">(not rated)</p>
                </h1>
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
                                <CardPropertyUnit :property="property" :unit="unit" />
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
                    <div class="lister-details" id="lister-details" v-if="property.brand">
                        <h3>Lister information</h3>
                        <CardBrand :brand="property.brand" :user="user" :sectionMore="true" />
                    </div>
                    <form @submit.prevent="updateStatus(`/api/listings/${property.slug}/status`, fauxProperty)" ref="formRef" :hidden="true">
                        <div class="form-group">
                            <input v-model="property.status" type="text" name="status" :disabled="true">
                        </div>
                        <button :disabled="true" ref="btnSubmitRef" class="btn-submit" type="submit">
                            <div v-show="isLoading" class="lds-dual-ring"></div>
                            <span v-if="isLoading">Loading...</span>
                            <span v-else>Save</span>
                        </button>
                    </form>
                    <div class="listing-actions" id="listing-actions">
                        <h3 v-if="user.role === 'Admin' 
                                || user.role === 'Super Admin' 
                                || user.role === 'System Admin'
                                || user.role === 'Beginner'
                                || user.username === property.user_name">Listing actions</h3>
                        <div v-if="user.role !== 'Admin' 
                                && user.role !== 'Super Admin' 
                                && user.role !== 'System Admin'" class="btn-grp vertical">
                            <button v-if="user.role === 'Beginner'" @click="makeEnquiry">Make enquiry</button>
                            <button v-if="user.role === 'Beginner' && !review" @click="click(addReviewRef)">Add review</button>
                            <template v-if="user.username === property.user_name">
                                <button @click="submitForm('private')" v-if="property.status === 'published'">Make private (hide)</button>
                                <button @click="submitForm('published')" v-if="property.status === 'private'">Make public</button>
                                <button @click="submitForm('pending')" 
                                        v-if="property.status === 'unpublished'
                                           || property.status === 'rejected'">Submit for approval</button>
                                <button @click="submitForm('unpublished')" v-if="property.status === 'pending'">Withdraw submission</button>
                                <button @click="deleteProperty(`/api/listings/${route.params.slug}`)" v-if="user.username === property.user_name">Delete</button>
                            </template>
                        </div>
                        <div v-else class="btn-grp vertical">
                            <button @click="fauxProperty.status = 'suspended', click(submitReasonRef)" v-if="property.status === 'published'">Suspend</button>
                            <button @click="submitForm('published')" v-if="property.status === 'suspended'">Restore</button>
                            <button @click="fauxProperty.status = 'rejected', click(submitReasonRef)" v-if="property.status === 'pending'">Reject</button>
                            <button @click="deleteProperty(`/api/listings/${route.params.slug}`)">Delete</button>
                        </div>
                    </div>
                    <div v-if="user.username === property.user_name 
                            || user.role === 'Admin' 
                            || user.role === 'Super Admin' 
                            || user.role === 'System Admin'" class="listing-actions" id="listing-other-actions">
                        <h3>Other actions</h3>
                        <div class="btn-grp vertical">
                            <button @click="$router.push({ name: 'property.logs', params: {slug: property.slug } })">Management log</button>
                            <!-- <button>Banned users</button> -->
                        </div>
                    </div>
                    <div v-if="user.username === property.user_name 
                            || user.role === 'Admin' 
                            || user.role === 'Super Admin' 
                            || user.role === 'System Admin'" class="listing-stats" id="listing-stats">
                        <h3>Stats</h3>
                        <CardStats :property="property" />
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
                            <div v-for="place in placesArray.school" class="place">
                                <h3 class="title">{{ place.displayName }}</h3>
                                <p class="description">{{ place.editorialSummary }}</p>
                                <p class="location">{{ place.formattedAddress }}</p>
                                <template v-for="distance in distancesArray.school">
                                    <p v-if="distance[0] == place.displayName" class="distance">{{ distance[1] }}</p>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="listing-nearby-places">
                        <h3>Nearby markets</h3>
                        <div class="places-list">
                            <div v-for="place in placesArray.market" class="place" id="mkt1">
                                <h3 class="title">{{ place.displayName }}</h3>
                                <p class="description">{{ place.editorialSummary }}</p>
                                <p class="location">{{ place.formattedAddress }}</p>
                                <template v-for="distance in distancesArray.market">
                                    <p v-if="distance[0] == place.displayName" class="distance">{{ distance[1] }}</p>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="listing-nearby-places">
                        <h3>Nearby bus stops</h3>
                        <div v-for="place in placesArray.bus_stop" class="places-list">
                            <div class="place" id="bus1">
                                <h3 class="title">{{ place.displayName }}</h3>
                                <p class="description">{{ place.editorialSummary }}</p>
                                <p class="location">{{ place.formattedAddress }}</p>
                                <template v-for="distance in distancesArray.bus_stop">
                                    <p v-if="distance[0] == place.displayName" class="distance">{{ distance[1] }}</p>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="listing-reviews" id="listing-reviews">
                        <h3>Reviews</h3>
                        <div class="reviews-list">
                            <div v-for="(item, index) in reviews" class="review-item">
                                <template v-if="index <= 2">
                                    <ComponentRatingStars :rating="item.rating" />
                                    <p class="time">{{ item.time_ago }}</p>
                                    <h3 v-if="review && item.id == review.id" @click="click(editReviewRef)" class="occupant active">{{ user.username }} (me) - tap to edit</h3>
                                    <h3 v-else class="occupant">Verified occupant</h3>
                                    <p class="review txt-triple-line">{{ item.review }}</p>
                                </template>
                            </div>
                            <template v-if="!reviews.length">
                                <p style="text-align: center;">-no reviews-</p>
                            </template>
                        </div>
                        <div v-if="reviews.length" class="section-more">
                            <router-link :to="{ name: 'reviews.index', params: {slug: property.slug } }">View more reviews <i class="fas fa-chevron-right"></i></router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <AddReview ref="addReviewRef" />
    <EditReview v-if="review" ref="editReviewRef" :review="review" />
    <SubmitReason ref="submitReasonRef" :action="fauxProperty.status" @reason-submitted="getReason" />
</template>

<script setup>
import { onBeforeMount, onUpdated, ref } from 'vue';
import propertiesMaster from '../../composables/properties';
import Pagination from '../Misc/Pagination.vue'
import pagination from '../../composables/pagination';
import userMaster from '../../composables/users';
import propertyReviewsMaster from '../../composables/property_reviews'
import favouriteMaster from '../../composables/favourites';
import ComponentRatingStars from '../Misc/RatingStars.vue'
import CardPropertyUnit from '../Cards/PropertyUnit1.vue';
import CardBrand from '../Cards/Brand1.vue'
import CardStats from '../Cards/PropertyStats.vue'
import AddReview from '../Modals/AddReview.vue'
import EditReview from '../Modals/EditReview.vue';
import SubmitReason from '../Modals/SubmitReason.vue';
import { api as viewerApi } from "v-viewer"
import mapsMaster from '../../composables/maps';

const { 
    property, 
    route, 
    getProperty,
    deleteProperty,
    updateStatus, 
    isLoading, 
    contactLister, 
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
const { user, getUserData } = userMaster()
const { getReviews, reviews, getMyReview, review } = propertyReviewsMaster()
const { saveFavourite } = favouriteMaster()
const fauxProperty = ref({})

const unitsRequest = `/api/listings/${route.params.slug}/units`
const addReviewRef = ref({})
const editReviewRef = ref({})
const submitReasonRef = ref({})
const btnSubmitRef = ref(null)
const imagesList = () => {
    let images = [];
    for (let i=0; i<property.value.files.length; i++) {
        images.push(`/images/listings/${property.value.slug}/${property.value.files[i].name}`)
    }
    return images
}
const { initMap, map, placesArray, distancesArray } = mapsMaster()

onBeforeMount(() => {
    getProperty(`/api/listings/${route.params.slug}`)
    getPaginationDataWithRequest(current_page.value, 'property_units', unitsRequest)
    getReviews(`/api/listings/${route.params.slug}/reviews`)
    getMyReview(`/api/listings/${route.params.slug}/reviews`)
    getUserData()
    // if (property.value.lat) {
        // nearbySearch(property.value.lat, property.value.lng, `schools`)
    // }
})

onUpdated(() => {
    initMap({
        map: { 
            position: {
                lat: +property.value.lat, 
                lng: +property.value.lng,
            },
            zoom: 16,
        }, 
        marker: { 
            enabled: true,
            targetFunction: `setBigMarker`, 
            title: property.value.name
        },
        places: {
            enabled: true,
        } 
    })
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

function submitForm(data) {
    fauxProperty.value.status = data
    // console.log('fauxProperty', fauxProperty.value)
    btnSubmitRef.value.disabled = isLoading
    btnSubmitRef.value.click()
}

function getReason(reason, action) {
    fauxProperty.value.comment = reason
    submitForm(action)
}

function click(element) {
    element.openModal();
}

function makeEnquiry() {
    contactLister(`/api/listings/${route.params.slug}/enquire`, property)
}

</script>

<style scoped>
.occupant.active {
    cursor: pointer;
}
.occupant.active:hover {
    color: var(--color-primary);
}
.info-actions .active {
    color: var(--color-primary)
}
form, 
form > *, 
form input {
    height: 0px;
    display: none;
}
</style>