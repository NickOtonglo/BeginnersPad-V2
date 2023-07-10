import axios from "axios";
import { ref } from "vue";

export default function getArticles() {
    const isLoading = ref(false)
    const articles = ref({})

    if (isLoading.value) return
    isLoading.value = true

    const getData = (route) => {
        axios.get(route)
        .then(response => {
            articles.value = response.data.data
        })
        .catch(error => console.log(error))
        .finally(isLoading.value = false)
    }

    return { getData, isLoading, articles }
}