<template>
    <!-- <section id="searchBar" ref="header" :class="{'sticky' :initialiseScroll}"> -->
    <section id="searchBar" ref="header">
        <div class="container">
            <form @submit.prevent="getPaginationData(1)" class="search-bar">
                <div class="search-bar-grp">
                    <input v-model="search_global" type="text" class="search-input" placeholder="search...">
                    <div ref="btnClearSearch" v-show="search_global !== ''" @click="search_global = ''" class="search-button">
                        <i class="fas fa-xmark"></i>
                    </div>
                    <div @click="getPaginationData(1)" class="search-button">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from 'vue';
import pagination from '../../composables/pagination';

const header = ref(null)
const btnClearSearch = ref(null)

const { 
    search_global,
    current_page,
    articles,
    getPaginationData
} = pagination()

// function initialiseScroll() {
//     let sticky = header.offsetTop
//     if (window.pageYOffset > sticky) {
//         // header.classList.add("sticky");
//         return true
//     } else {
//         // header.classList.remove("sticky");
//         return false
//     }
// }

function initialiseScroll() {
    // let sticky = header.value.offsetTop
    if (window.pageYOffset > header.value.offsetTop) {
        header.value.classList.add("sticky");
        // return true
    } else if (window.pageYOffset < header.value.offsetTop) {
        header.value.classList.remove("sticky");
        // return false
    }
}

onMounted(() => {
    // window.addEventListener("scroll", initialiseScroll)
})

onBeforeUnmount(() => {
    // window.removeEventListener("scroll", initialiseScroll)
    getPaginationData(current_page.value)
})

watch(search_global, (current, previous) => {
    // To show instant results during search, uncomment the line below
    // getPaginationData(1)
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