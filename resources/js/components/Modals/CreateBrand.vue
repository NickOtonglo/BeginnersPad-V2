<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Create brand</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="saveBrand(brand, formBrandRequest)">
                    <div class="img-grp rounded">
                        <input @change="setAvatar" type="file" name="avatar" ref="avatar">
                        <img src="/images/static/avatar.png" 
                                alt=""
                                @click="triggerFileInput" 
                                ref="avatarHolder" 
                                name="avatarHolder">
                    </div>
                    <p v-show="isLoading" style="text-align: center;"><div v-show="isLoading" class="lds-dual-ring"></div> Loading...</p>
                    <div v-for="message in validationErrors?.avatar" class="txt-alert txt-danger">
                        <li>{{ message }}</li>
                    </div>
                    <div class="form-group">
                        <label for="username">Brand/company name</label>
                        <input v-model="brand.name" type="text" name="name" id="name">
                        <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="statement">Statement/slogan</label>
                        <textarea v-model="brand.statement" type="text" name="statement" rows="8"></textarea>
                        <div v-for="message in validationErrors?.statement" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
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
import { onMounted, ref } from 'vue';
import operateModal from '../../composables/modal'
import userMaster from '../../composables/users';

const { saveBrand, validationErrors } = userMaster()
const modalRef = ref(null)
const avatar = ref(null)
const avatarHolder = ref(null)
const formAvatarSubmit = ref(null)
const formAvatarRequest = ref(`/api/brand/avatar`)
const formBrandRequest = ref(`/api/brand`)
const brand = ref({})

function openModal() {
    operateModal(modalRef.value)
}

function triggerFileInput() {
    avatar.value.click()
}

function setAvatar(event) {
    // get image frim <input> and set src in <img>
    var selectedFile = event.target.files[0]
    var reader = new FileReader()
    var placeHolder = avatarHolder.value

    reader.onload = ((event) => {
        placeHolder.src = event.target.result
    })

    reader.readAsDataURL(selectedFile)
    brand.value.avatar = selectedFile
}

onMounted(() => {
    // openModal()
})

defineExpose({
    openModal,
})

</script>