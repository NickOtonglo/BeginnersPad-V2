<template>
    <div class="modal-floating cookies">
        <div class="content">
            <p>
                By using this application, you agree to our <router-link :to="{ name: 'app.terms' }"><b><u>Terms of
                    Service</u></b></router-link> and our use of cookies to make your experience better.
            </p>
        </div>
        <div class="options">
            <button @click="setConsent(), $emit('consented', consent)"
                class="btn-dark-outline btn-link">Understood</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const consent = ref(false)

function setConsent() {
    consent.value = localStorage.setItem('cookiesConsented', JSON.stringify(true))
}
</script>