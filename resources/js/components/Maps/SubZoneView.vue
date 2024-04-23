<template>
    <GMapMap 
        :center="{ lat: subZone.lat, lng: subZone.lng }" 
        :zoom="10" 
        :options=options
        map-type-id="terrain"
        style="width: 100%; height: 350px">
        <GMapMarker
            v-for="property in properties"
            :key="property.slug"
            :position="{ lat: property.lat, lng: property.lng }"
            @click="goToProperty(property.slug)" />
    </GMapMap>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const props = defineProps({
    subZone: Object,
    properties: Array
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

function goToProperty(id) {
    router.push({ name: 'property.view', params: { slug: id } })
}
</script>