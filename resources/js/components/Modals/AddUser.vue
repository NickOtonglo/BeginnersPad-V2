<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Create user</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <form @submit.prevent="saveUser(request, user)">
                    <div class="form-group" id="grpNames">
                        <div class="name-grp">
                            <div class="name">
                                <label for="firstname">First name</label>
                                <input v-model="user.firstname" type="text" name="firstname">
                                <div v-for="message in validationErrors?.firstname" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                            <div class="name">
                                <label for="lname">Last name</label>
                                <input v-model="user.lastname" type="text" name="lastname">
                                <div v-for="message in validationErrors?.lastname" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="grpEmail">
                        <label for="email">Email address</label>
                        <input v-model="user.email" type="email" name="email" id="email">
                        <div v-for="message in validationErrors?.email" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpPhone">
                        <label for="telephone">Phone number (+254xxxxxxxxx)</label>
                        <input v-model="user.telephone" type="tel" name="telephone" id="telephone">
                        <div v-for="message in validationErrors?.telephone" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpUname">
                        <label for="username">Username (must be unique)</label>
                        <input v-model="user.username" type="text" name="username" id="username">
                        <div v-for="message in validationErrors?.username" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Account type</label>
                        <select v-model="user.role_id" name="role_id">
                            <option disabled value="">--select account type--</option>
                            <template v-if="roles" v-for="item in roles">
                                <option v-if="item.id <= 3" :value="item.id">{{ item.title }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.role_id" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group" id="grpPass">
                        <label for="password">Password</label>
                        <input v-model="user.password" type="password" name="password" id="password">
                        <div v-for="message in validationErrors?.password" class="txt-alert txt-danger">
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
import operateModal from '../../composables/modal'
import { onBeforeMount, ref } from 'vue';
import userMaster from '../../composables/users'

const modalRef = ref(null)
const { user, saveUser, getRoles, roles, validationErrors } = userMaster()
const request = ref(`/api/users`)

function openModal() {
    operateModal(modalRef.value)
}

onBeforeMount(() => {
    getRoles()
})

defineExpose({
    openModal,
})

</script>