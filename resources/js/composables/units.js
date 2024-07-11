import { inject, ref } from "vue"
import { useRoute, useRouter } from "vue-router"

export default function unitsMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const units = ref({})
    const unit = ref({
        name: '',
        slug: '',
        description: '',
        price: '',
        init_deposit: '',
        init_deposit_period: '',
        story: '',
        floor_area: '',
        bathrooms: '',
        bedrooms: '',
        disclaimer: '',
        status: '',
        thumbnail: '',
        property_id: '',
        timestamp: '',
        time_ago: '',
        features: '',
        files: '',
        property: '',
    })
    const unitsCount = ref(0)
    const search_global = ref('')

    const getUnits = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {
                units.value = response.data.data
                unitsCount.value = response.data.meta.total
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getUnit = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => unit.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createUnit = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Unit created.',
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
                    })
                }
            })
            .finally(isLoading.value = false)
    }

    const updateUnit = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        axios.patch(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Unit updated.',
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
                    })
                }
            })
            .finally(isLoading.value = false)
    }

    const deleteUnit = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This unit and all its associated files will be erased from the system.",
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
                            title: 'Unit deleted.',
                            didClose: () => {
                                router.go(-1)
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

    const saveFeatures = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Feature(s) added.',
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
                    })
                }
            })
            .finally(isLoading.value = false)
    }

    const removeFeature = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This feature will be removed.",
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
                            title: 'Feature removed.',
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

    const uploadFiles = async(request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = {}
    
        https://www.npmjs.com/package/axios#formdata
        await axios.post(request, data.files)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'File(s) added',
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

    const removeFile = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This file will be removed.",
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
                            title: 'File removed.',
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

    const uploadThumb = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = {}
    
        swal.fire({
            title: 'Are you sure?',
            text: "The current thumbnail will be replaced.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
                axios.post(request, data.files)
                    .then(response => {
                        swal({
                            icon: 'success',
                            title: 'Thumbnail updated',
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
            } else {
                isLoading.value = false
            }
        })
    }

    const saveDisclaimers = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        if(data.disclaimer.length == 0 || data.disclaimer == '') {
            data.disclaimer = ''
        }

        axios.patch(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Disclaimer(s) added.',
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
                    })
                }
            })
            .finally(isLoading.value = false)
    }

    const removeDisclaimer = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This Disclaimer will be removed.",
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
                            title: 'Disclaimer removed.',
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

    const updateStatus = (request, data) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: `You are about to set this unit's status to '${data.status}'. This action will be logged.`,
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
                            title: `Successfully changed unit's status to '${data.status}'.`,
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

    const filterUnits = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(`${request}&bed=${data[0][1]}&bath=${data[1][1]}&area=${data[2][1]}&pmin=${data[3][1]}&pmax=${data[4][1]}`)
            .then(response => {
                units.value = response.data.data
                unitsCount.value = response.data.meta.total
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    return {
        route,
        router,
        validationErrors,
        units,
        unit,
        unitsCount,
        getUnits,
        getUnit,
        createUnit,
        updateUnit,
        deleteUnit,
        saveFeatures,
        removeFeature,
        uploadFiles,
        removeFile,
        uploadThumb,
        saveDisclaimers,
        removeDisclaimer,
        updateStatus,
        filterUnits, 
    }
}