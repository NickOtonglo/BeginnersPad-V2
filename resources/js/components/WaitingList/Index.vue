<template>
    <div class="fab-container">
        <button  @click="click(joinWaitingListRef)" class="fab btn-primary"><i class="fas fa-plus"></i> Join</button>
    </div>

    <section class="showcase-small">
        <div class="showcase-overlay">
            <div class="container">
                <div>
                    <h2>{{ plan.name }}</h2>
                    <p>{{ plan.description }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-blank"></section>

    <section id="sectionTable">
        <div class="container">
            <table class="horizontal-scroll">
                <tr class="single-column">
                    <th>Your subscription</th>
                </tr>
                <template v-if="subscription">
                    <tr class="single-column">
                        <th>Plan</th>
                        <th>Activated</th>
                        <th>Period</th>
                        <th>Valid til</th>
                        <th>Expires</th>
                    </tr>
                    <tr class="single-column">
                        <td>{{ subscription.plan }}</td>
                        <td>{{ subscription.activated_at }}</td>
                        <td v-if="subscription.period_months > 1">{{ subscription.period_months }} days</td>
                        <td v-else>{{ subscription.period_months }} day</td>
                        <td>{{ subscription.expires_at }}</td>
                        <td>{{ subscription.time_left }}</td>
                    </tr>
                </template>
                <template v-else>
                    <tr class="single-column">
                        <td></td>
                        <td>You have no subscription history</td>
                        <td></td>
                    </tr>
                </template>
            </table>
            <table class="horizontal-scroll">
                <tr class="single-column">
                    <th>Waiting lists</th>
                </tr>
                <template v-if="subscription">
                    <tr class="single-column">
                        <th>Zone</th>
                        <th>County</th>
                        <th>No. of listings</th>
                        <th>Radius</th>
                        <th></th>
                    </tr>
                    <tr v-for="list in subscription.waiting_lists" class="single-column">
                        <td>{{ list.zone }}</td>
                        <td>{{ list.county }}</td>
                        <td>{{ list.properties_count }}</td>
                        <td>{{ list.radius }} km</td>
                        <td><a id="linkLeave" href="#" @click.prevent="removeWaitingList(`/api/premium/plans/waiting-list/${list.zone_id}`)">Leave</a></td>
                    </tr>
                </template>
            </table>
        </div>
    </section>
    
    <JoinWaitingList ref="joinWaitingListRef" />
</template>

<script setup>
import { ref, onBeforeMount, onMounted } from 'vue';
import premiumMaster from '../../composables/premium';
import JoinWaitingList from '../Modals/JoinWaitingList.vue';

const {
    isLoading, 
    plan, 
    subscription, 
    getPlan, 
    getSubscription,
    removeWaitingList, 
} = premiumMaster()

const leaveRef = ref(null)
const joinWaitingListRef = ref(null)

function click(element) {
    element.openModal();
}

onMounted(() => {
    getPlan(`/api/premium/plan/waiting-list`)
    getSubscription(`/api/premium/plans/waiting-list`)
})

</script>

<style scoped>
#linkLeave {
    color: var(--color-danger);
}
</style>