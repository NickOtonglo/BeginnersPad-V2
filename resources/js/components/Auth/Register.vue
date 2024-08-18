<template>
    <section class="section-auth">
        <div class="container">
             <!-- Form -->
            <div class="auth-form">
                <h3 class="section-title">Sign up</h3>
                <form @submit.prevent="submitRegister(credentials)">
                    <div class="form-group">
                        <div class="name-grp">
                            <div class="name">
                                <label for="fname">First name</label>
                                <input v-model="credentials.fname" type="text" name="fname" id="fname">
                                <div v-for="message in validationErrors?.fname" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                            <div class="name">
                                <label for="lname">Last name</label>
                                <input v-model="credentials.lname" type="text" name="lname" id="lname">
                                <div v-for="message in validationErrors?.lname" class="txt-alert txt-danger">
                                    <li>{{ message }}</li>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input v-model="credentials.email" type="email" name="email" id="email">
                        <div v-for="message in validationErrors?.email" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Phone number (254xxxxxxxxx)</label>
                        <input v-model="credentials.telephone" type="tel" name="telephone" id="telephone">
                        <div v-for="message in validationErrors?.telephone" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Username (must be unique)</label>
                        <input v-model="credentials.username" type="text" name="username" id="username">
                        <div v-for="message in validationErrors?.username" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_type">Account type</label>
                        <select v-model="credentials.user_type" name="user_type" id="user_type">
                            <option value="" selected>--select account type--</option>
                            <template v-for="item in accountTypes">
                                <option :value="item.id">{{ item.title }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.user_type" class="txt-alert txt-danger">
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
                    <div class="form-group">
                        <div class="form-check">
                            <input v-model="credentials.terms_agree" class="form-check-input" type="checkbox" name="terms" id="terms" >
                            <p class="form-check-label">
                                I agree to the <router-link :to="{ name: 'app.terms' }">Terms of Service of Beginners Pad</router-link>
                            </p>
                        </div>
                        <div v-for="message in validationErrors?.terms_agree" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <!-- <input class="btn btn-submit" type="button" value="Sign up"> -->
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Sign up</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount, onBeforeUpdate } from 'vue';
import registerUser from '../../composables/register.js';

const { 
    credentials, 
    isLoading, 
    validationErrors, 
    submitRegister, 
    accountTypes, 
    getAccountTypes, 
    route 
} = registerUser()

onBeforeMount(() => {
    getAccountTypes()
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})

</script>