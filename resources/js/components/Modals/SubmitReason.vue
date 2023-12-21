<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Submit reason</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="$emit('reasonSubmitted', log.comment, action)">
                    <div class="form-group">
                        <label for="comment">Give a reason for action: {{ action }}*</label>
                        <textarea v-model="log.comment" type="text" name="comment" rows="5" required></textarea>
                        <div v-for="message in validationErrors?.comment" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Submit</span>
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
import { ref } from 'vue';
import operateModal from '../../composables/modal'
import propertiesMaster from '../../composables/properties'

const modalRef = ref(null)
const { log } = propertiesMaster()

const props = defineProps({
    action: String,
})

function openModal() {
    operateModal(modalRef.value)
}

defineExpose({
    openModal,
})

</script>