<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Title</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <div class="img-grp rounded">
                    <img src="/images/static/avatar.png" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
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
                    <!-- <div class="form-group" id="grpUname">
                        <label for="username">Username (must be unique)</label>
                        <input v-model="credentials.username" type="text" name="username" id="username">
                        <div v-for="message in validationErrors?.username" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div> -->
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
import operateModal from '../../composables/modal'
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
})
const secret = ref({
    password_old: '',
    password: '',
    password_confirmation: '',
})
const swal = inject('$swal')

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

function submitAccountForm() {
    if (isLoading.value) return

    isLoading.value = true
    validationErrors.value = {}

    console.log(credentials.value.firstname)

    axios.post('api/user/account', credentials.value)
        .then(response => {
            router.go(0)
            // swal({
            //     icon: 'success',
            //     title: 'Account information updated'
            // })
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
            router.go(0)
            // swal({
            //     icon: 'success',
            //     title: 'Password updated'
            // })
        })
        .catch(error => {
            if (error.response?.data) {
                validationErrors.value = error.response.data.errors
            }
            if (error.response?.data) {
                swal({
                    icon: 'error',
                    title: error.response.data.errors.password,
                    text: error.response.data.message,
                })
            }
        })
        .finally(() => isLoading.value = false)
}

onMounted(() => {
    openModal()
    getUserAccount()
})

defineExpose({
    openModal,
})

</script>