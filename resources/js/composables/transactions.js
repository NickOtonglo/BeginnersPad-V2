import axios from 'axios';
import { inject, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default function transactionsMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const gateways = ref({
        id: '',
        name: '',
    })

    const getPaymentGateways = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => gateways.value = response.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    return {
        route, 
        router, 
        isLoading, 
        validationErrors, 
        gateways, 
        getPaymentGateways, 
    }
}