import { ref } from "vue"
import getArticles from "./getArticles"
import zonesMaster from "./zones"
import subZoneMaster from './subzones'

export default function pagination() {
    const isLoading = ref(false)
    const total_pages = ref(0)
    const per_page = ref(0)
    const current_page = ref(1)
    const search_global = ref('')
    const { getData, articles } = getArticles()
    const { zones, getZones, zonesCount } = zonesMaster()
    const { subZones, getSubZones, subZonesCount } = subZoneMaster()
    let sourceParam = '', requestParam = ''

    const getPaginationData = (page, source) => {
        if(isLoading.value) {return}
        isLoading.value = true
        sourceParam = source

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

    const getPaginationDataWithRequest = (page, source, request) => {
        if(isLoading.value) {return}
        isLoading.value = true
        sourceParam = source
        requestParam = request

        axios.get(`${request}?page=${page}`)
            .then(response => {
                total_pages.value = response.data.meta.last_page
                per_page.value = response.data.meta.per_page
                current_page.value = response.data.meta.current_page
            })
            .catch(error => console.log(error))
            .finally(() => {
                isLoading.value = false
                if (source == 'sub-zones') {
                    getSubZones(`${request}?page=${page}`)
                }
            })
    }

    const onPageChange = (page) => {
        current_page.value = page
        if (sourceParam == 'sub-zones') {
            getPaginationDataWithRequest(page, sourceParam, requestParam)    
        }
        
        if (sourceParam == 'articles' || sourceParam == 'zones'){
            getPaginationData(page, sourceParam)
        }
    }

    return {
        isLoading,
        articles,
        zones,
        subZones,
        total_pages,
        per_page,
        current_page,
        search_global,
        onPageChange,
        zonesCount,
        subZonesCount,
        getPaginationData,
        getPaginationDataWithRequest,
    }
}