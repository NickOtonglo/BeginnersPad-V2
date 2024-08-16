<template>
    <!-- Showcase -->
    <section id="showcase">
        <div class="showcase-overlay">
            <div class="container">
                <div>
                    <h1>Welcome to Beginners Pad</h1>
                    <p>Finding your next home doesn’t need to be hard, or expensive! If you are just starting out in
                        life, or if you’re in need of a cost-friendly home, you can count on us!</p>
                    <router-link :to="{ name: 'app.about' }" class="btn btn-link">Learn more</router-link>
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
                <router-link :to="{ name: 'properties.index' }">View more listings <i
                        class="fas fa-chevron-right"></i></router-link>
            </div>
        </div>
    </section>

    <!-- Marketing -->
    <section id="section-marketing">
        <div class="container">
            <h3 class="section-title">Why choose beginners pad?</h3>
            <div class="marketing-item">
                <h4>It's a great place to begin</h4>
                <p>
                    Are you moving and on a tight budget? Beginners Pad is for tight budgets! We allow only affordable
                    listings on our platform, so you don't have to worry about breaking the bank while looking for a
                    home with us.
                </p>
                <router-link :to="{ name: 'app.about' }">Learn more <i class="fas fa-chevron-right"></i></router-link>
            </div>
            <div class="marketing-item">
                <h4>What you see is what you get</h4>
                <p>
                    We have ensured that what has been listed has been personally approved by us in a process that
                    strictly enforces our terms of service for your benefit. No fishy or questionable listings here!
                </p>
                <router-link :to="{ name: 'app.about' }">Learn more <i class="fas fa-chevron-right"></i></router-link>
            </div>
            <div class="marketing-item">
                <h4>We have already done all the heavy lifting for you</h4>
                <p>
                    We have visited and inspected all the properties listed here and we have ensured that they exist and
                    are just as they appear in the pictures. You no longer have to transit to view a couple of homes in
                    person to confirm if they are being represented properly. You can now save that money! No
                    middle-men, no scammers, no stress! You will interact directly with the landlord or their selected
                    representatives.
                </p>
                <router-link :to="{ name: 'app.about' }">Learn more <i class="fas fa-chevron-right"></i></router-link>
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
            <router-link :to="{ name: 'app.about', hash: '#who-we-are' }">Who we are</router-link>
            <router-link :to="{ name: 'help.index', hash: '#contact-form' }">Contact us</router-link>
        </div>
        <!-- Other links -->
        <div class="others">
            <router-link :to="{ name: 'app.privacy' }">Privacy policy</router-link>
            <router-link :to="{ name: 'app.terms' }">Terms of service</router-link>
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