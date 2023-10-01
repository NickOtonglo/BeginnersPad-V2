<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Add disclaimers</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form v-if="unit" @submit.prevent="saveDisclaimers(request, unit)">
                    <div class="form-group">
                        <label for="disclaimer">Edit disclaimers (each line represents a different disclaimer)</label>
                        <textarea v-model="unit.disclaimer" @click="click" ref="disclaimerRef" type="text" name="disclaimer" rows="5"
                         placeholder="e.g:
No pets allowed
Garbage collection day is Tuesday
...">
                        </textarea>
                        <div v-for="message in validationErrors?.disclaimer" class="txt-alert txt-danger">
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
import operateModal from '../../composables/modal'
import { ref, onBeforeMount, onMounted } from 'vue';
import unitsMaster from '../../composables/units';

const modalRef = ref(null)
const disclaimerRef = ref(null)
const { route, validationErrors, saveDisclaimers, getUnit, unit } = unitsMaster()
const request = ref(`/api/listings/${route.params.slug}/units/${route.params.unit_slug}/disclaimer`)

function openModal() {
    operateModal(modalRef.value)
    if (unit.value) {
        click()
    }
}

 function click() {
    let arr = unit.value.disclaimer
    disclaimerRef.value.value = arr.join(`\n`);
 }

onBeforeMount(() => {
    getUnit(`/api/listings/${route.params.slug}/units/${route.params.unit_slug}`)
})

// async onMounted(() => {
//     await console.log(unit.value)
// })

defineExpose({
    openModal,
})
</script>