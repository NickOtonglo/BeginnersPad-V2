import axios from "axios";
import { ref, reactive, inject } from "vue";
import { useRouter } from "vue-router";

export default function loginUser() {
    const isLoading = ref(false)
    const validationErrors = ref({})
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

    const authenticate = (response) => {
        localStorage.setItem('authenticated', JSON.stringify(true))
        localStorage.setItem('authToken', response.data.token)
        localStorage.setItem('user', response.data.user.id)
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
                router.go()
            })
            .catch(error => console.log(error.response))
    }

    return { credentials, validationErrors, isLoading, submitLogin, logout }
}