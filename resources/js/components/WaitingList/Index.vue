<template>
    <div v-if="subscription && subscription.status == 'active'" class="fab-container">
        <button @click="click(joinWaitingListRef)" class="fab btn-primary"><i class="fas fa-plus"></i> Join</button>
    </div>
    <div v-else class="fab-container">
        <button @click="subscribe" class="fab btn-primary"><i class="fas fa-check"></i> Subscribe</button>
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

    <section class="section-blank">
        <div class="container">
            <h4>This plan costs {{ plan.price }} credits and is valid for {{ plan.minimum_days }} days</h4>
        </div>
    </section>

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
                        <th v-if="subscription.status == 'active'">Expires</th>
                        <th v-else-if="subscription.status == 'inactive'">Expired</th>
                        <th></th>
                    </tr>
                    <tr class="single-column">
                        <td>{{ subscription.plan }}</td>
                        <td>{{ subscription.activated_at }}</td>
                        <td v-if="subscription.period_days > 1">{{ subscription.period_days }} days</td>
                        <td v-else>{{ subscription.period_days }} day</td>
                        <td>{{ subscription.expires_at }}</td>
                        <td>{{ subscription.time_left }}</td>
                        <td v-if="subscription.status == 'active'"><i class="fa-solid fa-circle-check sub-active"></i>
                        </td>
                        <td v-else-if="subscription.status == 'inactive'"><i
                                class="fa-solid fa-circle-xmark sub-inactive"></i></td>
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
            <table v-if="subscription" class="horizontal-scroll">
                <tr class="single-column">
                    <th>Waiting lists <span v-if="plan">({{ plan.sub_limit - subscription.waiting_lists.length }} left)</span></th>
                </tr>
                <template v-if="subscription">
                    <tr class="single-column">
                        <th>Zone</th>
                        <th>County</th>
                        <th>No. of listings</th>
                        <th>Radius</th>
                        <th></th>
                    </tr>
                    <template v-if="subscription.waiting_lists && subscription.waiting_lists.length" class="form-group">
                        <tr v-for="list in subscription.waiting_lists" class="single-column">
                            <td>{{ list.zone }}</td>
                            <td>{{ list.county }}</td>
                            <td>{{ list.properties_count }}</td>
                            <td>{{ list.radius }} km</td>
                            <td><a id="linkLeave" href="#"
                                    @click.prevent="removeWaitingList(`/api/premium/plans/waiting-list/${list.zone_id}`)">Leave</a>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr class="single-column">
                            <td></td>
                            <td></td>
                            <td>You are not on any waiting lists</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </template>
                </template>
            </table>
        </div>
    </section>

    <JoinWaitingList ref="joinWaitingListRef" />
</template>

<script setup>
import { ref, onMounted } from 'vue';
import premiumMaster from '../../composables/premium';
import JoinWaitingList from '../Modals/JoinWaitingList.vue';

const {
    isLoading, 
    plan, 
    subscription, 
    getPlan, 
    getSubscription,
    removeWaitingList, 
    createSubscription, 
} = premiumMaster()

const leaveRef = ref(null)
const joinWaitingListRef = ref(null)

function subscribe() {
    const data = ref({
        slug: '',
        price: '',
    })
    data.value.slug = `waiting-list`
    data.value.price = plan.value.price
    data.value.period = plan.value.minimum_days
    createSubscription(`/api/premium/subscriptions`, data.value)
}

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
.sub-active {
    color: rgb(13, 180, 138);
}
.sub-inactive {
    color: rgb(238, 14, 14);
}
</style>