import { ref } from "vue"

export default function mapsMaster(){
    const isLoading = ref(false)

    const nearbySearch = (lat, lng, type) => {
        console.log(import.meta.env.VITE_GOOGLE_MAPS_API_KEY)

        if (isLoading.value) return
        isLoading.value = true
        
        const request = ref(`https://maps.googleapis.com/maps/api/place/nearbysearch/json?keyword=cruise&location=${lat}${lng}&radius=1500&type=${type}&key=${import.meta.env.VITE_GOOGLE_MAPS_API_KEY}`)

        axios.get(request.value)
        .then(response => {
            console.log(response.data)
        })
        .catch(error => console.log(error))
        .finally(isLoading.value = false)
    }

    return {
        isLoading, 
        nearbySearch, 
    }
}