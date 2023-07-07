<template>
    <!-- Search bar -->
    <section id="searchBar" ref="header" :class="{'sticky' :initialiseScroll}">
        <div class="container">
            <form class="search-bar">
                <div class="search-bar-grp">
                    <input type="text" class="search-input" placeholder="search...">
                    <div class="search-button">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

const header = ref(null)

function initialiseScroll() {
    let sticky = header.offsetTop
    if (window.pageYOffset > sticky) {
        // header.classList.add("sticky");
        return true
    } else {
        // header.classList.remove("sticky");
        return false
    }
}

onMounted(() => {
    window.addEventListener("scroll", initialiseScroll)
})

onBeforeUnmount(() => {
    window.removeEventListener("scroll", initialiseScroll)
})
</script>

<style scoped>
.sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    background: var(--color-background-main);
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.4);
    z-index: 11;
}
</style>