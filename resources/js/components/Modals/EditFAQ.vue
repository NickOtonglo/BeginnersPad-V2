<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Edit FAQ</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="updateFaq(`${request}/${faq.id}`, faq)">
                    <div class="form-group">
                        <label for="review">Question*</label>
                        <textarea v-model="faq.question" type="text" name="question" rows="5"></textarea>
                        <div v-for="message in validationErrors?.question" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review">Answer*</label>
                        <textarea v-model="faq.answer" type="text" name="answer" rows="10"></textarea>
                        <div v-for="message in validationErrors?.answer" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Save</span>
                    </button>
                    <button :disabled="isLoading" type="button" @click="deleteFaq(`${request}/${faq.id}`)" class="btn-danger">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Delete</span>
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
import faqsMaster from '../../composables/faqs';

const modalRef = ref(null)
const { updateFaq, deleteFaq, validationErrors, route } = faqsMaster()
const request = `/api/help/faq`

const props = defineProps({
    faq: Object,
})

function openModal() {
    operateModal(modalRef.value)
}

defineExpose({
    openModal,
})

</script>