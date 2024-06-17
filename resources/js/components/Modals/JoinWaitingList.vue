<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Join waiting list</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="addWaitingList(`/api/premium/plans/waiting-list`, waitingList)">
                    <div class="form-group">
                        <label for="county">County*</label>
                        <select v-if="counties" v-model="waitingList.county" @change="getCountyZones()" name="county" id="county">
                            <option value="" disabled selected>--select county--</option>
                            <template v-for="county in counties">
                                <option :value="county.code" selected>{{ county.name }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.county" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <template v-if="countyCode">
                        <div v-if="zones && zones.length" class="form-group">
                            <label for="zone">Zone*</label>
                            <select v-model="waitingList.zone_id" name="zone_id">
                                <option value="" disabled selected>--select zone--</option>
                                <template v-for="zone in zones">
                                    <option :value="zone.id" >{{ zone.name }}</option>
                                </template>
                            </select>
                            <div v-for="message in validationErrors?.zone_id" class="txt-alert txt-danger">
                                <li>{{ message }}</li>
                            </div>
                        </div>
                        <div v-else class="form-group">
                            <p>--no zones available in this county--</p>
                        </div>
                    </template>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Save</span>
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
import { ref, onBeforeMount } from 'vue';
import operateModal from '../../composables/modal'
import zonesMaster from '../../composables/zones';
import premiumMaster from '../../composables/premium';

const {
    isLoading, 
    zones, 
    counties, 
    getZones, 
    getCounties, 
} = zonesMaster()

const {
    waitingList, 
    addWaitingList, 
    removeWaitingList, 
    validationErrors, 
} = premiumMaster()

const modalRef = ref(null)
const countyCode = ref(null)

function getCountyZones() {
    var selectBox = document.querySelector('#county')
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    countyCode.value = selectedValue

    getZones(`/api/counties/${selectedValue}/zones`)
}

function openModal() {
    operateModal(modalRef.value)
}

onBeforeMount(() => {
    getCounties(`/api/zones/counties`)
})

defineExpose({
    openModal,
})

</script>