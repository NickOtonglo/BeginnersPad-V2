<template>
    <div class="modal open" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Edit sub-zone</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="updateSubZone(request, subZone)">
                    <div class="form-group" id="grpName">
                        <label for="name">Sub-zone name*</label>
                        <input v-model="subZone.name" type="text" name="name">
                        <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpRole">
                        <label for="role">Role/nature of sub-zone*</label>
                        <select v-model="subZone.nature_id" name="role" id="role">
                            <option value="" selected>--select role--</option>
                            <template v-for="nature in natures">
                                <option :value="nature.id">{{ nature.category }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.nature_id" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpLat">
                        <label for="latitude">Latitude*</label>
                        <input v-model="subZone.lat" type="number"  step="any" name="lat">
                        <div v-for="message in validationErrors?.lat" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpLong">
                        <label for="longitude">Longitude*</label>
                        <input v-model="subZone.lng" type="number" step="any" name="lng">
                        <div v-for="message in validationErrors?.lng" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="zoneMap" style="height: 300px;margin: 15px 0;">
                        <Map :lat="subZone.lat" :lng="subZone.lng" :zoom="10" :circle="true" :circleRadius="subZone.radius" />
                    </div>
                    <div class="form-group" id="grpRadius">
                        <label for="radius">Radius (km)*</label>
                        <input v-model="subZone.radius" type="number" step="any" name="radius">
                        <div v-for="message in validationErrors?.radius" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpDescription">
                        <label for="description">Description</label>
                        <textarea v-model="subZone.description" type="text" name="description" cols="3"></textarea>
                        <div v-for="message in validationErrors?.description" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Update sub-zone</span>
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
import subZonesMaster from '../../composables/subzones';
import Map from '../Maps/Form.vue'

const modalRef = ref(null)

const { 
    subZone, 
    updateSubZone, 
    validationErrors, 
    getNatures, 
    natures, 
    route, 
    getSubZone 
} = subZonesMaster()

const request = ref(`/api/zones/${route.params.zone_id}/sub-zones/${route.params.sub_id}`)

function openModal() {
    operateModal(modalRef.value)
}

onMounted(() => {
    getSubZone(request.value)
    openModal()
    getNatures()
})

defineExpose({
    openModal,
})

</script>