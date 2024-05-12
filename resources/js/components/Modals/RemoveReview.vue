<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Remove review</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="removeReview(`${request}/${review.id}`, removalLog)">
                    <div class="form-group">
                        <label for="rating">General reason*</label>
                        <select v-model="removalLog.removal_reason" name="removal_reason">
                            <option value="" disabled>--select reason--</option>
                            <template v-for="reason in removalReasons">
                                <option :value="reason.reason">{{ reason.reason }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.removal_reason" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review">Detailed reason</label>
                        <textarea v-model="removalLog.reason_details" type="text" name="reason_details" rows="10"></textarea>
                        <div v-for="message in validationErrors?.reason_details" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Remove review</span>
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
import { onBeforeMount, ref } from 'vue';
import operateModal from '../../composables/modal'
import propertyReviewsMaster from '../../composables/property_reviews';

const modalRef = ref(null)
const { 
    removalReasons, 
    getRemovalReasons, 
    validationErrors, 
    route, 
    removalLog, 
    removalLogs,
    getRemovalLogs, 
    removeReview, 
} = propertyReviewsMaster()
let request = `/api/listings/${route.params.slug}/reviews`

function openModal() {
    operateModal(modalRef.value)
}

const props = defineProps({
    review: Object,
})

onBeforeMount(() => {
    getRemovalReasons(`/api/reviews/removal/reasons`)
})

defineExpose({
    openModal,
})

</script>