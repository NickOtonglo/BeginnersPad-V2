<template>
    <section class="section-read links" id="tickets-user-list">
        <div class="container">
            <h3 class="section-title">Tickets</h3>
            <div class="panel-grp">
                <div class="panel">
                    <div v-for="item in tickets" class="list">
                        <div class="item item-bottom-border">
                            <h4>Ticket #{{ item.id }}</h4>
                            <h5>Issued on {{ item.timestamp }}</h5>
                            <h5>Priority: normal</h5>
                            <h5 v-if="item.assigned_to">Assigned to: @{{ item.assigned_to }}</h5>
                            <h5 v-else>Assigned to: not assigned</h5>
                            <h5>Status: {{ item.status }}</h5>
                            <h3 class="title-main">{{ item.topic }}</h3>
                            <p class="text-main">{{ item.description }}</p>
                            <router-link :to="{ name: 'ticket.view', params: { id: item.id } }">View ticket <i class="fas fa-chevron-right"></i></router-link>
                        </div>
                    </div>
                    <div v-if="tickets && !tickets.length" class="list">
                        <p v-if="status === 'all' || status === ''" style="text-align: center;">-no tickets-</p>
                        <p v-else style="text-align: center;">-no {{ status }} tickets-</p>
                    </div>
                </div>
                <div class="panel" id="panel-tickets-user">
                    <div class="tickets-categories-user">
                        <h3>Categories</h3>
                        <div class="btn-grp vertical">
                            <button @click="status='all', fetchTickets(`${request}`)" :class="{ 'selected' : status === 'all' || status === '' }">All</button>
                            <button @click="status='pending', fetchTickets(`${request}/status/${status}`)" :class="{ 'selected' : status === 'pending' }">Pending</button>
                            <button @click="status='resolved', fetchTickets(`${request}/status/${status}`)" :class="{ 'selected' : status === 'resolved' }">Resolved</button>
                            <button @click="status='open', fetchTickets(`${request}/status/${status}`)" :class="{ 'selected' : status === 'open' }">Open</button>
                            <button @click="status='closed', fetchTickets(`${request}/status/${status}`)" :class="{ 'selected' : status === 'closed' }">Closed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Pagination v-if="ticketsCount > 40" :totalPages="total_pages"
                :perPage="per_page"
                :currentPage="current_page"
                @pagechanged="onPageChange" />
</template>

<script setup>
import { onBeforeMount, onBeforeUpdate } from 'vue';
import pagination from '../../composables/pagination'
import ticketsMaster from '../../composables/tickets';

const {
    total_pages,
    per_page,
    current_page,
    tickets,
    ticketsCount,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()

const { route } = ticketsMaster()

let request = `/api/help/tickets`
let status = '';

function fetchTickets(req) {
    getPaginationDataWithRequest(current_page.value, 'help_tickets', req)
}

onBeforeMount(() => {
    fetchTickets(request)
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})
</script>