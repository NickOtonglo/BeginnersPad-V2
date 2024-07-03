import axios from 'axios';
import { inject, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default function userCreditMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const account = ref({
        id: '',
        user: '',
        credit: '',
        auto_pay: '',
        timestamp: '',
        time_ago: '',
    })

    const getCreditAccount = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(request => account.value = request.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createAccount = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        if (!data) {
            let serialisedPost = new FormData()
            serialisedPost.append('auto_pay', false)
            serialisedPost.append('amount', 0.00)
            data = serialisedPost
        }

        axios.post(request, data)
            .then(response => {
                // swal({
                //     icon: 'success',
                //     title: 'Credit account created.',
                //     didClose: () => {
                //         router.go(0)
                //     }
                // })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                } 
                if (error.response?.data.errors.user) {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: error.response?.data.message,
                    })
                }
            })
            .finally(isLoading.value = false)
    }

    const updateAccount = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.patch(request, data)
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                } else {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occured. Please try again.',
                    })
                }
            })
            .finally(isLoading.value = false)
    }

    const checkIfUserHasCreditAccount = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {return response.data.data})
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    return {
        route, 
        router, 
        validationErrors, 
        isLoading, 
        account, 
        getCreditAccount, 
        createAccount, 
        checkIfUserHasCreditAccount, 
        updateAccount, 
    }
}