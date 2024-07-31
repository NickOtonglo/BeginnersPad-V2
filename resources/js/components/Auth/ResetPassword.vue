<template>
    <section class="section-auth">
        <div class="container">
             <!-- Form -->
            <div class="auth-form">
                <h3 class="section-title">Forgot password</h3>
                <form @submit.prevent="submitNewPassword([credentials, route.query.email, route.params.token])">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input v-model="route.query.email" type="email" name="email" id="email" disabled>
                        <div v-for="message in validationErrors?.email" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input v-model="credentials.password" type="password" name="password" id="password">
                        <div v-for="message in validationErrors?.password" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm password</label>
                        <input v-model="credentials.password_confirmation" type="password" name="password_confirmation" id="password_confirmation">
                        <div v-for="message in validationErrors?.password_confirmation" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Reset password</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeUpdate, onMounted, ref } from 'vue';
import loginUser from '../../composables/login.js'

const { 
    credentials, 
    validationErrors, 
    isLoading, 
    route, 
    submitNewPassword,  
} = loginUser()

onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})

</script>