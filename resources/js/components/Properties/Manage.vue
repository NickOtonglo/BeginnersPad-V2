<template>
    <section class="section-listing-images">
        <div class="container">
            <div class="title-grp">
                <h3>Images</h3>
                <div class="info-actions">
                    <i @click="fileInputRef.click()" class="fas fa-plus"></i>
                    <form @submit.prevent="uploadFiles(formFileRequest, fileInputRef)">
                        <input @change="setFiles('files')" 
                                ref="fileInputRef" 
                                name="files"
                                accept="image/*" 
                                type="file" 
                                :multiple="true" 
                                :hidden="true" />
                        <button :disabled="isLoading" class="btn-submit" type="submit" :hidden="true" ref="formFilesSubmit">
                            <div v-show="isLoading" class="lds-dual-ring"></div>
                            <span v-if="isLoading">Loading...</span>
                            <span v-else>Upload</span>
                        </button>
                    </form>
                </div>
            </div>
            <template v-if="property.files">
                <div class="image-grp">
                    <div class="image" v-for="file in property.files">
                        <img :src="'/images/listings/' + property.slug + '/' + file.name" height="200" alt="">
                        <button @click="removeFile(`/api/listings/${route.params.slug}/files/${file.id}`)" class="btn-link btn-close"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </template>
            <div class="title-grp">
                <h3>Thumbnail</h3>
                <div class="info-actions">
                    <i @click="thumbInputRef.click()" class="fas fa-plus"></i>
                    <form @submit.prevent="uploadThumb(formThumbRequest, thumbInputRef)">
                        <input @change="setFiles('thumb')" 
                                ref="thumbInputRef" 
                                name="thumb"
                                accept="image/*" 
                                type="file" 
                                :hidden="true" />
                        <button :disabled="isLoading" class="btn-submit" type="submit" :hidden="true" ref="formThumbSubmit">
                            <div v-show="isLoading" class="lds-dual-ring"></div>
                            <span v-if="isLoading">Loading...</span>
                            <span v-else>Upload</span>
                        </button>
                    </form>
                </div>
            </div>
            <template v-if="property.thumbnail">
                <div class="image-grp">
                    <div class="image">
                        <img :src="'/images/listings/' + property.slug + '/' + property.thumbnail" height="200" alt="">
                    </div>
                </div>
            </template>
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
                                <i @click="click(createUnitRef)" class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="listing-units-grp">
                            <template v-if="property.units" v-for="unit in property.units">
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
                                            <div class="thumb" :style="{ background: `url(/images/listings/${property.slug}/units/${unit.slug}/${unit.thumbnail})` }" style="background-size: cover;"></div>
                                        </template>
                                        <template v-else>
                                            <div class="thumb" :style="{ background: `url(/images/static/thumb_unit.jpg` }" style="background-size: cover;"></div>
                                        </template>
                                    </router-link>  
                                </div>
                            </template>
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
                                <i @click="click(editFeaturesRef)" class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="features">
                            <ul v-for="feature in property.features">
                                <li><span><i @click="removeFeature(`/api/listings/${route.params.slug}/features/${feature.id}`)" id="feature-delete" class="fas fa-times"></i> {{ feature.item }}</span></li>
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

const { 
    property, 
    route, 
    getProperty, 
    removeFeature, 
    uploadFiles, 
    removeFile, 
    uploadThumb
} = propertiesMaster()
const createUnitRef = ref(null)
const editPrimaryRef = ref(null)
const editFeaturesRef = ref(null)
const fileInputRef = ref(null)
const formFilesSubmit = ref(null)
const formFileRequest = ref(`/api/listings/${route.params.slug}/files`)
const files = ref({})
const thumbInputRef = ref(null)
const formThumbSubmit = ref(null)
const formThumbRequest = ref(`/api/listings/${route.params.slug}/thumbnail`)
const thumb = ref(null)

onBeforeMount(() => {
    getProperty(`/api/listings/my-listings/${route.params.slug}`)
})

function click(element) {
    element.openModal();
}

function setFiles(src) {
    if (src == 'files') {
        // var selectedFile = event.target.files
        var selectedFile = fileInputRef.value.files
        files.value = selectedFile
        formFilesSubmit.value.click()
    } else if (src == 'thumb') {
        var selectedFile = thumbInputRef.value.files
        thumb.value = selectedFile
        formThumbSubmit.value.click()
    }
}

onMounted(() => {
})

</script>

<style scoped>
.features li {
    margin: 6px 0;
    list-style-position: inside;
}
.features span:hover {
    border: 2px solid var(--color-font);
    padding: 2px 4px;
    border-radius: 5px;
    cursor: pointer;
}
#feature-delete {
    display: none;
}
#feature-delete:hover {
    color: var(--color-danger);
}
.features span:hover #feature-delete {
    display: inline-block;
}
.features form {
    padding: 0;
    margin: 0;
}
</style>