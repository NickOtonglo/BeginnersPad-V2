<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Communial features</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="" id="formUpdateListingFeatures">
                    <div class="form-group" id="grpFeatures">
                        <label for="features">Features (seperate each item with a semicolon)</label>
                        <textarea v-model="property.features" type="text" name="features" cols="30" placeholder="e.g. CCTV; WiFi; ..."></textarea>
                        <div v-for="message in validationErrors?.features" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Update features</span>
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

</script>