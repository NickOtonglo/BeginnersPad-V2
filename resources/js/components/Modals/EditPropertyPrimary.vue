<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Edit primary information</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="updateProperty(request, property)">
                    <div class="form-group" id="grpName">
                        <label for="name">Property name*</label>
                        <input v-model="property.name" type="text" name="name">
                        <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpDescription">
                        <label for="description">Description</label>
                        <textarea v-model="property.description" type="text" name="description" rows="6"></textarea>
                        <div v-for="message in validationErrors?.description" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpZone">
                        <label for="zone">Zone*</label>
                        <select v-if="property.sub_zone" v-model="property.sub_zone.zone.id" @change="getSubZones(zone)" name="zone" id="zone">
                            <option value="" disabled>--select zone--</option>
                            <template v-for="zone in zones">
                                <option :value="zone.id" selected>{{ zone.name }} ({{ zone.county.name }})</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.zone" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpSubZone">
                        <label for="sub_zone_id">Sub-zone*</label>
                        <select v-if="property.sub_zone" v-model="property.sub_zone_id" name="sub_zone_id" id="sub_zone_id">
                            <option value="" disabled selected>--select sub-zone--</option>
                            <template v-for="subZone in subZones">
                                <option :value="subZone.id" >{{ subZone.name }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.sub_zone_id" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="zoneMap" style="height: 300px;margin: 15px 0;">
                        <div id="map2" style="height: 100%;"></div>
                    </div>
                    <div class="form-group" id="grpLat">
                        <label for="latitude">Latitude*</label>
                        <input v-model="property.lat" type="number"  step="any" name="lat">
                        <div v-for="message in validationErrors?.lat" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpLong">
                        <label for="longitude">Longitude*</label>
                        <input v-model="property.lng" type="number" step="any" name="lng">
                        <div v-for="message in validationErrors?.lng" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stories">Number of floors/stories*</label>
                        <input v-model="property.stories" type="number" name="stories">
                        <div v-for="message in validationErrors?.stories" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Update primary info</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button @click="operateModal(modalRef)" id="modalFooterClose" class="btn btn-link">Close</button>
        </div>
    </div>
</template>

<script setup>
import operateModal from '../../composables/modal'
import { onMounted, ref } from 'vue';
import propertiesMaster from '../../composables/properties';
import zonesMaster from '../../composables/zones';
import subZonesMaster from '../../composables/subzones';
import { onBeforeMount } from 'vue';

const { updateProperty, getProperty, route, property, validationErrors } = propertiesMaster()

const modalRef = ref(null)
const request = ref(`/api/listings/${route.params.slug}`)
const isLoading = ref('')
const zones = ref({})
const subZones = ref({})
const zone = ref('')

function getZones() {
    if (isLoading.value) return
    isLoading.value = true
    validationErrors.value = false

    axios.get('/api/zones')
        .then(response => {
            zones.value = response.data.data
        })
        .catch(error => console.log(error))
        .finally(isLoading.value = false)
}

function preLoadSubZones() {
    if (isLoading.value) return
    isLoading.value = true
    validationErrors.value = false
    let p = ref('')

    axios.get(`/api/listings/my-listings/${route.params.slug}`)
        .then(response => {
            p.value = response.data.data
            axios.get(`/api/zones/${p.value.sub_zone.zone.id}/sub-zones`)
                .then(response => {
                    subZones.value = response.data.data
                })
                .catch(error => console.log(error))
                .finally(isLoading.value = false)
        })
        .catch(error => console.log(error))
        .finally(isLoading.value = false)
}

function getSubZones() {
    var selectBox = document.querySelector('#zone')
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;

    if (isLoading.value) return
    isLoading.value = true
    validationErrors.value = false

    axios.get(`/api/zones/${selectedValue}/sub-zones`)
        .then(response => {
            subZones.value = response.data.data
            property.value.sub_zone_id = ''
            // property.value.sub_zone.id = ''
        })
        .catch(error => console.log(error))
        .finally(isLoading.value = false)
}

function checkName() {
    validationErrors.value.name = ''
    if (property.value.name == '') {
        validationErrors.value.name = 'The name field is required.'
    } else {
        createProperty(request, property)
        // router.push({ name: 'property.create', params: { name: property.value.name } })
    }
}

function openModal() {
    operateModal(modalRef.value)
}

onBeforeMount(() => {
    getZones()
    preLoadSubZones()
    getProperty(`/api/listings/my-listings/${route.params.slug}`)
})

onMounted(() => {
    // openModal()
})

defineExpose({
    openModal,
})

</script>