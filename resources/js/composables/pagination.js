import { ref } from "vue"
import getArticles from "./getArticles"

export default function pagination() {
    const isLoading = ref(false)
    const total_pages = ref(0)
    const per_page = ref(0)
    const current_page = ref(1)
    const search_global = ref('')
    const { getData, articles } = getArticles()

    const getPaginationData = (page) => {
        if(isLoading.value) {return}
        isLoading.value = true

        axios.get(`/api/articles?page=${page}&search_global=${search_global.value}`)
            .then(response => {
                total_pages.value = response.data.meta.last_page
                per_page.value = response.data.meta.per_page
                current_page.value = response.data.meta.current_page
            })
            .catch(error => console.log(error.response))
            .finally(() => {
                isLoading.value = false
                getData('/api/articles?page=' + page, '&search_global=' + search_global.value)
                // callback(page, search_global.value)
            })
    }

    const onPageChange = (page) => {
        current_page.value = page
        getPaginationData(page)
    }

    return {
        isLoading,
        articles,
        total_pages,
        per_page,
        current_page,
        search_global,
        onPageChange,
        getPaginationData
    }
}