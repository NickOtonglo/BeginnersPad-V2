<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Add unit</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="createUnit(formRequest, unit)" novalidate>
                    <div class="form-group" id="grpName">
                        <label for="name">Unit name*</label>
                        <input v-model="unit.name" type="text" name="name">
                        <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bedrooms">Number of bedrooms*</label>
                        <input v-model="unit.bedrooms" type="number" name="bedrooms">
                        <div v-for="message in validationErrors?.bedrooms" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bathrooms">Number of bathrooms*</label>
                        <input v-model="unit.bathrooms" type="number" name="bathrooms">
                        <div v-for="message in validationErrors?.bathrooms" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="floor_area">Floor area (sq M)*</label>
                        <input v-model="unit.floor_area" type="number" name="floor_area">
                        <div v-for="message in validationErrors?.floor_area" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="init_deposit">Initial deposit amount (KES)*</label>
                        <input v-model="unit.init_deposit" @change="toggleInput" ref="initDepositRef" type="number" name="init_deposit" placeholder=" enter 0 if deposit not required">
                        <div v-for="message in validationErrors?.init_deposit" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" ref="initDepositPeriodRef">
                        <label for="init_deposit_period">Initial deposit period (months)*</label>
                        <input v-model="unit.init_deposit_period" type="number" min="1" name="init_deposit_period">
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
                        <span v-else>Create unit</span>
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
import { ref } from 'vue';
import unitsMaster from '../../composables/units';

const { 
    createUnit, 
    unit, 
    validationErrors, 
    isLoading, 
    route 
} = unitsMaster()

const initDepositRef = ref(null)
const initDepositPeriodRef = ref(null)

const formRequest = `/api/listings/${route.params.slug}/`

const modalRef = ref(null)

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

defineExpose({
    openModal,
})

</script>
