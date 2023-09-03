<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Communial features</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="saveFeatures(request, feature)">
                    <div class="form-group" id="grpFeatures">
                        <label for="feature">Add features (each line represents a different feature)</label>
                        <textarea v-model="feature.item" type="text" name="feature" rows="5"
                         placeholder="e.g:
CCTV
WiFi
...">
                        </textarea>
                        <div v-for="message in validationErrors?.item" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
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
import { ref } from 'vue';
import operateModal from '../../composables/modal'
import propertiesMaster from '../../composables/properties';

const { route, validationErrors, saveFeatures } = propertiesMaster()
const modalRef = ref(null)
const request = ref(`/api/listings/${route.params.slug}/features`)
const feature = ref({})

function openModal() {
    operateModal(modalRef.value)
}

defineExpose({
    openModal,
})

</script>