<template>
    <section class="section-auth">
        <div class="container">
             <!-- Form -->
            <div class="auth-form">
                <h3 class="section-title">Forgot password</h3>
                <form @submit.prevent="submitEmail(credentials)">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input v-model="credentials.email" type="email" name="email" id="email">
                        <div v-for="message in validationErrors?.email" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Send password reset link</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeUpdate } from 'vue';
import loginUser from '../../composables/login.js'

const { credentials, validationErrors, isLoading, submitEmail, route } = loginUser()

onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})

</script>