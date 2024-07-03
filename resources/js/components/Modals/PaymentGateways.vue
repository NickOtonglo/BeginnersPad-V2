<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Credit top-up</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="">
                    <div v-if="gateways" class="form-group">
                        <h4>Payment gateway*</h4>
                        <div v-for="gateway in gateways" class="radio-grp">
                            <input v-model="gateway.id" type="radio" name="gateway" :id="gateway.id" :value="gateway.name" @change="radiOption.name = gateway.name">
                            <span><label :for="gateway.id">{{ gateway.name }}</label></span>
                        </div>
                        <div v-for="message in validationErrors?.question" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div v-if="radiOption.name == 'M-Pesa'">
                        <PaymentMpesa ref="paymentMpesa" />
                    </div>
                    <div v-if="radiOption.name == 'Credit/Debit card'">
                        <p>Credit/Debit card</p>
                    </div>
                    <div v-if="radiOption.name == 'PayPal'">
                        <p>PayPal</p>
                    </div>
                    <div v-if="radiOption.name == 'Airtel Money'">
                        <p>Airtel Money</p>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Verify payment</span>
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
import { onMounted, ref } from 'vue';
import operateModal from '../../composables/modal'
import transactionsMaster from '../../composables/transactions';
import PaymentMpesa from '../Cards/PaymentMpesa.vue';

const modalRef = ref(null)
const { getPaymentGateways, gateways } = transactionsMaster()
const request = `/api/payment-gateways`
const radiOption = ref({
    name: '',
})

const paymentMpesa = ref(null)

function openModal() {
    operateModal(modalRef.value)
}

defineExpose({
    openModal,
})

onMounted(() => {
    getPaymentGateways(request)
})

</script>