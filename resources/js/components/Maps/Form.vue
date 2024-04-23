<template>
    <GMapMap 
        ref="refMap"
        :center="{ lat: lat, lng: lng }" 
        :zoom="zoom" 
        :options=options
        map-type-id="terrain"
        style="width: 100%; height: 300px" >
        <GMapMarker
            v-if="marker"
            :position="{ lat: lat, lng: lng }" />
        <GMapCircle
            v-if="circle"
            :radius="circleRadius*1000"
            :center="{ lat: lat, lng: lng }"
            :options="zoneStyle" />
    </GMapMap>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    lat: Number,
    lng: Number,
    zoom: Number,
    marker: Boolean,
    circle: Boolean,
    circleRadius: Number,
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

</script>