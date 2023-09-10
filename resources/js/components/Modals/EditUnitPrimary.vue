<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Edit primary information</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form v-if="unit" @submit.prevent="updateUnit(request, unit)">
                    <div class="form-group" id="grpName">
                        <label for="name">Unit name*</label>
                        <input v-model="unit.name" type="text" name="name">
                        <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group" id="grpDescription">
                        <label for="description">Description</label>
                        <textarea v-model="unit.description" type="text" name="description" rows="6"></textarea>
                        <div v-for="message in validationErrors?.description" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">Floor/story*</label>
                        <input v-model="unit.story" type="number" name="story" placeholder="floor in which the unit is located">
                        <div v-for="message in validationErrors?.story" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bedrooms">Number of bedrooms*</label>
                        <input v-model="unit.bedrooms" type="number" min="0" name="bedrooms">
                        <div v-for="message in validationErrors?.bedrooms" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bathrooms">Number of bathrooms*</label>
                        <input v-model="unit.bathrooms" type="number" min="0" name="bathrooms">
                        <div v-for="message in validationErrors?.bathrooms" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="floor_area">Floor area (sq M)*</label>
                        <input v-model="unit.floor_area" type="number" min="1" name="floor_area">
                        <div v-for="message in validationErrors?.floor_area" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="init_deposit">Initial deposit amount (KES)*</label>
                        <input v-model="unit.init_deposit" @change="toggleInput" ref="initDepositRef" type="number" min="0" name="init_deposit" placeholder=" enter 0 if deposit not required">
                        <div v-for="message in validationErrors?.init_deposit" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" ref="initDepositPeriodRef" :hidden="unit.init_deposit == 0">
                        <label for="init_deposit_period">Initial deposit period (months)*</label>
                        <input v-model="unit.init_deposit_period" type="number" min="0" name="init_deposit_period">
                        <div v-for="message in validationErrors?.init_deposit_period" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">Monthly rent (KES)*</label>
                        <input v-model="unit.price" type="number" min="1" name="price">
                        <div v-for="message in validationErrors?.price" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
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
import { ref, onBeforeMount } from 'vue';
import unitsMaster from '../../composables/units';

const modalRef = ref(null)
const { updateUnit, getUnit, route, unit, validationErrors, isLoading } = unitsMaster()
// const request = ref(`/api/listings/${route.params.slug}/units/${route.params.unit_slug}`)
const request = ref(`/api/listings/${route.params.slug}/units/${route.params.unit_slug}`)
const initDepositRef = ref(null)
const initDepositPeriodRef = ref(null)

function openModal() {
    operateModal(modalRef.value)
}

function toggleInput() {
    if (initDepositRef.value.value == 0 || initDepositRef.value.value == '') {
        initDepositPeriodRef.value.hidden = true
        unit.value.init_deposit_period = 0
    } else {
        initDepositPeriodRef.value.hidden = false
    }
}

onBeforeMount(() => {
    getUnit(request.value)
})

defineExpose({
    openModal,
})
</script>