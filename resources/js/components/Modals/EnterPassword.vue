<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Confirm your password</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <form @submit.prevent="checkPassword(user)">
                <div class="form-group" id="grpNewPass">
                    <label for="password">Password</label>
                    <input v-model="user.password" type="password" name="password" id="password">
                    <div v-for="message in validationErrors?.password" class="txt-alert txt-danger">
                        <li>{{ message }}</li>
                    </div>
                </div>
                <button :disabled="isLoading" class="btn-submit" type="submit">
                    <div v-show="isLoading" class="lds-dual-ring"></div>
                    <span v-if="isLoading">Loading...</span>
                    <span v-else>Confirm</span>
                </button>
            </form>
        </div>
        <div class="modal-footer">
            <button @click="operateModal(modalRef)" id="modalFooterClose" ref="closeModalRef" class="btn btn-link">Close</button>
        </div>
    </div>
</template>

<script setup>
import { onBeforeUpdate, ref, watch } from 'vue';
import operateModal from '../../composables/modal'
import userMaster from '../../composables/users';

const modalRef = ref(null)
const closeModalRef = ref(null)
const {
    user, 
    secret, 
    validationErrors, 
    checkPassword, 
} = userMaster()
const emit = defineEmits(['secretCheck'])

function openModal() {
    operateModal(modalRef.value)
}

function confirmResponseOk() {
    if (secret.value.status == 201) {
        emit('secretCheck', secret.value.status)
    }
}

watch(secret, (current, previous) => {
    confirmResponseOk()
})

defineExpose({
    openModal,
})

</script>