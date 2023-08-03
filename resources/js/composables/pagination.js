import { ref } from "vue"
import getArticles from "./getArticles"
import zonesMaster from "./zones"

export default function pagination() {
    const isLoading = ref(false)
    const total_pages = ref(0)
    const per_page = ref(0)
    const current_page = ref(1)
    const search_global = ref('')
    const { getData, articles } = getArticles()
    const { zones, getZones } = zonesMaster()
    let sourceParam = ''

    const getPaginationData = (page, source) => {
        if(isLoading.value) {return}
        isLoading.value = true
        sourceParam = source

        console.log(`/api/${source}?page=${page}&search_global=${search_global.value}`)

        axios.get(`/api/${source}?page=${page}&search_global=${search_global.value}`)
            .then(response => {
                total_pages.value = response.data.meta.last_page
                per_page.value = response.data.meta.per_page
                current_page.value = response.data.meta.current_page
            })
            .catch(error => console.log(error))
            .finally(() => {
                isLoading.value = false
                if (source == 'articles') {
                    getData(`/api/${source}?page=${page}&search_global=${search_global.value}`)
                } else if (source == 'zones') {
                    getZones(`/api/${source}?page=${page}&search_global=${search_global.value}`)
                }
                // callback(page, search_global.value)
            })
    }

    const onPageChange = (page) => {
        current_page.value = page
        getPaginationData(page, sourceParam)
    }

    return {
        isLoading,
        articles,
        zones,
        total_pages,
        per_page,
        current_page,
        search_global,
        onPageChange,
        getPaginationData
    }
}