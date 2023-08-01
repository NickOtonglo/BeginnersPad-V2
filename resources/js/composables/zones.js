import axios from "axios";
import { ref, inject } from "vue";
import { useRoute, useRouter } from "vue-router";

export default function zonesMaster() {
    const route = useRoute()
    const router = useRouter()
    const zones = ref({})
    const zone = ref({
        name: '',
        lat: null,
        lng: null,
        radius: null,
        timezone: '',
        description: '',
        county_code: '',
    })
    const countries = ref({})
    const counties = ref({})
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')

    const getZones = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => zones.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getCountries = () => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get('api/zones/countries')
            .then(response => countries.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getCounties = () => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get('api/zones/counties')
            .then(response => counties.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const createZone = (request, data) => {
        if (isLoading.value) return
        isLoading.value = true
        validationErrors.value = ''

        axios.post(request, data)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Zone created.',
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

    return {
        zones,
        zone,
        counties,
        countries,
        isLoading,
        getZones,
        createZone,
        getCounties,
        getCountries,
        validationErrors,
    }
}