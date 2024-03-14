import axios from "axios"
import { inject, ref } from "vue"
import { useRoute, useRouter } from "vue-router"

export default function propertiesMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const properties = ref({})
    const propertiesCount = ref(0)
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
        files: ref({
            id: '',
            name: '',
            type: '',
            property_id: '',
        })
    })
    const logs = ref({})
    const log = ref({
        comment: '',
    })

    const getProperties = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {
                properties.value = response.data.data
                propertiesCount.value = response.data.meta.total
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getProperty = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {
                property.value = response.data.data
                return property.value
            })
            .catch(error => {
                // console.log(error)
                router.push({ name: 'app.404' })
            })
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
                            title: 'Property deleted.',
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

    const updateStatus = (request, data) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: `You are about to set this listing's status to '${data.status}'. This action will be logged.`,
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
                            title: `Successfully changed listing's status to '${data.status}'.`,
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

    const contactLister = (request, data) => {
        if (isLoading.value) return
        isLoading.value = false

        let serialisedPost = new FormData()
        serialisedPost.append('body', `Hi, I would like to get in touch with you regarding your listing '${data.value.name}'.`)

        swal.fire({
            title: 'Send enquiry?',
            text: "A message will be sent to the property lister expressing your interest in this listing.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
                axios.post(request, serialisedPost)
                .then(response => {
                        console.log(response)
                    
                        swal.fire({
                            icon: 'success',
                            title: "Message sent",
                            text: "Enquiry sent to lister. Expect a response soon.",
                            showCancelButton: true,
                            confirmButtonColor: 'rgb(13, 180, 138)',
                            // cancelButtonColor: 'rgb(238, 14, 14)',
                            confirmButtonText: 'Go to chats',
                            cancelButtonText: 'Close',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                router.push({ name: 'chats.index' })
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
        propertiesCount,
        property,
        getProperties,
        getProperty,
        createProperty,
        updateProperty,
        deleteProperty,
        saveFeatures,
        removeFeature,
        uploadFiles,
        removeFile,
        uploadThumb,
        updateStatus,
        logs,
        log,
        getLogs,
        contactLister, 
    }
}