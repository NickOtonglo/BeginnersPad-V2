import { inject, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default function userMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const user = ref({
        
    })

    const getUserAccount = () => {
        axios.get('api/user/account')
            .then(response => {
                user.value = response.data
            })
            .catch(error => console.log(error))
    }

    const submitAvatar = (formData, request) => {
        if (isLoading.value) return
    
        isLoading.value = true
        validationErrors.value = {}
    
        let serialisedPost = new FormData()
        for (let item in formData) {
            if(formData.hasOwnProperty(item)) {
                serialisedPost.append(item, formData[item])
            }
        }
        serialisedPost.append('method', '_PUT')
    
        axios.post(request, serialisedPost)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Avatar updated',
                    didClose: () => {
                        router.go(0)
                    }
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
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

    const removeAvatar = (request) => {
        if (isLoading.value) return
    
        swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'Your avatar will be removed',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm',
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
    
                axios.delete(request)
                    .then(response => {
                        swal({
                            icon: 'success',
                            title: 'Avatar removed',
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

    const submitForm = (formData, request) => {
        if (isLoading.value) return
    
        isLoading.value = true
        validationErrors.value = {}
    
        axios.post(request, formData)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Information updated',
                    didClose: () => {
                        router.go(0)
                    }
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
                console.log(error.response.data.errors.name)
            })
            .finally(() => isLoading.value = false)
    }

    return {
        route,
        router,
        user,
        validationErrors,
        getUserAccount,
        submitAvatar,
        removeAvatar,
        submitForm,
    }
}