import axios from "axios"
import { inject, ref } from "vue"
import { useRoute, useRouter } from "vue-router"

export default function propertyReviewsMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const reviews = ref({})
    const review = ref({
        id: '',
        property: '',
        rating: '',
        review: '',
        time_ago: '',
    })
    const removalReasons = ref({})
    const removalLogs = ref({})
    const removalLogsCount = ref(0)
    const removalLog = ref({
        id: '',
        review: '', 
        rating: '', 
        author_username: '', 
        property_name: '', 
        property_slug: '', 
        removal_reason: '', 
        reason_details: '',
        action_by: '',
        comment: '',
        timestamp: '',
        time_ago: '',
    })

    const getReviews = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => reviews.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createReview = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Your review has been posted.',
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

    const getMyReview = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.patch(request)
            .then(response => {
                review.value = response.data.data
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const updateReview = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.patch(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Your review has been updated.',
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

    const deleteReview = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This review will be removed.",
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
                            title: 'Review deleted.',
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

    const getRemovalReasons = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => removalReasons.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const removeReview = (request, data) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This review will be removed. The author will be notified and the removal will be logged",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
                axios.post(request, data)
                    .then(response => {
                        swal({
                            icon: 'success',
                            title: 'Review removed.',
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

    const getRemovalLogs = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {
                removalLogs.value = response.data.data
                removalLogsCount.value = response.data.meta.total
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    return {
        route,
        router,
        isLoading,
        validationErrors,
        reviews,
        review,
        removalReasons,
        removalLogs,
        removalLog,
        removalLogsCount,
        getReviews,
        getMyReview,
        createReview,
        updateReview,
        deleteReview,
        getRemovalReasons,
        getRemovalLogs,
        removeReview, 
    }
}