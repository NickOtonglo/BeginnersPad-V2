<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Edit tag</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="updateTicket(`${request}/${ticket.id}`, ticket)" ref="form">
                    <div class="form-group">
                        <label for="topic">Help category*</label>
                        <select v-model="ticket.topic" name="topic" id="topic">
                            <option value="" disabled>--select category--</option>
                            <template v-for="item in topics">
                                <option :value="item.category">{{ item.category }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.topic" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Text (describe problem in detail)*</label>
                        <textarea v-model="ticket.description" type="text" name="description" rows="10"></textarea>
                        <div v-for="message in validationErrors?.description" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Update</span>
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
import ticketsMaster from '../../composables/tickets';
import operateModal from '../../composables/modal'
import { ref, onBeforeMount } from 'vue';

const { validationErrors, isLoading, updateTicket, deleteTicket, topics, getTopics } = ticketsMaster()
const modalRef = ref(null)
let request = `/api/help/tickets`

const props = defineProps({
    ticket: Object,
})

onBeforeMount(() => {
    getTopics(`/api/help/topics`)
})

function openModal() {
    operateModal(modalRef.value)
}

defineExpose({
    openModal,
})

</script>