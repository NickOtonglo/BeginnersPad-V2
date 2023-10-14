<template>
    <section>
        <div class="container">
            <div class="ticket-full">
                <h3>Ticket #{{ ticket.id }}</h3>
                <h4>Issued on {{ ticket.timestamp }}</h4>
                <h4 v-if="ticket.assigned_to">Assigned to: @{{ ticket.assigned_to }}</h4>
                <h4 v-else>Assigned to: not assigned</h4>
                <h4>Status: {{ ticket.status }}</h4>
                <h2 class="title-main">RE: {{ ticket.topic }}</h2>
                <p class="text-main">{{ ticket.description }}</p>
            </div>
            <div v-if="ticket.user && ticket.user == user.username && ticket.status == 'open'" class="btn-grp vertical">
                <button @click="click(editTicketRef)">Edit</button>
                <button @click="deleteTicket(request)">Delete</button>
            </div>
        </div>
    </section>

    <EditTicketModal ref="editTicketRef" :ticket="ticket" />
</template>

<script setup>
import { ref, onBeforeMount } from 'vue';
import ticketsMaster from '../../composables/tickets';
import userMaster from '../../composables/users';
import EditTicketModal from '../Modals/EditTicket.vue'

const { ticket, getTicket, route, deleteTicket } = ticketsMaster()
const { user, getUserData } = userMaster()
let request = `/api/help/tickets/${route.params.id}`
const editTicketRef = ref(null)

onBeforeMount(() => {
    getTicket(request)
    getUserData()
})

function click(element) {
    element.openModal();
}

</script>