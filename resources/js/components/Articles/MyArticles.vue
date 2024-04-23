<template>
    <h3 class="section-title">Articles</h3>
    <!-- Search bar -->
    <SearchBar 
        :categoriesList="tagsList"
        :categorySelected="selected"
        @search-initiated="filterArticles" 
        @search-cancelled="filterArticles"
        @category-selected="filterArticlesByTag" />
    <section class="section-read links">
        <div class="container">
            <div class="container-btn-dropdown multi">
                <div></div>
                <select v-model="filter_sort" @change="getPaginationDataWithRequest(1, 'articles', request), filterArticles('')" class="btn-dropdown">
                    <option value="DESC">Sort by newest</option>
                    <option value="ASC">Sort by oldest</option>
                </select>
            </div>
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
            <template v-if="!articles?.length">
                <p style="text-align: center;">-no articles-</p>
            </template>
            <Pagination :totalPages="total_pages"
                        :perPage="per_page"
                        :currentPage="current_page"
                        @pagechanged="onPageChange"
            />
        </div>
        <div class="fab-container">
            <router-link :to="{ name: 'article.create' }" class="fab btn btn-primary"><i class="fa-solid fa-plus"></i> New article</router-link>
        </div>
    </section>
</template>

<script setup>
import SearchBar from '../Search/SearchBar.vue';
import { onBeforeUnmount, onMounted, ref, watch, onBeforeMount } from 'vue';
import pagination from '../../composables/pagination';
import tagsMaster from '../../composables/tags'

const header = ref(null)
const btnClearSearch = ref(null)

const { 
    search_global,
    filter_sort,
    total_pages,
    per_page,
    current_page,
    articles,
    isLoading,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()

const { tagsList, getTagsList, getArticles, route } = tagsMaster()
const selected = ref(``)
const request = ref(`/api/articles/my-articles/manage`)

function filterArticles(input) {
    search_global.value = input
    if (!input) {
        search_global.value = ''
        selected.value = ''
    }
    getPaginationDataWithRequest(1, 'articles', request.value)
}

function filterArticlesByTag(tag) {
    getPaginationDataWithRequest(1, 'articles', `/api/tags/${tag}/articles`)
    selected.value = tag
}

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
    if (route.params.name) {
        selected.value = route.params.name
        filterArticlesByTag(selected.value)
    } else {
        getPaginationDataWithRequest(current_page.value, 'articles', request.value)
    }
    getTagsList(`/api/tags`)
})

onMounted(() => {
    // window.addEventListener("scroll", initialiseScroll)
})

onBeforeUnmount(() => {
    // window.removeEventListener("scroll", initialiseScroll)
})

watch(search_global, (current, previous) => {
    // To show instant results during search, uncomment the line below
    // getPaginationData(1, 'articles')
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