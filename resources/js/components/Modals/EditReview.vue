<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Edit review</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="updateReview(`${request}/${review.id}`, review)">
                    <div class="form-group">
                        <label for="rating">Rating*</label>
                        <select v-model="review.rating" name="rating">
                            <option value="" disabled>--select rating--</option>
                            <option value="1.00">1/5</option>
                            <option value="2.00">2/5</option>
                            <option value="3.00">3/5</option>
                            <option value="4.00">4/5</option>
                            <option value="5.00">5/5</option>
                        </select>
                        <div v-for="message in validationErrors?.rating" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review">Review*</label>
                        <textarea v-model="review.review" type="text" name="review" rows="10"></textarea>
                        <div v-for="message in validationErrors?.review" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Update</span>
                    </button>
                    <button :disabled="isLoading" type="button" @click="deleteReview(`${request}/${review.id}`)" class="btn-danger">
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
import propertyReviewsMaster from '../../composables/property_reviews';

const modalRef = ref(null)
const { updateReview, deleteReview, validationErrors, route } = propertyReviewsMaster()
let request = `/api/listings/${route.params.slug}/reviews`
// let request = `/api/listings/${route.params.slug}/reviews/${props.review.id}`

function openModal() {
    operateModal(modalRef.value)
}

const props = defineProps({
    review: Object,
})

defineExpose({
    openModal,
})

</script>