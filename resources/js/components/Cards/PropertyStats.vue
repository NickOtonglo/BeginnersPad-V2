<template>
    <div class="listing-grp-bordered">
        <ul>
            <template v-if="property.status !== 'suspended' && property.status !== 'rejected'">
                <li>Status: <span id="statsListingStatus">{{ property.status }}</span></li>
            </template>
            <template v-else>
                <li v-if="logs && logs.length">Status: <span id="statsListingStatus">{{ property.status }} (reason: {{
                    logs[logs.length - 1].comment }})</span></li>
            </template>
            <li>Date added: <span id="statsListingTimestamp">{{ property.timestamp }}</span></li>
            <li>Times favourited: <span id="statsListingFavourites">{{ property.favourite_count }}</span></li>
            <li v-if="logs && logs.length">Times suspended: <span id="statsListingSuspended">{{ logs[logs.length - 1].suspended_count }}</span></li>
            <li>No. of units: <span id="statsUnitCount">{{ property.units.length }}</span></li>
        </ul>
    </div>
</template>

<script setup>
import { onBeforeMount } from 'vue';
import propertiesMaster from '../../composables/properties';

const { logs, getLogs, route } = propertiesMaster()
const props = defineProps({
    property: Object,
})

onBeforeMount(() => {
    getLogs(`/api/listings/${route.params.slug}/logs`)
})
</script>