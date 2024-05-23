<template>
    <div class="modal" id="modal" ref="modalRef">
        <div class="modal-header">
            <h2>View log</h2>
            <button @click="operateModal(modalRef)" id="modalHeaderClose" class="btn-link btn-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="category">
                <div class="panel-grp">
                    <div v-if="log" class="panel">
                        <div class="panel-item">
                            <div class="data">
                                <ul>
                                    <li>Log ID: <span>{{ log.id }}</span></li>
                                    <li>Property name: 
                                        <a v-if="log.property_slug" :href="`/listings/${log.property_slug}`">{{ log.property_name }}</a>
                                    </li>
                                    <li>Author: 
                                        <a v-if="log.author_username" :href="`/users/profile/${log.author_username}`">@{{ log.author_username }}</a>
                                    </li>
                                    <li>Removal reason: <span>{{ log.removal_reason }}</span></li>
                                    <li>Removed by: <span>{{ log.action_by }}</span></li>
                                    <li>Timestamp: <span>{{ log.timestamp }}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-item">
                            <h3>Review</h3>
                            <p>{{ log.review }}</p>
                        </div>
                        <div class="panel-item">
                            <h3>Removal reason explaination</h3>
                            <p v-if="log.reason_details">{{ log.reason_details }}</p>
                            <p v-else>none given</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button @click="operateModal(modalRef)" id="modalFooterClose" class="btn btn-link">Close</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import operateModal from '../../composables/modal'

const modalRef = ref(null)

function openModal() {
    operateModal(modalRef.value)
}

const props = defineProps({
    log: Object,
})

defineExpose({
    openModal,
})

</script>