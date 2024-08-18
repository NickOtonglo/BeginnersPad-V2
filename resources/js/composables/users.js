import { inject, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import checkAuth from '../composables/checkAuth';
import axios from 'axios';

export default function userMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const user = ref({
        email: '',
        firstname: '',
        lastname: '',
        username: '',
        telephone: '',
        role_id: '',
        role: '',
        avatar: '',
        status: '',
        password: '',
        password_confirmation: '',
        count_suspended: '',
        created_at: '',
        firstname: '',
        brand: {},
    })
    const userAuth = checkAuth()
    const users = ref({})
    const usersCount = ref(0)
    const roles = ref({})
    const logs = ref({})
    const secret = ref(null)

    const getRoles = () => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(`/api/users/roles/all`)
        .then(response => {
            roles.value = response.data.data
        })
        .catch(error => console.log(error))
        .finally(isLoading.value = false)
    }

    const getUserData = () => {
        if (userAuth.isAuthenticated.value) {
            axios.get('/api/user')
                .then(response => {
                    user.value = response.data
                })
                .catch(error => console.log(error))
        }
    }    

    function getUserAccount() {
        axios.get('api/user/account')
            .then(response => {
                user.value = response.data
    
                axios.get('/api/user')
                    .then(response => {
                        user.value.role = response.data.role

                    })
                    .catch(error => console.log(error))
            })
            .catch(error => console.log(error))
    }

    const updateAvatar = (formData, request) => {
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

    const updateForm = (formData, request) => {
        if (isLoading.value) return
    
        isLoading.value = true
        validationErrors.value = {}
    
        axios.patch(request, formData)
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
            })
            .finally(() => isLoading.value = false)
    }

    const saveBrand = (formData, request) => {
        if (isLoading.value) return
    
        isLoading.value = true
        validationErrors.value = {}

        let serialisedPost = new FormData()
        for (let item in formData) {
            if(formData.hasOwnProperty(item)) {
                serialisedPost.append(item, formData[item])
            }
        }
        serialisedPost.append('method', '_POST')
    
        axios.post(request, serialisedPost)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Brand created',
                    didClose: () => {
                        router.go(0)
                    }
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
                // if (error.response?.data.errors) {
                //     swal({
                //         icon: 'error',
                //         title: 'Error',
                //         text: error.response.data.message,
                //     })
                // }
            })
            .finally(() => isLoading.value = false)
    }

    // Admin functions start here
    const getUsers = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {
                users.value = response.data.data
                usersCount.value = response.data.meta.total
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getUser = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
        .then(response => {
            user.value = response.data.data
        })
        .catch(error => console.log(error))
        .finally(isLoading.value = false)
    }

    const saveUser = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'User created.',
                    didClose: () => {
                        router.go(0)
                    }
                })
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

    const updateUserStatus = (request, data) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: `You are about to ${data.status} this user's account. This action will be logged.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
                axios.patch(request, data)
                    .then(response => {
                        swal({
                            icon: 'success',
                            title: `${data.status} operation on user's account completed successfully.`,
                            didClose: () => {
                                if (data.status == 'Delete') {
                                    router.go(-1)
                                } else {
                                    router.go(0)
                                }
                            }
                        })
                    })
                    .catch(error => {
                        if (error.response?.data.errors.user) {
                            swal({
                                icon: 'error',
                                title: 'Error',
                                text: error.response?.data.message,
                            })
                        } else {
                            swal({
                                icon: 'error',
                                title: 'Something went wrong, please try again.'
                            })
                        }
                    })
                    .finally(() => isLoading.value = false)
            } else {
                isLoading.value = false
            }
        })
    }

    const getLogs = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {
                logs.value = response.data.data
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const checkPassword = (password) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = null

        axios.post(`/api/confirm-secret`, password)
            .then(response => {
                secret.value = response.data
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                } else {
                    console.log(error)
                }
            })
            .finally(isLoading.value = false)
    }

    return {
        route,
        router,
        user,
        users,
        roles,
        logs,
        secret,
        usersCount,
        validationErrors,
        getUserAccount,
        getUserData,
        updateAvatar,
        removeAvatar,
        updateForm,
        saveBrand,
        getRoles,
        getUsers,
        getUser,
        saveUser,
        updateUserStatus,
        getLogs,
        checkPassword, 
    }
}