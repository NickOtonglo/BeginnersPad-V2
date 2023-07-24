<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Edit tag</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="updateTag(tag)" ref="form">
                    <div class="form-group">
                        <input v-model="tag.name" type="text" name="name" placeholder="Tag name">
                        <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Update tag</span>
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
import tagsMaster from '../../composables/tags';
import operateModal from '../../composables/modal'
import { onMounted, ref } from 'vue';
import { onBeforeUnmount } from 'vue';

const { getTag, tag, validationErrors, isLoading, updateTag } = tagsMaster()
const modalRef = ref(null)
// const props = defineProps(['tag'])

function openModal() {
    getTag(localStorage.getItem('tagName'))
    operateModal(modalRef.value)
}

onMounted(() => {
    openModal()
})

onBeforeUnmount(() => {
    localStorage.removeItem('tagName')
})

defineExpose({
    openModal,
})

</script>