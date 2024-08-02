import axios from "axios"
import { inject, ref } from "vue"
import { useRoute, useRouter } from "vue-router"

export default function favouriteMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const favourites = ref({})
    const favourite =ref({
        title: '',
        model: '',
        user_id: '',
    })
    const favouritesCount = ref(0)

    const getFavourites = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {
                favourites.value = response.data.data
                favouritesCount.value = response.data.meta.total
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const saveFavourite = (request, data, model) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        data.model = model

        axios.post(request, data)
            .then(response => {
                if (response.status == '201') {
                    swal({
                        icon: 'info',
                        title: 'Added to favourites.',
                        didClose: () => {
                            router.go(0)
                            // router.push({ name: 'property.create', params: { name: data.value.name } })
                        }
                    })
                } else if (response.status == '204') {
                    swal({
                        icon: 'warning',
                        title: 'Removed from favourites.',
                        didClose: () => {
                            router.go(0)
                        }
                    })
                }
            })
            .catch(error => {
                if (error.response?.status == '401') {
                    router.push({ name: 'auth.login' })
                }
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                } else {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occured. Please try again.',
                        // text: error.response.data.message,
                    })
                }
            })
            .finally(isLoading.value = false)
    }

    const deleteFavourite = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This post will be removed from your favourites.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
                axios.delete(request)
                    .then(response => {
                        swal({
                            icon: 'success',
                            title: 'Post removed from your favourites.',
                            didClose: () => {
                                router.go(0)
                            }
                        })
                    })
                    .catch(error => {
                        swal({
                            icon: 'error',
                            title: 'Something went wrong, please try again.'
                        })
                    })
                    .finally(() => isLoading.value = false)
            } else {
                isLoading.value = false
            }
        })
    }

    return {
        route,
        router,
        validationErrors,
        favourites,
        favouritesCount,
        getFavourites,
        saveFavourite,
        deleteFavourite,
    }
}