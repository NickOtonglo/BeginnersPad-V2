<template>
    <section class="section-listing-images">
        <div class="container">
            <div class="title-grp">
                <h3>Images</h3>
                <div class="info-actions">
                    <i id="btnImgFaux" class="fas fa-plus"></i>
                    <form action="">
                        <input class="file-path-wrapper" accept="image/*" name="btn_submit" id="btnImgReal" type="file" style="display: none;"/>
                    </form>
                </div>
            </div>
            <div class="image-grp">
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="title-grp">
                <h3>Thumbnail</h3>
                <div class="info-actions">
                    <i id="btnThumbFaux" class="fas fa-plus"></i>
                    <form action="">
                        <input class="file-path-wrapper" accept="image/*" name="btn_submit" id="btnThumbReal" type="file" style="display: none;"/>
                    </form>
                </div>
            </div>
            <div class="image-grp">
                <div class="image">
                    <img src="/images/thumb_default.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section class="section-listing-primary">
        <div class="container">
            <h3>Primary information</h3>
            <div class="listing-info-main">
                <div class="info-name">
                    <h1 class="name">{{ property.name }}</h1>
                    <div class="info-actions">
                        <i @click="click(editPrimaryRef)" class="fas fa-edit"></i>
                    </div>
                </div>
                <p v-if="property.sub_zone" class="location">{{ property.sub_zone.name }}, {{ property.sub_zone.zone.name }}, {{ property.sub_zone.zone.county.name }}</p>
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
                    <div class="listing-units-list">
                        <div class="title-grp">
                            <h3>Units available</h3>
                            <div class="info-actions">
                                <!-- <a href="/lister/manage-listing-unit.html">
                                    <i class="fas fa-plus"></i>
                                </a> -->
                                <i @click="click(createUnitRef)" class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="listing-units-grp">
                            <div class="card-sm card-unit">
                                <a href="/lister/manage-listing-unit.html">
                                    <div class="details">
                                        <h2>Unit title</h2>
                                        <div class="specs">
                                            <span class="spec">1 bed,</span>
                                            <span class="spec">2 bath,</span>
                                            <span class="spec">40sq M</span>
                                        </div>
                                        <div class="deposit">
                                            <span class="label">Initial deposit:</span>
                                            <span class="data">not required</span>
                                        </div>
                                        <div class="price">
                                            <span class="label">KES</span>
                                            <span class="data">0.00</span>
                                        </div>
                                        <p class="timestamp">Added 5 hours ago</p>
                                    </div>
                                    <div class="thumb"></div>
                                </a>  
                            </div>
                        </div>
                    </div>
                    <div class="lister-details">
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
                                <router-link :to="{ name: 'users.account' }" href="/manage-account">Manage brand <i class="fas fa-chevron-right"></i></router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div v-if="property.features && property.features.length" class="listing-features">
                        <div class="title-grp">
                            <h3>Communial features</h3>
                            <div class="info-actions">
                                <i @click="click(editFeaturesRef)" class="fas fa-edit"></i>
                            </div>
                        </div>
                        <div class="features">
                            <ul v-for="feature in property.features">
                                <li>{{ feature.item }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="listing-map">
                        <h3>Location</h3>
                        <div id="map"></div>
                    </div>
                    <div class="listing-actions">
                        <h3>Actions</h3>
                        <div class="btn-grp vertical">
                            <button>Submit for approval</button>
                            <button>Withdraw submission</button>
                            <button>Hide from public</button>
                            <button>Request removal from system</button>
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

const { property, route, getProperty } = propertiesMaster()
const createUnitRef = ref(null)
const editPrimaryRef = ref(null)
const editFeaturesRef = ref(null)

onBeforeMount(() => {
    getProperty(`/api/listings/my-listings/${route.params.slug}`)
})

function click(element) {
    element.openModal();
}

onMounted(() => {
})

</script>