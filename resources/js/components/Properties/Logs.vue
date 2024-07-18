<template>
    <section id="sectionTable">
        <div class="container">
            <div class="table-grp">
                <h4 class="table-title">Property logs</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th v-if="user.role === 'Admin' || user.role === 'Super Admin' || user.role === 'System Admin'">Performed by</th>
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
                            <td>{{ item.comment }}</td>
                            <td>{{ item.time_ago }}</td>
                        </tr>
                    </template>
                    <template v-if="propertyLogs && !propertyLogs.length">
                        <tr style="text-align: center;">-no logs-</tr>
                    </template>
                </table>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount, onBeforeUpdate, ref } from 'vue';
import propertiesMaster from '../../composables/properties';
import userMaster from '../../composables/users'

const {
    propertyLogs,
    getPropertyLogs,
    isLoading,
    route,
} = propertiesMaster()
const { user, getUserData } = userMaster()

onBeforeMount(() => {
    getPropertyLogs(`/api/listings/${route.params.slug}/logs`)
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