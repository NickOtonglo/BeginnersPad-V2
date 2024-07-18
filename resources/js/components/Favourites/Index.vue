<template>
    <h3 class="section-title">Favourites</h3>

    <!-- Search bar -->
    <section id="search-bar">
        <div class="container">
            <form @submit.prevent="getPaginationDataWithRequest(1, 'favourites', request)" class="search-bar">
                <div class="search-bar-grp">
                    <input v-model="search_global" type="text" class="search-input" placeholder="search...">
                    <div ref="btnClearSearch" v-show="search_global !== ''" @click="search_global = '', getPaginationDataWithRequest(1, 'favourites', request)" class="search-button">
                        <i class="fas fa-xmark"></i>
                    </div>
                    <div @click="getPaginationDataWithRequest(1, 'favourites', request)" class="search-button">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
        </div>
        <div class="categories-grp">
            <div class="category" :class="{ 'selected' : selected === 'Property' }">
                <button @click="selected = 'Property', getPaginationDataWithRequest(1, ['favourites', selected], `${request}/category/Property`)" class="active">Listings</button>
            </div>
            <div class="category" :class="{ 'selected' : selected === 'PropertyUnit' }">
                <button @click="selected = 'PropertyUnit', getPaginationDataWithRequest(1, ['favourites', selected], `${request}/category/PropertyUnit`)">Listing units</button>
            </div>
            <div class="category" :class="{ 'selected' : selected === 'Article' }">
                <button @click="selected = 'Article', getPaginationDataWithRequest(1, ['favourites', selected], `${request}/category/Article`)">Articles</button>
            </div>
        </div>
    </section>

    <section id="sectionBookmarks">
        <div class="container">
            <div class="favourites-grp">
                <template v-for="fav in favourites">
                    <div v-if="fav.model == 'PropertyUnit'" class="fav unit">
                        <CardPropertyUnit :unit="fav.data" :closeable="true" @closed="deleteFavourite(`${request}/${fav.id}`)" />
                    </div>
                    <div v-if="fav.model == 'Property'" class="fav listing">
                        <CardProperty :property="fav.data" :closeable="true" @closed="deleteFavourite(`${request}/${fav.id}`)" />
                    </div>
                    <div v-if="fav.model == 'Article'" class="fav topic">
                        <CardArticle :article="fav.data" :closeable="true" @closed="deleteFavourite(`${request}/${fav.id}`)" />
                    </div>
                </template>
            </div>
        </div>
        <template v-if="favourites && !favourites.length">
            <p style="text-align: center;">-no favourites-</p>
        </template>
        <Pagination v-if="favouritesCount > 40" :totalPages="total_pages"
                    :perPage="per_page"
                    :currentPage="current_page"
                    @pagechanged="onPageChange" />
    </section>
</template>

<script setup>
import { ref, onBeforeMount, watch, onBeforeUpdate } from 'vue'
import favouritesMaster from '../../composables/favourites'
import ComponentRatingStars from '../Misc/RatingStars.vue'
import pagination from '../../composables/pagination'
import CardArticle from '../Cards/Article1.vue'
import CardProperty from '../Cards/Property3.vue'
import CardPropertyUnit from '../Cards/PropertyUnit2.vue'

const btnClearSearch = ref(null)
let selected = ''

const { 
    search_global,
    total_pages,
    per_page,
    current_page,
    favourites,
    favouritesCount,
    onPageChange,
    getPaginationDataWithRequest
} = pagination()

const { deleteFavourite, route } = favouritesMaster()
let request = `/api/favourites`

onBeforeMount(() => {
    getPaginationDataWithRequest(current_page.value, 'favourites', request)
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})

watch(search_global, (current, previous) => {
    // To show instant results during search, uncomment the line below
    // getPaginationData(1, 'properties')
})
</script>