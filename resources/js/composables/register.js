import axios from "axios";
import { ref, reactive, inject } from "vue";
import { useRoute, useRouter } from "vue-router";

export default function registerUser() {
    const isLoading = ref(false)
    const validationErrors = ref({})
    const route = useRoute()
    const router = useRouter()
    const credentials = reactive({
        fname: '',
        lname: '',
        email: '',
        telephone: '',
        username: '',
        user_type: '',
        password: '',
        password_confirmation: '',
        terms_agree: false
    })
    const swal = inject('$swal')

    const submitRegister = async() => {
        if (isLoading.value) return

        isLoading.value = true
        validationErrors.value = {}

        axios.post('/sign-up', credentials)
            .then(async response => {
                register(response)
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const register = (response) => {
        router.push({ name: 'auth.login' })
    }

    return { credentials, isLoading, validationErrors, submitRegister, route }
}