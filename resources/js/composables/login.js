import axios from "axios";
import { ref, reactive, inject } from "vue";
import { useRoute, useRouter } from "vue-router";

export default function loginUser() {
    const isLoading = ref(false)
    const validationErrors = ref({})
    const route = useRoute()
    const router = useRouter()
    const credentials = reactive({
        email: '',
        password: '',
        remember: false
    })
    const swal = inject('$swal')

    const submitLogin = async() => {
        if (isLoading.value) return

        isLoading.value = true
        validationErrors.value = {}

        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/sign-in', credentials)
                .then(async response => {
                    authenticate(response)
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
        })
    }

    const submitEmail = async() => {
        if (isLoading.value) return
        isLoading.value = true

        axios.post(`/forgot-password`, credentials)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Password reset link sent.',
                    text: 'A password reset link has been sent to the email address you provided. Kindly follow the instructions given within to reset your password.',
                    didClose: () => {
                        router.go(-1)
                    }
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
                console.log(error)
            })
            .finally(isLoading.value = false)
    }

    const submitNewPassword = async(data) => {
        if (isLoading.value) return
        isLoading.value = true

        let serialisedPost = new FormData()
        serialisedPost.append('password', data[0].password)
        serialisedPost.append('password_confirmation', data[0].password_confirmation)
        serialisedPost.append('email', data[1])
        serialisedPost.append('token', data[2])

        axios.post(`/reset-password`, serialisedPost)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Your password has been reset.',
                    text: 'You may now sign in with your new password.',
                    didClose: () => {
                        // router.go(-1)
                        router.push({ name: 'auth.login' })
                    }
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
                console.log(error)
            })
            .finally(isLoading.value = false)
    }

    const authenticate = (response) => {
        localStorage.setItem('authenticated', JSON.stringify(true))
        localStorage.setItem('authToken', response.data.token)
        localStorage.setItem('user', response.data.user.id)
        localStorage.setItem('role', response.data.user.role_id)
        // router.push({ name: 'app.home' })
        router.go()
    }

    const logout = async() => {
        if (isLoading.value) return

        isLoading.value = true

        axios.post('/sign-out')
            .then(response => {
                localStorage.removeItem('authenticated')
                localStorage.removeItem('authToken')
                localStorage.removeItem('user')
                localStorage.removeItem('role')
                router.go()
            })
            .catch(error => console.log(error.response))
            .finally(isLoading.value = false)
    }

    return { 
        credentials, 
        validationErrors, 
        isLoading, 
        submitLogin, 
        submitEmail, 
        submitNewPassword, 
        logout, 
        route,
    }
}