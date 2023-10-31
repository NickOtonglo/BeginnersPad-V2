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
            <template v-if="unit.files">
                <div class="image-grp">
                    <div class="image" v-for="file in unit.files">
                        <img :src="`/images/listings/${unit.property.slug}/${unit.slug}/${file.name}`" height="200" alt="">
                        <button @click="removeFile(`/api/listings/${unit.property.slug}/units/${unit.slug}/files/${file.id}`)" class="btn-link btn-close">
                            <i class="fas fa-times"></i>
                        </button>
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
            <template v-if="unit.thumbnail">
                <div class="image-grp">
                    <div class="image">
                        <img :src="`/images/listings/${unit.property.slug}/${unit.slug}/${unit.thumbnail}`" height="200" alt="">
                    </div>
                </div>
            </template>
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
                        <div class="features">
                            <ul>
                                <li><span>{{ unit.bathrooms }} bathrooms</span></li>
                                <li><span>{{ unit.bedrooms }} bedrooms</span></li>
                                <li><span>{{ unit.floor_area }} sq M floor area</span></li>
                                <template v-if="unit.features.length" v-for="feature in unit.features">
                                    <li><span><i @click="removeFeature(`/api/listings/${unit.property.slug}/units/${unit.slug}/features/${feature.id}`)" id="feature-delete" class="fas fa-times"></i> {{ feature.item }}</span></li>
                                </template>
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
                        <CardProperty :property="unit.property" />
                    </div>
                    <div class="listing-actions">
                        <h3>Actions</h3>
                        <div class="btn-grp vertical">
                            <button>Activate</button>
                            <button>Deactivate (hide)</button>
                            <button @click="deleteUnit(deleteRequest)">Delete</button>
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
import CardProperty from '../Cards/Property2.vue';

const { 
    unit, 
    route, 
    getUnit, 
    removeFeature, 
    deleteUnit,
    uploadFiles, 
    removeFile, 
    uploadThumb
} = unitsMaster()

const editPrimaryRef = ref(null)
const editFeaturesRef = ref(null)
const editDisclaimersRef = ref(null)
const fileInputRef = ref(null)
const formFilesSubmit = ref(null)
const formFileRequest = ref(`/api/listings/${route.params.slug}/units/${route.params.unit_slug}/files`)
const files = ref({})
const thumbInputRef = ref(null)
const formThumbSubmit = ref(null)
const formThumbRequest = ref(`/api/listings/${route.params.slug}/units/${route.params.unit_slug}/thumbnail`)
const thumb = ref(null)
const deleteRequest = ref(`/api/listings/${route.params.slug}/units/${route.params.unit_slug}`)

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