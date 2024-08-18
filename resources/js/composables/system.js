import axios from "axios"
import { inject, ref } from "vue"
import { useRoute, useRouter } from "vue-router"

export default function systemMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const controls = ref({})

    const resetSys = () => {
        if (isLoading.value) return
        isLoading.value = true

        swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'The system parameters will be reset to their defaults and the consequences may be extensive. Proceed with extreme caution.',
            showCancelButton: true,
            confirmButtonColor: 'rgb(238, 14, 14)',
            cancelButtonColor: 'rgb(207, 95, 50)',
            confirmButtonText: 'Reset',
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
    
                axios.post(`/api/system/reset`, null)
                    .then(response => {
                        swal({
                            icon: 'success',
                            title: 'The system has been reset',
                            didClose: () => {
                                router.go(0)
                            }
                        })
                    })
                    .catch(error => {
                        if (error.response?.data.errors) {
                            swal({
                                icon: 'error',
                                title: 'Error',
                                text: error.response.data.message,
                            })
                        }
                    })
                    .finally(() => isLoading.value = false)
            }
        })
    }

    return {
        route, 
        router, 
        isLoading, 
        validationErrors, 
        controls, 
        resetSys, 
    }
}