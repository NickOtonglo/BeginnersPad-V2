<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Add listing</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="createProperty(request, property)" id="formCreateListing">
                    <div class="form-group" id="grpName">
                        <label for="name">Property name*</label>
                        <input v-model="property.name" type="text" name="name">
                        <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpZone">
                        <label for="zone">Zone*</label>
                        <select v-model="zone.name" @change="getSubZones(zone.name)" name="zone" id="zone">
                            <option value="" disabled selected>--select zone--</option>
                            <template v-for="zone in zones">
                                <option :value="zone.id">{{ zone.name }} ({{ zone.county.name }})</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.zone" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpSubZone">
                        <label for="sub_zone_id">Sub-zone*</label>
                        <select v-model="property.sub_zone_id" name="sub_zone_id" id="sub_zone_id">
                            <option value="" disabled selected>--select sub-zone--</option>
                            <template v-for="subZone in subZones">
                                <option :value="subZone.id">{{ subZone.name }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.sub_zone_id" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Create property</span>
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

const { createProperty, property, validationErrors } = propertiesMaster()
const { getZone } = zonesMaster()
const {} = subZonesMaster()

const modalRef = ref(null)
const request = ref('/api/listings')
const isLoading = ref('')
const zones = ref({})
const subZones = ref({})
const zone = ref({
    name: '',
    lat: null,
    lng: null,
    radius: null,
    timezone: '',
    description: '',
    county_code: '',
    county: {
        code: '',
        name: '',
    },
})

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

function getSubZones(zone_id) {
    if (isLoading.value) return
    isLoading.value = true
    validationErrors.value = false

    axios.get(`/api/zones/${zone_id}/sub-zones`)
        .then(response => {
            subZones.value = response.data.data
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

onMounted(() => {
    openModal()
    getZones()
})

defineExpose({
    openModal,
})

</script>