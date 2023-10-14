import { ref, inject } from "vue";
import { useRoute, useRouter } from "vue-router"
import userMaster from '../composables/users'

export default function ticketsMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref({})
    const swal = inject('$swal')
    const topics = ref({})
    const topic = ref({
        name: '',
        topic: '',
    })
    const tickets = ref({})
    const ticket = ref({
        email: '',
        user: '',
        isLoggedIn: '',
        topic: '',
        description: '',
        status: '',
        assigned_to: '',
    })
    const { user, getUserData } = userMaster()

    const getTopics = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => topics.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getTopic = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => topic.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createTopic = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Topic added.',
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

    const updateTopic = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.patch(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Topic updated.',
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

    const deleteTopic = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This topic will be removed. However, tickets associated with it will not be affected.",
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
                            title: 'Topic deleted.',
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
    
    const getTickets = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => tickets.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getTicket = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => ticket.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createTicket = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        getUserData()

        axios.post(request, data)
            .then(response => {
                if (user.value.username) {
                    swal({
                        icon: 'success',
                        title: 'Your ticket has been submitted!',
                        text: 'A representative will get in touch with you soon. Kindly check your email inbox for any new messages from our team.',
                        didClose: () => {
                            router.push({ name: 'ticket.view', params: { id: response.data.help_ticket.id } })
                        }
                    })
                } else {
                    swal({
                        icon: 'success',
                        title: 'Your ticket has been submitted!',
                        text: 'A representative will get in touch with you soon. Kindly check your email inbox for any new messages from our team.',
                        didClose: () => {
                            router.go(0)
                        }
                    })
                }
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

    const updateTicket = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.put(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Ticket updated.',
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

    const deleteTicket = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This ticket will be erased from the system.",
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
                            title: 'Ticket deleted.',
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

    return {
        validationErrors,
        getTopics,
        getTopic,
        createTopic,
        updateTopic,
        deleteTopic,
        getTickets,
        getTicket,
        createTicket,
        updateTicket,
        deleteTicket,
        tickets,
        ticket,
        topics,
        router,
        route,
    }
}