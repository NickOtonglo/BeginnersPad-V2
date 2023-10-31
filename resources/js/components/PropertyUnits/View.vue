<template>
    <section class="section-unit-main">
        <div class="container">
            <div class="main-img">
                <!-- Images -->
                <template v-if="unit.files && unit.files[0]">
                    <div class="img" :style="{ background: `url(/images/listings/${route.params.slug}/${route.params.unit_slug}/${unit.files[0].name})` }" style="background-size: cover;">
                        <!-- API -->
                        <div v-if="unit.files && unit.files[0]" @click="openImageBrowser" class="more-images" id="toggleUnitImg">
                            <i class="fas fa-images"></i>
                            <span> All images ({{ unit.files.length }})</span>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="img"></div>
                </template>
                <template v-if="unit.files && unit.files[1]">
                    <div class="img" :style="{ background: `url(/images/listings/${route.params.slug}/${route.params.unit_slug}/${unit.files[1].name})` }" style="background-size: cover;"></div>
                </template>
                <template v-else>
                    <div class="img"></div>
                </template>
                <template v-if="unit.files && unit.files[2]">
                    <div class="img" :style="{ background: `url(/images/listings/${route.params.slug}/${route.params.unit_slug}/${unit.files[2].name})` }" style="background-size: cover;"></div>
                </template>
                <template v-else>
                    <div class="img"></div>
                </template>
                <template v-if="unit.files && unit.files[3]">
                    <div class="img" :style="{ background: `url(/images/listings/${route.params.slug}/${route.params.unit_slug}/${unit.files[3].name})` }" style="background-size: cover;"></div>
                </template>
                <template v-else>
                    <div class="img"></div>
                </template>
            </div>
            <!-- Info -->
            <div class="main-info">
                <div class="info-name">
                    <div class="info-actions">
                        <div><i class="fas fa-share-alt" id="modalTrigger"></i></div>
                        <div @click="saveFavourite(`/api/favourites`, unit, 'PropertyUnit')"><i class="fas fa-heart" :class="{ active: unit.favourite }"></i></div>
                        <router-link v-if="user.username === unit.property.user_name" :to="{ name: 'unit.manage', params: { slug: route.params.slug, unit_slug: route.params.unit_slug } }"><i class="fas fa-edit"></i></router-link>
                    </div>
                </div>
                <h2>{{ unit.name }}</h2>
                <p class="price">KES {{ unit.price }}</p>
                <p v-if="unit.init_deposit == 0" class="deposit">Initial deposit: not required</p>
                <p v-else class="deposit">Initial deposit: KES {{ unit.init_deposit }} (for {{ unit.init_deposit_period }} months)</p>
                <p class="floor">Floor/story: {{ unit.story }}</p>
                <p class="timestamp">Added on {{ unit.timestamp }}</p>
                <p class="description">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Totam quae explicabo numquam soluta in
                    repellat, consectetur iure officiis beatae alias quibusdam sit saepe, quam pariatur.</p>
            </div>
            
            <div>
                <!-- directive -->
                <div class="images" v-viewer>
                    <img v-for="src in images" :key="src" :src="src">
                </div>
                <!-- component -->
                <viewer :images="images">
                    <img v-for="src in images" :key="src" :src="src">
                </viewer>
            </div>
        </div>
    </section>

    <section class="section-unit-secondary">
        <div class="container">
            <div class="panel-grp">
                <div class="panel">
                    <div class="listing-features">
                        <div class="title-grp">
                            <h3>Unit features</h3>
                        </div>
                        <div class="features">
                            <ul>
                                <li><span>{{ unit.bathrooms }} bathrooms</span></li>
                                <li><span>{{ unit.bedrooms }} bedrooms</span></li>
                                <li><span>{{ unit.floor_area }} sq M floor area</span></li>
                                <template v-if="unit.features.length" v-for="feature in unit.features">
                                    <li><span>{{ feature.item }}</span></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    <div class="unit-disclaimer">
                        <div class="title-grp">
                            <h3>Disclaimer (important)</h3>
                        </div>
                        <div v-if="unit.disclaimer.length" class="features">
                            <ul v-for="item in unit.disclaimer">
                                <li><span>{{ item }}</span></li>
                            </ul>
                        </div>
                        <template v-else>
                            <p style="text-align: center;">-no disclaimer-</p>
                        </template>
                    </div>
                </div>
                <div class="panel">
                    <div class="listing-units-list">
                        <h3>Property</h3>
                        <CardProperty :property="unit.property" />
                    </div>
                    <div class="listing-actions">
                        <h3>Actions</h3>
                        <div class="btn-grp vertical">
                            <button>Activate</button>
                            <button>Deactivate (hide)</button>
                            <button>Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import unitsMaster from '../../composables/units';
import { onBeforeMount } from 'vue';
import userMaster from '../../composables/users';
import favouriteMaster from '../../composables/favourites';
import { api as viewerApi } from "v-viewer"
import CardProperty from '../Cards/Property2.vue';

const { 
    unit, 
    route, 
    getUnit, 
} = unitsMaster()

const { getUserData, user } = userMaster()
const { saveFavourite } = favouriteMaster()

const imagesList = () => {
    let images = [];
    for (let i=0; i<unit.value.files.length; i++) {
        images.push(`/images/listings/${unit.value.property.slug}/${unit.value.slug}/${unit.value.files[i].name}`)
    }
    return images
}

function openImageBrowser() {
    viewerApi({
        images: imagesList(),
        options: {
            inline: false, 
            button: true, 
            navbar: false, 
            title: false, 
            toolbar: true, 
            tooltip: false, 
            movable: false, 
            zoomable: true, 
            rotatable: true, 
            scalable: true, 
            transition: true, 
            fullscreen: true, 
            keyboard: true
        }
    })
}

onBeforeMount(() => {
    getUnit(`/api/listings/${route.params.slug}/units/${route.params.unit_slug}`)
    getUserData()
})

function click(element) {
    element.openModal();
}

</script>

<style scoped>
.info-actions .active {
    color: var(--color-primary)
}
</style>