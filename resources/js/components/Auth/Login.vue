<template>
    <section class="section-auth">
        <div class="container">
             <!-- Form -->
            <div class="auth-form">
                <h3 class="section-title">Sign in</h3>
                <form @submit.prevent="submitLogin(credentials)">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input v-model="credentials.email" type="email" name="email" id="email">
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
                        <div class="form-check">
                            <input v-model="credentials.remember" class="form-check-input" type="checkbox" name="remember" >
                            <p class="form-check-label"> Remember me</p>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Sign in</span>
                    </button>
                    <!-- <input class="btn-submit" type="button" value="Sign in"> -->
                    <div class="link-forgot-password">
                        <a href="#">Forgot your password?</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
import loginUser from '../../composables/login.js'

export default {
    setup() {
        const { credentials, validationErrors, isLoading, submitLogin } = loginUser()

        return { credentials, validationErrors, isLoading, submitLogin }
    }
}
</script>