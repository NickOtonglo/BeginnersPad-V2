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
                    <img src="/images/thumb_unit.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_unit.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_unit.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_unit.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_unit.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_unit.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_unit.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="image">
                    <img src="/images/thumb_unit.jpg" alt="">
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
                    <img src="/images/thumb_unit.jpg" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section class="section-unit-main" id="listerUnitMain">
        <div class="container">
            <div class="main-info">
                <div class="title-grp">
                    <h2>{{ unit.name }}</h2>
                    <div class="info-actions">
                        <i @click="click(editPrimaryRef)" class="fas fa-edit"></i>
                        <i class="fas fa-share-alt"></i>
                        <i class="fas fa-heart"></i>
                    </div>
                </div>
                <p class="price">KES {{ unit.price }}</p>
                <p v-if="unit.init_deposit == 0" class="deposit">Initial deposit: not required</p>
                <p v-else class="deposit">Initial deposit: {{ unit.init_deposit }} (for {{ unit.init_deposit_period }} months)</p>
                <p class="floor">Floor/story: {{ unit.story }}</p>
                <p v-if="unit.description" class="description">{{ unit.description }}</p>
            </div>
        </div>
    </section>

    <section class="section-unit-secondary">
        <div class="container">
            <div class="panel-grp">
                <div class="panel">
                    <div class="listing-features">
                        <div class="title-grp">
                            <h3>Unit features</h3>
                            <div class="info-actions">
                                <i @click="click(editFeaturesRef)" class="fas fa-edit"></i>
                            </div>
                        </div>
                        <div v-if="unit.features.length" class="features">
                            <ul v-for="feature in unit.features">
                                <li><span><i @click="removeFeature(`/api/listings/${unit.property.slug}/units/${unit.slug}/features/${feature.id}`)" id="feature-delete" class="fas fa-times"></i> {{ feature.item }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="unit-disclaimer">
                        <div class="title-grp">
                            <h3>Disclaimer (important)</h3>
                            <div class="info-actions">
                                <i @click="click(editDisclaimersRef)" class="fas fa-edit"></i>
                            </div>
                        </div>
                        <div v-if="unit.disclaimer.length" class="features">
                            <ul v-for="item in unit.disclaimer">
                                <li><span>{{ item }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div class="listing-units-list">
                        <h3>Property</h3>
                        <div class="card-sm card-2" v-if="unit && unit.property">
                            <router-link :to="{ name: 'property.manage', params: {slug: unit.property.slug } }">
                                <template v-if="unit.property.thumbnail">
                                    <div class="thumb" :style="{ background: `url(/images/listings/${unit.property.slug}/${unit.property.thumbnail})` }" style="background-size: cover;"></div>
                                </template>
                                <template v-else>
                                    <div class="thumb"></div>
                                </template>
                                <div class="details">
                                    <h2>{{ unit.property.name }}</h2>
                                    <div class="location">
                                        <span class="spec">{{ unit.property.sub_zone.name }}, </span>
                                        <span class="spec">{{ unit.property.sub_zone.zone.county.name }}</span>
                                    </div>
                                    <p class="timestamp">Added {{ unit.property.time_ago }}</p>
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
                            </router-link>  
                        </div>
                    </div>
                    <div class="listing-actions">
                        <h3>Actions</h3>
                        <div class="btn-grp vertical">
                            <button>Activate</button>
                            <button>Deactivate (hide)</button>
                            <button @click="">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <EditUnitPrimary ref="editPrimaryRef" />
    <EditUnitFeatures ref="editFeaturesRef"/>
    <EditUnitDisclaimers ref="editDisclaimersRef"/>
</template>

<script setup>
import unitsMaster from '../../composables/units';
import { onBeforeMount, ref } from 'vue';
import EditUnitPrimary from '../Modals/EditUnitPrimary.vue';
import EditUnitFeatures from '../Modals/EditUnitFeatures.vue';
import EditUnitDisclaimers from '../Modals/EditUnitDisclaimers.vue'

const { 
    unit, 
    route, 
    getUnit, 
    removeFeature, 
    removeUnit,
    uploadFiles, 
    removeFile, 
    uploadThumb
} = unitsMaster()

const editPrimaryRef = ref(null)
const editFeaturesRef = ref(null)
const editDisclaimersRef = ref(null)
const fileInputRef = ref(null)
const formFilesSubmit = ref(null)
const formFileRequest = ref(`/api/listings/${route.params.slug}/files`)
const files = ref({})
const thumbInputRef = ref(null)
const formThumbSubmit = ref(null)
const formThumbRequest = ref(`/api/listings/${route.params.slug}/thumbnail`)
const thumb = ref(null)

onBeforeMount(() => {
    getUnit(`/api/listings/${route.params.slug}/units/${route.params.unit_slug}`)
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

</script>

<style scoped>
.features li {
    margin: 6px 0;
    list-style-position: inside;
}
.features li:hover {
    /* outline: 2px solid var(--color-font); */
    padding: 2px 4px;
    border-radius: 5px;
    cursor: pointer;
    opacity: .8;
}
#feature-delete {
    display: none;
}
#feature-delete:hover {
    color: var(--color-danger);
}
.features li:hover #feature-delete {
    display: inline-block;
}
.features form {
    padding: 0;
    margin: 0;
}
</style>