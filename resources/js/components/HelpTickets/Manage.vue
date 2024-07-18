<template>
    <SearchBar 
        @search-initiated="filterTickets" 
        @search-cancelled="filterTickets" />
    <section id="sectionTable">
        <div class="container">
            <div class="container-btn-dropdown multi">
                <router-link :to="{ name: 'tag.articles', params: { name: `help` } }" class="btn btn-link">Help articles</router-link>
                <select v-model="representative" @change="fetchTickets(`/api/help/tickets/manage${representative}`)" ref="repListRef" class="btn-dropdown">
                    <option value="" disabled>-- asigned to --</option>
                    <option value="/all">All</option>
                    <template v-for="item in ticketsRepsList">
                        <option v-if="item.username == user.username" :value="`/reps/${item.username}`">{{ item.username }} (me)</option>
                        <option v-else :value="`/reps/${item.username}`">{{ item.username }}</option>
                    </template>
                </select>
            </div>
            
            <div class="table-grp">
                <h4 class="table-title">Help tickets</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Email/username</th>
                        <th>Registered</th>
                        <th>Topic</th>
                        <!-- <th>Priority</th> -->
                        <th>Status</th>
                        <th>Assigned to</th>
                        <th>Submitted</th>
                    </tr>
                    <template v-if="tickets" v-for="(item, index) in tickets">
                        <tr @click="ticket = item, click(viewTicketRef)" class="data">
                            <td>{{ item.id }}</td>
                            <td v-if="item.email">{{ item.email }}</td>
                            <td v-else-if="item.user">@{{ item.user }}</td>
                            <td>{{ item.isRegistered }}</td>
                            <td>{{ item.topic }}</td>
                            <!-- <td>{{ item.priority }}</td> -->
                            <td>{{ item.status }}</td>
                            <td v-if="item.assigned_to">@{{ item.assigned_to }}</td>
                            <td v-else>not assigned</td>
                            <td>{{ item.time_ago }}</td>
                        </tr>
                    </template>
                    <template v-if="!tickets.length">
                        <tr style="text-align: center;">-no tickets-</tr>
                    </template>
                </table>
            </div>
            <Pagination v-if="ticketsCount > 150" :totalPages="total_pages"
                :perPage="per_page"
                :currentPage="current_page"
                @pagechanged="onPageChange" />
        </div>
    </section>

    <button id="modalTrigger" style="display: none;"></button>

    <ViewTicketModal ref="viewTicketRef" :ticket="ticket" :user="user" />
    
</template>

<script setup>
import { onBeforeMount, ref, onBeforeUpdate } from 'vue';
import pagination from '../../composables/pagination'
import ticketsMaster from '../../composables/tickets';
import ViewTicketModal from '../Modals/ViewTicket.vue'
import SearchBar from '../Search/SearchBar.vue';

const {
    search_global,
    total_pages,
    per_page,
    current_page,
    tickets,
    ticketsCount,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()

const { ticketsRepsList, getRepsList, ticket, getTicket, route } = ticketsMaster()

const repListRef = ref(null)
const viewTicketRef = ref(null)
const representative = ref(``)

let request = `/api/help/tickets/manage/all`

function fetchTickets(req) {
    getPaginationDataWithRequest(current_page.value, 'help_tickets', req)
}

function filterTickets(input) {
    search_global.value = input
    if (!input) {
        search_global.value = ''
    }
    representative.value = ``
    fetchTickets(request)
}

function click(element) {
    element.openModal();
}

onBeforeMount(() => {
    fetchTickets(request)
    getRepsList(`/api/help/tickets/manage/reps`)
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})

const props = defineProps({
    user: Object,
})
</script>