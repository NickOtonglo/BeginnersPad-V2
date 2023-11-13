<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>Ticket #{{ ticket.id }}</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <div class="panel-grp">
                    <div class="panel">
                        <div class="panel-item">
                            <div class="data">
                                <ul>
                                    <li>Ticket ID: <span>{{ ticket.id }}</span></li>
                                    <li v-if="ticket.user">Issued by <span>@{{ ticket.user }}</span></li>
                                    <li v-else>Issued by <span>{{ ticket.email }}</span></li>
                                    <li>Status: <span>{{ ticket.status }}</span></li>
                                    <!-- <li>Priority: <span>0</span> (level)</li> -->
                                    <li v-if="ticket.assigned_to && user.username != ticket.assigned_to">Assigned to: <span>{{ ticket.assigned_to }}</span></li>
                                    <li v-else-if="ticket.assigned_to && user.username == ticket.assigned_to">Assigned to: @<span>{{ ticket.assigned_to }} (me)</span></li>
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
        <div class="modal-footer">
            <!-- <router-link v-if="ticket && ticket.user" :to="{ name: 'user.manage', params: { username: ticket.user } }" class="btn btn-link">View user</router-link> -->
            <a class="btn btn-link" :href="`/users/profile/${ticket.user}`">View user</a>
            <router-link :to="{ name: 'tickets.list' }" @click="operateModal(modalRef)" class="btn btn-link">View user's tickets</router-link>
            <router-link v-if="ticket.id" :to="{ name: 'ticket.view', params: { id: ticket.id } }" @click="operateModal(modalRef)" class="btn btn-link">Go to ticket</router-link>
            <button @click="operateModal(modalRef)" id="modalFooterClose" class="btn btn-link">Close</button>
        </div>
    </div>
</template>

<script setup>
import { ref ,inject } from 'vue';
import operateModal from '../../composables/modal'
import ButtonDropdown from '../Misc/ButtonDropdown.vue';
import ticketMaster from '../../composables/tickets'

const { updateTicketStatus, isLoading } = ticketMaster()
const buttonDropRef = ref(null)
const modalRef = ref(null)
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


function openModal() {
    operateModal(modalRef.value)
}

// https://vuejs.org/guide/components/events.html#event-arguments
function actionSelected(action) {
    if (action == `Pick ticket`) {
        if (props.ticket.assigned_to == props.user.username) {
            swal({
                icon: 'error',
                title: 'Error!',
                text: 'This ticket is already assigned to you.'
            })
        } else {
            props.ticket.status = `pending`
            props.ticket.assigned_to = props.user.username
            btnSubmitRef.value.disabled = isLoading
            btnSubmitRef.value.click()
        }
    }
    if (action == `Release ticket`) {
        if (props.ticket.assigned_to != props.user.username) {
            swal({
                icon: 'error',
                title: 'Error!',
                text: `This ticket isn't assigned to you.`
            })
        } else {
            props.ticket.status = `open`
            props.ticket.assigned_to = null
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
                props.ticket.status = `resolved`
                props.ticket.assigned_to = props.user.username
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
                props.ticket.status = `closed`
                props.ticket.assigned_to = props.user.username
                btnSubmitRef.value.disabled = isLoading
                btnSubmitRef.value.click()
            }
        })
    }
    // formRef.value.submit()
}

const props = defineProps({
    ticket: Object,
    user: Object,
})

defineExpose({
    openModal,
})

</script>

<style scoped>
form, 
form > *, 
form input {
    height: 0px;
    display: none;
}
</style>