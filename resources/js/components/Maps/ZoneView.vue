<template>
    <GMapMap 
        :center="{ lat: zone.lat, lng: zone.lng, }" 
        :zoom="12" 
        :options=options
        map-type-id="terrain"
        style="width: 100%; height: 350px">
        <GMapCircle
            v-if="subZones"
            v-for="subZone in subZones"
            @click="gotToSubZone(subZone.id)"
            :key="subZone.id"
            :radius="subZone.radius*1000"
            :center="{ lat: subZone.lat, lng: subZone.lng }"
            :options="zoneStyle" />
    </GMapMap>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const props = defineProps({
    zone: Object,
    subZones: Array
})

const router = useRouter()

const options = ref({
    zoomControl: true,
    mapTypeControl: false,
    scaleControl: false,
    streetViewControl: false,
    rotateControl: false,
    fullscreenControl: false,
})

const zoneStyle = ref({
    strokeColor: "#703680",
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: "#703680",
    fillOpacity: 0.35,
})

function gotToSubZone(subZoneId) {
    router.push({ name: 'sub-zone.view', params: { zone_id: props.zone.id, sub_id: subZoneId } })
}
</script>