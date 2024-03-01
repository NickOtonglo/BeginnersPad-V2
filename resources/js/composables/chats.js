import axios from "axios";
import { ref, inject } from "vue";
import { useRoute, useRouter } from "vue-router";

export default function chatsMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const chats = ref({})
    const chat = ref({
        id: '',
        subject: '',
        initiator: '',
        can_respond: '',
        participants: {},
        messages: {},
        timestamp: '',
        time_ago: '',
    })
    const message = ref({
        body: '',
        type: '',
        file: '',
        reply_message: {},
        participant: '',
        timestamp: '',
        time_ago: '',
    })

    const getChats = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => chats.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getChat = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => chat.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createChat = (request, data) => {
        if (isLoading.value) { return }
        isLoading.value = true
        validationErrors.value = ''

        axios.post(request, data)
            .then(response => {
                router.go(0)
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const updateChat = (request, data) => {
        if (isLoading.value) { return }
        isLoading.value = true
        validationErrors.value = ''

        axios.patch(request, data)
            .then(response => {
                router.go(0)
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
            .finally(() => isLoading.value = false)
    }

    const deleteChat = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This chat will be removed from your list. However, the other participant(s) of the conversation may still be able to view the full conversation.",
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
                            title: 'Chat removed.',
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

    const saveMessage = (request, data) => {
        if (isLoading.value) { return }
        isLoading.value = true
        validationErrors.value = ''

        axios.post(request, data)
            .then(response => {
                // getChat(request)
                // console.log(chat.value)
                // axios.get(request)
                //     .then(response => {
                //         chat.value = response.data.data
                //         console.log(chat.value)
                //     })
                //     .catch(error => console.log(error))

                // console.log(chat.value.messages[chat.value.messages.length - 1])
                router.go(0)
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    return {
        route, 
        router, 
        isLoading, 
        validationErrors, 
        chats, 
        chat, 
        message, 
        getChats, 
        getChat, 
        createChat, 
        updateChat, 
        deleteChat, 
        saveMessage, 
    }
}