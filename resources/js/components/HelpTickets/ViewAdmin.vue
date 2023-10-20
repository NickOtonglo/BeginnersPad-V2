<template>
    <h3 class="section-title">{{ ticket.topic }}</h3>

    <div class="section-ticket">
        <div class="container">
            <div class="panel-grp">
                <div class="panel">
                    <div class="panel-item">
                        <div class="data">
                            <ul>
                                <li>Ticket #<span>{{ ticket.id }}</span></li>
                                <li v-if="ticket.user">Issued by <span>{{ ticket.user }}</span></li>
                                <li v-else>Issued by <span>{{ ticket.email }}</span></li>
                                <li>Status: <span> {{ ticket.status }}</span></li>
                                <!-- <li>Priority: <span>0</span> (level)</li> -->
                                <li v-if="ticket.assigned_to">Assigned to: <span>{{ ticket.assigned_to }}</span></li>
                                <li v-else>Assigned to: <span>not assigned</span></li>
                                <li>Submitted on: <span>{{ ticket.timestamp }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-item">
                        <p>{{ ticket.description }}</p>
                    </div>
                    <form @submit.prevent="updateTicketStatus(`/api/help/tickets/manage/ticket/${ticket.id}`, ticket)" ref="formRef" :hidden="true">
                        <div class="form-group">
                            <input v-model="ticket.status" type="text" name="status" :disabled="true">
                        </div>
                        <button :disabled="true" ref="btnSubmitRef" class="btn-submit" type="submit">
                            <div v-show="isLoading" class="lds-dual-ring"></div>
                            <span v-if="isLoading">Loading...</span>
                            <span v-else>Save</span>
                        </button>
                    </form>
                    <div class="container-btn-dropdown multi">
                        <ButtonDropdown 
                            v-if="ticket.id && (ticket.status != 'resolved' &&  ticket.status != 'closed')" 
                            ref="buttonDropRef" 
                            :actionList="actionList" 
                            @action-selected="actionSelected"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="sectionTable">
        <div class="container">
            <div class="table-grp">
                <h4 class="table-title">Ticket log</h4>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Prior status</th>
                        <th>Action</th>
                        <th>Action by</th>
                        <th>New status</th>
                        <th>Timestamp</th>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>open</td>
                        <td>assigned</td>
                        <td>admin</td>
                        <td>pending</td>
                        <td>01-01-2021 00:00:00</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>open</td>
                        <td>assigned</td>
                        <td>admin</td>
                        <td>pending</td>
                        <td>01-01-2021 00:00:00</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>open</td>
                        <td>assigned</td>
                        <td>admin</td>
                        <td>pending</td>
                        <td>01-01-2021 00:00:00</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>open</td>
                        <td>assigned</td>
                        <td>admin</td>
                        <td>pending</td>
                        <td>01-01-2021 00:00:00</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref ,inject, onBeforeMount } from 'vue';
import ButtonDropdown from '../Misc/ButtonDropdown.vue';
import ticketMaster from '../../composables/tickets'
import userMaster from '../../composables/users'

const { updateTicketStatus, isLoading, ticket, getTicket, route } = ticketMaster()
const { getUserData, user } = userMaster()

let request = `/api/help/tickets/${route.params.id}`
const buttonDropRef = ref(null)
const formRef = ref(null)
const btnSubmitRef = ref(null)
const swal = inject('$swal')
// const actionList = ref([`Pick ticket`, `Release ticket`, `Close as 'resolved'`, `Close ticket`])
const actionList = ref([
    {
        id: 1,
        text: `Pick ticket`,
    }, 
    {
        id: 2,
        text: `Release ticket`,
    }, 
    {
        id: 3,
        text: `Close as 'resolved'`,
    }, 
    {
        id: 4,
        text: `Close ticket`,
    }
])

onBeforeMount(() => {
    getTicket(request)
    getUserData()
})

// https://vuejs.org/guide/components/events.html#event-arguments
function actionSelected(action) {
    if (action == `Pick ticket`) {
        if (ticket.value.assigned_to == user.value.username) {
            swal({
                icon: 'error',
                title: 'Error!',
                text: 'This ticket is already assigned to you.'
            })
        } else {
            ticket.value.status = `pending`
            ticket.value.assigned_to = user.value.username
            btnSubmitRef.value.disabled = isLoading
            btnSubmitRef.value.click()
        }
    }
    if (action == `Release ticket`) {
        if (ticket.value.assigned_to != user.value.username) {
            swal({
                icon: 'error',
                title: 'Error!',
                text: `This ticket isn't assigned to you.`
            })
        } else {
            ticket.value.status = `open`
            ticket.value.assigned_to = null
            btnSubmitRef.value.disabled = isLoading
            btnSubmitRef.value.click()
        }
    }
    if (action == `Close as 'resolved'`) {
        swal.fire({
            title: 'Are you sure?',
            text: "This action is irreversible.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                ticket.value.status = `resolved`
                ticket.value.assigned_to = user.value.username
                btnSubmitRef.value.disabled = isLoading
                btnSubmitRef.value.click()
            }
        })
    }
    if (action == `Close ticket`) {
        swal.fire({
            title: 'Are you sure?',
            text: "This action is irreversible.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                ticket.value.status = `closed`
                ticket.value.assigned_to = user.value.username
                btnSubmitRef.value.disabled = isLoading
                btnSubmitRef.value.click()
            }
        })
    }
}


</script>

<style scoped>
form, 
form > *, 
form input {
    height: 0px;
    display: none;
}
</style>