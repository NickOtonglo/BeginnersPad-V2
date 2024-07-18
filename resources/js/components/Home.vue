<template>
    <!-- Showcase -->
    <section id="showcase">
        <div class="showcase-overlay">
            <div class="container">
                <div>
                    <h1>Welcome to Beginners Pad</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cum ex corporis aut porro vitae nam iusto neque est?
                        Dolores distinctio nam cupiditate veniam enim! Magnam quae delectus expedita tempore eaque!
                    </p>
                    <a href="#" class="btn btn-link">Learn more</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Listings -->
    <section id="section-listings">
        <div class="container">
            <h3 class="section-title">Newest listings</h3>
            <div id="isLoading">
                <div v-show="isLoading" class="lds-dual-ring"></div>
                <span v-if="isLoading">Loading...</span>
            </div>
            <div class="cards">
                <template v-for="property in properties">
                    <CardProperty :property="property" />
                </template>
            </div>
            <template v-if="!properties.length">
                <p style="text-align: center;">-no listings-</p>
            </template>
            <div v-if="properties.length" class="section-more">
                <router-link :to="{ name: 'properties.index' }">View more listings <i class="fas fa-chevron-right"></i></router-link>
            </div>
        </div>
    </section>

    <!-- Marketing -->
    <section id="section-marketing">
        <div class="container">
            <h3 class="section-title">Why choose beginners pad?</h3>
            <div class="marketing-item">
                <h4>Find your next home</h4>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit odit cumque reiciendis itaque eaque repudiandae.</p>
                <a href="#">Learn more <i class="fas fa-chevron-right"></i></a>
            </div>
            <div class="marketing-item">
                <h4>Subscribe to premium waiting list to get the newest listing updates before they go public</h4>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit odit cumque reiciendis itaque eaque repudiandae.</p>
                <a href="#">Learn more <i class="fas fa-chevron-right"></i></a>
            </div>
            <div class="marketing-item">
                <h4>List your property with us</h4>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit odit cumque reiciendis itaque eaque repudiandae.</p>
                <a href="#">Learn more <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
    </section>

    <!-- Links -->
    <section id="section-links">
        <!-- Social media links -->
        <div class="social">
            <a href="#"><i class="fab fa-facebook-f"></i> Facebook</a>
            <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
            <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
        </div>
        <!-- About section -->
        <div class="about">
            <a href="#">Who we are</a>
            <a href="#">Contact us</a>
        </div>
        <!-- Other links -->
        <div class="others">
            <a href="#">Privacy policy</a>
            <a href="#">Terms of service</a>
            <router-link :to="{ name: 'articles.index' }">Articles</router-link>
        </div>
    </section>
</template>

<script setup>
import { ref, onBeforeMount, onBeforeUpdate } from 'vue'
import pagination from '../composables/pagination'
import CardProperty from './Cards/Property1.vue';

const { 
    current_page,
    properties,
    getPaginationDataWithRequest
} = pagination()
const request = ref(`/api/listings/home`)

onBeforeMount(() => {
    getPaginationDataWithRequest(current_page.value, 'properties', request.value)
})
onBeforeUpdate(() => {
    document.title = localStorage.getItem('title')
})

</script>