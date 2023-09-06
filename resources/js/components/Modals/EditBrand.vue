<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Update brand</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="updateAvatar(user.brand, formAvatarRequest)">
                    <div class="img-grp rounded">
                        <input @change="setAvatar" type="file" name="avatar" ref="avatar">
                        <template v-if="user.brand">
                            <template v-if="user.brand.avatar">
                                <img :src="'/images/brand/avatar/' + user.username + '/' + user.brand.avatar" 
                                    alt=""
                                    @click="triggerFileInput" 
                                    ref="avatarHolder" 
                                    name="avatarHolder">
                            </template>
                            <template v-else>
                                <img src="/images/static/avatar.png" 
                                    alt=""
                                    @click="triggerFileInput" 
                                    ref="avatarHolder" 
                                    name="avatarHolder">
                            </template>
                            <button v-if="user" class="btn-link btn-close" type="button" @click="removeAvatar(formAvatarRequest)"><i class="fas fa-times"></i></button>
                        </template>
                    </div>
                    <p v-show="isLoading" style="text-align: center;"><div v-show="isLoading" class="lds-dual-ring"></div> Loading...</p>
                    <div v-for="message in validationErrors?.avatar" class="txt-alert txt-danger">
                        <li>{{ message }}</li>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit" :hidden="true" ref="formAvatarSubmit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Update</span>
                    </button>
                </form>
            </div>
            <div class="category">
                <h3>Brand details</h3>
                <form @submit.prevent="updateForm(user.brand, formBrandRequest)">
                    <template v-if="user.brand">
                        <div class="form-group">
                            <label for="username">Brand/company name</label>
                            <input v-model="user.brand.name" type="text" name="name">
                            <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                                <li>{{ message }}</li>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="statement">Statement/slogan</label>
                            <textarea v-model="user.brand.statement" type="text" name="statement" rows="8"></textarea>
                            <div v-for="message in validationErrors?.statement" class="txt-alert txt-danger">
                                <li>{{ message }}</li>
                            </div>
                        </div>
                    </template>
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
import { onMounted, ref } from 'vue';
import operateModal from '../../composables/modal'
import userMaster from '../../composables/users';
import { onBeforeMount } from 'vue';

const { user, getUserAccount, updateAvatar, removeAvatar, updateForm, validationErrors } = userMaster()
const modalRef = ref(null)
const avatar = ref(null)
const avatarHolder = ref(null)
const formAvatarSubmit = ref(null)
const formAvatarRequest = ref(`/api/brand/avatar`)
const formBrandRequest = ref(`/api/brand`)

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
    user.value.brand.avatar = selectedFile
    formAvatarSubmit.value.click()
}

onBeforeMount(() => {
    getUserAccount()
})

onMounted(() => {
    // openModal()
})

defineExpose({
    openModal,
})

</script>