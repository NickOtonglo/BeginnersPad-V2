<template>
    <GMapMap 
        :center=center 
        :zoom="5.62" 
        :options=options
        map-type-id="terrain"
        style="width: 100%; height: 350px">
        <GMapCircle
            v-if="zones"
            v-for="zone in zones"
            @click="goToZone(zone.id)"
            :key="zone.id"
            :radius="zone.radius*1000"
            :center="{ lat: zone.lat, lng: zone.lng }"
            :options="zoneStyle"
        />
    </GMapMap>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import zonesMaster from '../../composables/zones';
import { useRouter } from 'vue-router'

const router = useRouter()
const { zones, getZones } = zonesMaster()
const center = ref({
    lat: 0.241829,
    lng: 37.815589,
})
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

function goToZone(zoneId) {
    router.push({ name: 'zone.view', params: { id: zoneId } })
}

onMounted(() => {
    getZones(`/api/zones`)
})
</script>