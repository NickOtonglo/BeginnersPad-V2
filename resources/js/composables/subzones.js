import axios from "axios";
import { ref, inject } from "vue";
import { useRoute, useRouter } from "vue-router";

export default function subZonesMaster() {
    const route = useRoute()
    const router = useRouter()
    const subZones = ref({})
    const subZone = ref({
        name: '',
        lat: null,
        lng: null,
        radius: null,
        description: '',
        timestamp: '',
        nature_id: '',
        zone_id: '',
        nature: {
            id: '',
            category: '',
            description: '',
        },
        zone: {
            name: '',
            lat: null,
            lng: null,
            radius: null,
            timezone: '',
            description: '',
            county_code: '',
            county: {
                code: '',
                name: '',
            },
        },
    })
    const natures = ref({})
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')

    const getSubZones = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => subZones.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getNatures = () => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get('/api/zones/sub/roles')
            .then(response => natures.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createSubZone = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Sub-zone created.',
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

    const getSubZone = (request) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        axios.get(request)
            .then(response => subZone.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const updateSubZone = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        axios.patch(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Sub-zone updated.',
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

    const deleteSubZone = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This sub-zone, as well as all related property listings, will be erased from the system.",
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
                                router.push({ name: 'zone.view', params: {id: subZone.zone_id } })
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
        subZones,
        subZone,
        route,
        natures,
        isLoading,
        getSubZones,
        createSubZone,
        getSubZone,
        updateSubZone,
        deleteSubZone,
        getNatures,
        validationErrors,
    }
}