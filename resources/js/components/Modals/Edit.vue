<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Title</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <div class="img-grp rounded">
                    <img src="/images/avatar.png" alt="">
                    <button class="btn-link btn-close"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="category">
                <h3>Account details</h3>
                <form id="formUpdateAccount">
                    <div class="form-group" id="grpNames">
                        <div class="grp-name">
                            <label for="fname">First name</label>
                            <input type="text" name="fname" id="fname">
                        </div>
                        <div class="grp-name">
                            <label for="lname">Last name</label>
                            <input type="text" name="lname" id="lname">
                        </div>
                    </div>
                    <div class="form-group" id="grpEmail">
                        <label for="name">Email address*</label>
                        <input type="email" name="Email address" id="email">
                    </div>
                    <div class="form-group" id="grpPhone">
                        <label for="telephone">Phone number (+254xxxxxxxxx)</label>
                        <input type="text" name="telephone" id="telephone">
                    </div>
                    <div class="form-group" id="grpUname">
                        <label for="username">Username (must be unique)</label>
                        <input type="text" name="username" id="username">
                    </div>
                    <input class="btn btn-submit" type="button" value="Update" onclick="initAccount();">
                </form>
            </div>
            <div class="category">
                <h3>Password</h3>
                <form action="">
                    <div class="form-group" id="grpOldPass">
                        <label for="password">Old password</label>
                        <input type="password" name="password_old" id="password_old">
                    </div>
                    <div class="form-group" id="grpNewPass">
                        <label for="password">New password</label>
                        <input type="password" name="password_new" id="password_new">
                    </div>
                    <div class="form-group" id="grpConfPass">
                        <label for="password_confirmation">Confirm new password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation">
                    </div>
                    <input class="btn btn-submit" type="button" value="Update password" onclick="initPassword();">
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
import { onMounted, ref } from 'vue';

const modalRef = ref(null)

function openModal() {
    operateModal(modalRef.value)
}

onMounted(() => {
    openModal()
})

defineExpose({
    openModal,
})

</script>