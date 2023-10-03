import { inject, ref } from "vue"
import { useRoute, useRouter } from "vue-router"

export default function propertyReviewsMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const reviews = ref({})

    const getReviews = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => reviews.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    return {
        route,
        router,
        validationErrors,
        reviews,
        getReviews,
    }
}