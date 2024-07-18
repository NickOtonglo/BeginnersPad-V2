<template>
    <SearchBar 
        @search-initiated="filterLogs" 
        @search-cancelled="filterLogs" />
    <section id="sectionTable">
        <div class="container">
            <div class="container-btn-dropdown">
                <select v-model="filter_sort" @change="getPaginationDataWithRequest(1, `property_logs`, `${request}`)"
                    class="btn-dropdown">
                    <option value="desc">Sort by newest</option>
                    <option value="asc">Sort by oldest</option>
                </select>
            </div>
            <div class="table-grp">
                <h4 class="table-title">Property logs</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th v-if="user.role === 'Admin' || user.role === 'Super Admin' || user.role === 'System Admin'">Performed by</th>
                        <th>Location</th>
                        <th>Comments</th>
                        <th>Time</th>
                    </tr>
                    <template v-for="(item, index) in propertyLogs">
                        <tr>
                            <td>{{ index+1 }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.status }}</td>
                            <template v-if="item.method == 'POST'">
                                <td>property created</td>
                            </template>
                            <template v-else-if="item.method == 'PATCH' && item.name">
                                <td>property updated</td>
                            </template>
                            <template v-else-if="item.method == 'DELETE' || (item.method == 'PATCH' && !item.name)">
                                <td>property deleted</td>
                            </template>
                            <td v-if="user.role === 'Admin' || user.role === 'Super Admin' || user.role === 'System Admin'">@{{ item.action_by }}</td>
                            <td>{{ item.sub_zone }}, {{ item.zone }}, {{ item.county }}</td>
                            <td>{{ item.comment }}</td>
                            <td>{{ item.timestamp }}</td>
                        </tr>
                    </template>
                    <template v-if="propertyLogs && !propertyLogs.length">
                        <tr style="text-align: center;">-no logs-</tr>
                    </template>
                </table>
            </div>
            <Pagination v-if="propertyLogsCount >= 50" :totalPages="total_pages"
                :perPage="per_page"
                :currentPage="current_page"
                @pagechanged="onPageChange" />
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount, onBeforeUpdate, ref } from 'vue';
import userMaster from '../../composables/users'
import pagination from '../../composables/pagination'
import SearchBar from '../Search/SearchBar.vue';

const {
    search_global,
    filter_sort, 
    total_pages,
    per_page,
    current_page,
    propertyLogs,
    propertyLogsCount,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()

const { user, getUserData, route } = userMaster()
const request = ref(`/api/listings/logs/all`)

function filterLogs(input) {
    if (!input) {
        search_global.value = ''
    } else {
        search_global.value = input
    }
    getPaginationDataWithRequest(current_page.value, `property_logs`, request.value)
}

onBeforeMount(() => {
    getPaginationDataWithRequest(current_page.value, `property_logs`, request.value)
    filter_sort.value = 'desc'
    getUserData()
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})
</script>

<style scoped>
.table-grp table td {
    overflow: auto;
    text-overflow: unset;
    max-width: unset;
}
</style>