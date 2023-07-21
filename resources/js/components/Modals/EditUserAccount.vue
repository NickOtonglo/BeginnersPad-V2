<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Update account</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="submitAvatar(credentials)">
                    <div class="img-grp rounded">
                        <input @change="setAvatar" type="file" name="avatar" ref="avatar">
                        <template v-if="credentials.avatar">
                            <img :src="'/images/user/avatar/' + credentials.username + '/' + credentials.avatar" 
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
                        
                        <button v-if="credentials.avatar" class="btn-link btn-close" type="button" @click="removeAvatar"><i class="fas fa-times"></i></button>
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
                <h3>Account details</h3>
                <form @submit.prevent="submitAccountForm(credentials)">
                    <div class="form-group" id="grpNames">
                        <div class="name-grp">
                            <div class="name">
                                <label for="fname">First name</label>
                                <input v-model="credentials.firstname" type="text" name="firstname" id="firstname">
                                <div v-for="message in validationErrors?.firstname" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                            <div class="name">
                                <label for="lname">Last name</label>
                                <input v-model="credentials.lastname" type="text" name="lastname" id="lastname">
                                <div v-for="message in validationErrors?.lastname" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="grpEmail">
                        <label for="email">Email address</label>
                        <input v-model="credentials.email" type="email" name="email" id="email">
                        <div v-for="message in validationErrors?.email" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpPhone">
                        <label for="telephone">Phone number (+254xxxxxxxxx)</label>
                        <input v-model="credentials.telephone" type="tel" name="telephone" id="telephone">
                        <div v-for="message in validationErrors?.telephone" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpUname">
                        <label for="username">Username (must be unique)</label>
                        <input v-model="credentials.username" type="text" name="username" id="username">
                        <div v-for="message in validationErrors?.username" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Update</span>
                    </button>
                </form>
            </div>
            <div class="category">
                <h3>Password</h3>
                <form @submit.prevent="submitPasswordForm(secret)">
                    <div class="form-group" id="grpOldPass">
                        <label for="password_old">Current password</label>
                        <input v-model="secret.password_old" type="password" name="password_old" id="password_old">
                        <div v-for="message in validationErrors?.password_old" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpNewPass">
                        <label for="password">Password</label>
                        <input v-model="secret.password" type="password" name="password" id="password">
                        <div v-for="message in validationErrors?.password" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpConfPass">
                        <label for="password_confirmation">Confirm password</label>
                        <input v-model="secret.password_confirmation" type="password" name="password_confirmation" id="password_confirmation">
                        <div v-for="message in validationErrors?.password_confirmation" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Update password</span>
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
import axios from 'axios';
import operateModal from '../../composables/modal'
import { onBeforeUpdate } from 'vue';
import { onMounted, ref, inject } from 'vue';
import { useRouter } from "vue-router";

const router = useRouter()
const modalRef = ref(null)
const isLoading = ref(false)
const validationErrors = ref({})
const credentials = ref({
    firstname: '',
    lastname: '',
    email: '',
    telephone: '',
    username: '',
    avatar: '',
})
const secret = ref({
    password_old: '',
    password: '',
    password_confirmation: '',
})
const swal = inject('$swal')
const avatar = ref(null)
const avatarHolder = ref(null)
const formAvatarSubmit = ref(null)

function openModal() {
    operateModal(modalRef.value)
}

function getUserAccount() {
    axios.get('api/user/account')
        .then(response => {
            credentials.value = response.data
        })
        .catch(error => console.log(error))
}

function submitAvatar() {
    if (isLoading.value) return

    isLoading.value = true
    validationErrors.value = {}

    let serialisedPost = new FormData()
    for (let item in credentials) {
        if(credentials.hasOwnProperty(item)) {
            serialisedPost.append(item, credentials[item])
        }
    }
    serialisedPost.append('method', '_PUT')

    axios.post('/api/user/avatar', serialisedPost)
        .then(response => {
            swal({
                icon: 'success',
                title: 'Avatar updated',
                didClose: () => {
                    router.go(0)
                }
            })
        })
        .catch(error => {
            if (error.response?.data) {
                validationErrors.value = error.response.data.errors
            }
            if (error.response?.data.errors) {
                swal({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.message,
                })
            }
        })
        .finally(() => isLoading.value = false)
}

function submitAccountForm() {
    if (isLoading.value) return

    isLoading.value = true
    validationErrors.value = {}

    axios.post('api/user/account', credentials.value)
        .then(response => {
            swal({
                icon: 'success',
                title: 'Account information updated',
                didClose: () => {
                    router.go(0)
                }
            })
        })
        .catch(error => {
            if (error.response?.data) {
                validationErrors.value = error.response.data.errors
            }
            if (error.response?.data.errors.credentials) {
                swal({
                    icon: 'error',
                    title: error.response.data.errors.credentials,
                    text: error.response.data.message,
                })
            }
        })
        .finally(() => isLoading.value = false)
}

function submitPasswordForm() {
    if (isLoading.value) return

    isLoading.value = true
    validationErrors.value = {}

    axios.post('api/user/secret', secret.value)
        .then(response => {
            swal({
                icon: 'success',
                title: 'Password updated',
                didClose: () => {
                    router.go(0)
                }
            })
        })
        .catch(error => {
            if (error.response?.data) {
                validationErrors.value = error.response.data.errors
                swal({
                    icon: 'error',
                    // title: error.response.data.errors.password,
                    title: 'Error',
                    text: error.response.data.message,
                })
            }
        })
        .finally(() => isLoading.value = false)
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
    credentials.avatar = selectedFile
    formAvatarSubmit.value.click()
}

function removeAvatar() {
    if (isLoading.value) return

    swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'Your avatar will be removed',
        showCancelButton: true,
        confirmButtonColor: 'rgb(207, 95, 50)',
        cancelButtonColor: 'rgb(238, 14, 14)',
        confirmButtonText: 'Confirm',
    }).then((result) => {
        if (result.isConfirmed) {
            isLoading.value = true

            axios.delete('api/user/avatar')
                .then(response => {
                    swal({
                        icon: 'success',
                        title: 'Avatar removed',
                        didClose: () => {
                            router.go(0)
                        }
                    })
                })
                .catch(error => {
                    if (error.response?.data.errors) {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: error.response.data.message,
                        })
                    }
                })
                .finally(() => isLoading.value = false)
        }
    })

    
}

onMounted(() => {
    openModal()
    getUserAccount()
})

onBeforeUpdate(() => {
    credentials.avatar = ''
})

defineExpose({
    openModal,
})

</script>