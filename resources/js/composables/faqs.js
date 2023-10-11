import { inject, ref } from "vue"
import { useRoute, useRouter } from "vue-router"

export default function faqsMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const faqs = ref({})
    const faq = ref({
        id: '',
        question: '',
        answer: '',
        topic: '',
    })

    const getFaqs = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => faqs.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getFaq = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => faq.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createFaq = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'FAQ added.',
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

    const updateFaq = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.patch(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'FAQ updated.',
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

    const deleteFaq = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This FAQ will be removed.",
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
                            title: 'FAQ deleted.',
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
        faqs,
        faq,
        getFaqs,
        getFaq,
        createFaq,
        updateFaq,
        deleteFaq,
    }
}