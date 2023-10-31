<template>
    <section id="sectionTable">
        <div class="container">
            <div class="table-grp">
                <h4 class="table-title">User logs</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Performed by</th>
                        <th>Comments</th>
                        <th>Time</th>
                    </tr>
                    <template v-for="(item, index) in logs">
                        <tr>
                            <td>{{ index+1 }}</td>
                            <td>@{{ item.username }}</td>
                            <template v-if="item.method == 'POST'">
                                <td>account created</td>
                            </template>
                            <template v-else-if="item.method == 'PATCH' && item.username">
                                <td>account updated</td>
                            </template>
                            <template v-else-if="item.method == 'DELETE' || (item.method == 'PATCH' && !item.username)">
                                <td>account deleted</td>
                            </template>
                            <td>@{{ item.action_by }}</td>
                            <td>{{ item.comment }}</td>
                            <td>{{ item.time_ago }}</td>
                        </tr>
                    </template>
                    <template v-if="logs && !logs.length">
                        <tr style="text-align: center;">-no logs-</tr>
                    </template>
                </table>
                <Pagination
                    :totalPages="total_pages"
                    :perPage="per_page"
                    :currentPage="current_page"
                    @pagechanged="onPageChange" />
            </div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import pagination from '../../composables/pagination';
import SearchBar from '../Search/SearchBar.vue';

const {
    search_global,
    filter_sort,
    total_pages,
    per_page,
    current_page,
    logs,
    onPageChange,
    getPaginationDataWithRequest,
    isLoading,
} = pagination()
const request = ref(`/api/users/logs/all`)

onBeforeMount(() => {
    getPaginationDataWithRequest(current_page.value, 'user_logs', request.value)
})
</script>

<style scoped>
.table-grp table td {
    overflow: auto;
    text-overflow: unset;
    max-width: unset;
}
</style>