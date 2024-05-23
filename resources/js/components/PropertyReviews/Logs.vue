<template>
    <SearchBar 
        @search-initiated="filterLogs" 
        @search-cancelled="filterLogs" />
    <section id="sectionTable">
        <div class="container">
            <div class="container-btn-dropdown">
                <select v-model="filter_sort" @change="getPaginationDataWithRequest(1, `property_review_removal_logs`, `${request}`)"
                    class="btn-dropdown">
                    <option value="desc">Sort by newest</option>
                    <option value="asc">Sort by oldest</option>
                </select>
            </div>
            <div class="table-grp">
                <h4 class="table-title">Review removal logs</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Property</th>
                        <th>Author</th>
                        <th>Removal reason</th>
                        <th v-if="user.role === 'Admin' || user.role === 'Super Admin' || user.role === 'System Admin'">Removed by</th>
                        <th>Rating</th>
                        <th>Time</th>
                    </tr>
                    <template v-for="(item, index) in removalLogs">
                        <tr @click="removalLog = item, click(viewLogModalRef)">
                            <td>{{ index+1 }}</td>
                            <td>{{ item.property_name }}</td>
                            <td>{{ item.author_username }}</td>
                            <td>{{ item.removal_reason }}</td>
                            <td v-if="user.role === 'Admin' || user.role === 'Super Admin' || user.role === 'System Admin'">@{{ item.action_by }}</td>
                            <td>{{ item.rating }}</td>
                            <td>{{ item.timestamp }}</td>
                        </tr>
                    </template>
                    <template v-if="removalLogs && !removalLogs.length">
                        <tr style="text-align: center;">-no logs-</tr>
                    </template>
                </table>
            </div>
            <Pagination v-if="removalLogsCount >= 50" :totalPages="total_pages"
                :perPage="per_page"
                :currentPage="current_page"
                @pagechanged="onPageChange" />
        </div>
    </section>

    <ViewLogModal :log="removalLog" ref="viewLogModalRef" />
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import userMaster from '../../composables/users'
import pagination from '../../composables/pagination'
import SearchBar from '../Search/SearchBar.vue';
import ViewLogModal from '../Modals/ViewRemovedReviewLog.vue'
import propertyReviewsMaster from '../../composables/property_reviews';

const {
    search_global,
    filter_sort, 
    total_pages,
    per_page,
    current_page,
    removalLogs,
    removalLogsCount,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()

const { removalLog } = propertyReviewsMaster()
const { user, getUserData } = userMaster()
const request = ref(`/api/reviews/removal/logs`)
const viewLogModalRef = ref(null)

function filterLogs(input) {
    if (!input) {
        search_global.value = ''
    } else {
        search_global.value = input
    }
    getPaginationDataWithRequest(current_page.value, `property_review_removal_logs`, request.value)
}

function click(element) {
    element.openModal();
}

onBeforeMount(() => {
    getPaginationDataWithRequest(current_page.value, `property_review_removal_logs`, request.value)
    filter_sort.value = 'desc'
    getUserData()
})
</script>

<style scoped>
.table-grp table td {
    overflow: auto;
    text-overflow: unset;
    max-width: unset;
}
</style>