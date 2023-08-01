<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Add zone</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="createZone(request, zone)" id="formCreateZone">
                    <div class="form-group" id="grpName">
                        <label for="name">Zone name*</label>
                        <input v-model="zone.name" type="text" name="name">
                        <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpCounty">
                        <label for="county">County*</label>
                        <select v-model="zone.county_code" name="county" id="county">
                            <option value="" selected>--select county--</option>
                            <template v-for="county in counties">
                                <option :value="county.code">{{ county.name }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.county_code" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpLat">
                        <label for="latitude">Latitude*</label>
                        <input v-model="zone.lat" type="number"  step="any" name="lat">
                        <div v-for="message in validationErrors?.lat" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpLong">
                        <label for="longitude">Longitude*</label>
                        <input v-model="zone.lng" type="number" step="any" name="lng">
                        <div v-for="message in validationErrors?.lng" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="zoneMap" style="height: 300px;margin: 15px 0;">
                        <div id="map2" style="height: 100%;"></div>
                    </div>
                    <div class="form-group" id="grpRadius">
                        <label for="radius">Radius (km)*</label>
                        <input v-model="zone.radius" type="number" name="radius">
                        <div v-for="message in validationErrors?.radius" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpTimezone">
                        <label for="timezone">Timezone*</label>
                        <input v-model="zone.timezone" type="text" name="timezone">
                        <div v-for="message in validationErrors?.timezone" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpDescription">
                        <label for="description">Description</label>
                        <textarea v-model="zone.description" type="text" name="description" cols="3"></textarea>
                        <div v-for="message in validationErrors?.description" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Create zone</span>
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
import { onMounted, ref, onBeforeUnmount } from 'vue';
import zonesMaster from '../../composables/zones';

const modalRef = ref(null)
const request = ref('api/zones')

const { zone, createZone, validationErrors, getCounties, counties } = zonesMaster()

function openModal() {
    operateModal(modalRef.value)
}

onMounted(() => {
    openModal()
    getCounties()
})

defineExpose({
    openModal,
})

</script>