<template>
    <h3 class="section-title">Articles</h3>
    <section class="section-read links">
        <div class="container">
            <div id="isLoading">
                <div v-show="isLoading" class="lds-dual-ring"></div>
                <span v-if="isLoading">Loading...</span>
            </div>
            <div class="list">
                <div class="item" v-for="article in articles">
                    <h3 class="title-main">{{ article.title }}</h3>
                    <p class="text-main">{{ article.preview }}</p>
                    <router-link :to="{ name: 'article.view', params: { slug: article.slug } }">Read full <i class="fas fa-chevron-right"></i></router-link>
                </div>
            </div>
            <template v-if="!articles.length">
                <p style="text-align: center;">-no articles-</p>
            </template>
        </div>
        <div class="fab-container">
            <router-link :to="{ name: 'article.create' }" class="fab btn btn-primary"><i class="fa-solid fa-plus"></i></router-link>
        </div>
    </section>
</template>

<script setup>
import SearchBar from '../Search/SearchBar.vue';
import { onBeforeUnmount, onMounted, ref, onBeforeMount } from 'vue';
import articlesMaster from '../../composables/articles'
import { useRoute } from 'vue-router';

const header = ref(null)

const { getArticles, articles } = articlesMaster()
const route = useRoute()
const tag = ref({
    name: route.params.name
})

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

onBeforeMount(() => {
    getArticles(`/api/tags/${tag.value.name}/articles`, '')
})

onMounted(() => {
    // window.addEventListener("scroll", initialiseScroll)
})

onBeforeUnmount(() => {
    // window.removeEventListener("scroll", initialiseScroll)
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