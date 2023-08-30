import { inject, ref } from "vue"
import { useRoute, useRouter } from "vue-router"

export default function propertiesMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const properties = ref({})
    const property = ref({
        name: '',
        lat: '',
        lng: '',
        status: '',
        verified: '',
        description: '',
        thumbnail: '',
        timestamp: '',
        time_ago: '',
        user_id: '',
        sub_zone_id: '',
        brand: '',
        user: '',
    })

    const getProperties = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => properties.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getProperty = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => property.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createProperty = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Property created.',
                    didClose: () => {
                        router.go(0)
                        // router.push({ name: 'property.create', params: { name: data.value.name } })
                    }
                })
            })
            .catch(error => {
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

    const updateProperty = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        axios.patch(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Property updated.',
                    didClose: () => {
                        router.go(0)
                    }
                })
            })
            .catch(error => {
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

    const deleteProperty = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This property listing, as well as all units hosted under it, will be erased from the system.",
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
                            title: 'Sub-zone deleted.',
                            didClose: () => {
                                router.push({ name: 'properties.view' })
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
        properties,
        property,
        getProperties,
        getProperty,
        createProperty,
        updateProperty,
        deleteProperty,
    }
}