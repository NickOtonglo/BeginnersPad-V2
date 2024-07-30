import axios from "axios";
import { ref, inject } from "vue";
import { useRoute, useRouter } from "vue-router";

export default function dashboardMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const data = ref({
        // zones_all: '',
        // zones_sub_all: '',
        // zone_highest_listed: '',
        // sub_zone_highest_listed: '',
        // zones_highest_ratings: '',
        // zones_highest_ratings_average_rent: '',
        // zones_cheapest_rent: '',
    })

    const getData = () => {
        if (isLoading.value) return
        isLoading.value = true
        
        axios.get(`/api/dashboard`)
            .then(response => data.value = response.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    return {
        route, 
        router, 
        isLoading, 
        data, 
        getData, 
    }
}