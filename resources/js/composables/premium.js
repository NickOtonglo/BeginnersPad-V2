import axios from 'axios'
import { ref, inject } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default function premiumMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const plan = ref({
        name: '',
        description: '',
        status: '',
        minimum_days: '',
        price: '',

    })
    const subscriptions = ref({})
    const subscription = ref({
        id: '',
        period_months: '',
        activated_at: '',
        time_ago: '',
        expires_at: '',
        time_left: '',
        subscriber: '',
        plan: '',
        slug: '',
        waiting_lists: '',
    })
    const subscriptionLogs = ref({})
    const waitingLists = ref({})
    const waitingList = ref({
        id: '',
        subscription_id: '',
        zone_id: '',
        zone: '',
        radius: '',
        properties_count: '',
        county: '',
    })

    const getPlan = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => plan.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getSubscriptions = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => subscriptions.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }
    
    const getSubscription = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => subscription.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createSubscription = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        swal.fire({
            title: 'Are you sure?',
            text: "You are about to subscribe to this plan. It will cost you "+data.price+" credits and is valid for "+data.period+" days.",
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
                            title: 'You have subscribed successfully to this plan.',
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
                                text: error.response?.data.message,
                            })
                        } else if (error.response?.data) {
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
            } else {
                isLoading.value = false
            }
        })
    }

    const updateSubscription = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.patch(request, data)
            .then(response => {
                // swal({
                //     icon: 'success',
                //     title: 'You have subscribed successfully to this plan.',
                //     didClose: () => {
                //         router.go(0)
                //     }
                // })
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

    const deleteSubscription = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This subscription will be removed.",
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
                            title: 'Subscription removed.',
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

    const addWaitingList = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Added to waiting list.',
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

    const removeWaitingList = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "You will be removed from this waiting list.",
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
                            title: 'Removed from waiting list.',
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
        isLoading, 
        validationErrors, 
        plan,
        subscriptions, 
        subscription, 
        subscriptionLogs, 
        waitingLists, 
        waitingList, 
        getPlan,
        getSubscriptions, 
        getSubscription, 
        createSubscription, 
        updateSubscription, 
        deleteSubscription, 
        addWaitingList, 
        removeWaitingList,  
    }
}