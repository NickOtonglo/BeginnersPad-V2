import { ref } from "vue"
import articlesMaster from './articles'
import zonesMaster from "./zones"
import subZoneMaster from './subzones'
import propertiesMaster from "./properties"
import unitsMaster from "./units"
import favouriteMaster from './favourites'
import ticketsMaster from "./tickets"
import userMaster from "./users"

export default function pagination() {
    const isLoading = ref(false)
    const total_pages = ref(0)
    const per_page = ref(0)
    const current_page = ref(1)
    const search_global = ref('')
    const filter_sort = ref('')
    const { getArticles, articles } = articlesMaster()
    const { zones, getZones, zonesCount } = zonesMaster()
    const { subZones, getSubZones, subZonesCount } = subZoneMaster()
    const { properties, getProperties, propertiesCount } = propertiesMaster()
    const { units, getUnits, unitsCount } = unitsMaster()
    const { favourites, getFavourites, favouritesCount } = favouriteMaster()
    const { tickets, getTickets, ticketsCount } = ticketsMaster()
    const { users, getUsers, usersCount, logs, getLogs } = userMaster()
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
                    if (!filter_sort.value) {
                        filter_sort.value = 'DESC'
                    }
                    getArticles(`/api/${source}?page=${page}&search_global=${search_global.value}&sort=${filter_sort.value}`)
                } else if (source == 'zones') {
                    getZones(`/api/${source}?page=${page}&search_global=${search_global.value}&sort=${filter_sort.value}`)
                }
                // callback(page, search_global.value)
            })
    }

    const getPaginationDataWithRequest = (page, source, request) => {
        if(isLoading.value) {return}
        isLoading.value = true
        sourceParam = source
        requestParam = request

        axios.get(`${request}?page=${page}&search_global=${search_global.value}`)
            .then(response => {
                total_pages.value = response.data.meta.last_page
                per_page.value = response.data.meta.per_page
                current_page.value = response.data.meta.current_page
            })
            .catch(error => console.log(error))
            .finally(() => {
                isLoading.value = false
                if (source == 'sub-zones') {
                    getSubZones(`${request}?page=${page}&sort=${filter_sort.value}`)
                }
                if (source == 'properties') {
                    getProperties(`${request}?page=${page}&search_global=${search_global.value}&sort=${filter_sort.value}`)
                }
                if (source == 'property_units') {
                    getUnits(`${request}?page=${page}`)
                }
                if (source == 'favourites') {
                    getFavourites(`${request}?page=${page}&search_global=${search_global.value}`)
                }
                if (source[1] == 'Property' || source[1] == 'PropertyUnit' || source[1] == 'Article') {
                    getFavourites(`${request}?page=${page}&search_global=${search_global.value}`)
                }
                if (source == 'help_tickets') {
                    getTickets(`${request}?page=${page}&search_global=${search_global.value}`)
                }
                if (source == 'articles') {
                    filter_sort.value = 'DESC'
                    getArticles(`${request}?page=${page}&search_global=${search_global.value}&sort=${filter_sort.value}`)
                }
                if (source == 'users') {
                    getUsers(`${request}?page=${page}&search_global=${search_global.value}&sort=${filter_sort.value}`)
                }
                if (source == 'user_logs') {
                    getLogs(`${request}?page=${page}&search_global=${search_global.value}`)
                }
            })
    }

    const onPageChange = (page) => {
        current_page.value = page
        if (
            sourceParam == 'sub-zones' || 
            sourceParam == 'properties' || 
            sourceParam == 'property_units' || 
            sourceParam == 'help_tickets' || 
            sourceParam == 'users' ||
            sourceParam == 'user_logs'
        ) {
            getPaginationDataWithRequest(page, sourceParam, requestParam)    
        }

        if (
            sourceParam[0] == 'favourites' && (
                sourceParam[1] == 'Article' ||
                sourceParam[1] == 'PropertyUnit' ||
                sourceParam[1] == 'Property'
            )
        ) {
            getPaginationDataWithRequest(page, sourceParam, requestParam)    
        }
        
        if (sourceParam == 'articles' || sourceParam == 'zones'){
            getPaginationData(page, sourceParam)
            // if (requestParam) {
            //     console.log('requestParam', requestParam)
            //     getPaginationDataWithRequest(page, sourceParam, requestParam)
            // } else {
            //     console.log('no requestParam')
            // }
        }
    }

    return {
        isLoading,
        articles,
        zones,
        subZones,
        properties,
        units,
        favourites,
        tickets,
        users,
        logs,
        total_pages,
        per_page,
        current_page,
        search_global,
        filter_sort,
        onPageChange,
        zonesCount,
        subZonesCount,
        propertiesCount,
        unitsCount,
        favouritesCount,
        ticketsCount,
        usersCount,
        getPaginationData,
        getPaginationDataWithRequest,
    }
}