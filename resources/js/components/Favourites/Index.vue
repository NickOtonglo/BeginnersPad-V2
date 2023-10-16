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
                        <router-link :to="{ name: 'unit.view', params: { slug: fav.data.parent_slug, unit_slug: fav.data.slug } }">
                            <div v-if="fav.data.thumbnail" class="thumb" :style="{ background: `url(/images/listings/${fav.data.parent_slug}/${fav.data.slug}/${fav.data.thumbnail})` }" style="background-size: cover;"></div>
                            <div v-else class="thumb" style="background-size: cover;"></div>
                            <div class="details">
                                <h3 class="txt-single-line">{{ fav.data.name }}</h3>
                                <div class="specs">
                                    <span class="spec">{{ fav.data.bedrooms }} bed, </span>
                                    <span class="spec">{{ fav.data.bathrooms }} bath, </span>
                                    <span class="spec">{{ fav.data.floor_area }}sq M</span>
                                </div>
                                <div class="deposit">
                                    <span class="label">Initial deposit: </span>
                                    <span v-if="fav.data.init_deposit == 0" class="data">not required</span>
                                    <span v-else class="data">KES {{ fav.data.init_deposit }}</span>
                                </div>
                                <div class="price">
                                    <span class="label">KES </span>
                                    <span class="data">{{ fav.data.price }}</span>
                                </div>
                                <p class="timestamp">Added {{ fav.data.time_ago }}</p>
                            </div>
                        </router-link>
                        <button @click="deleteFavourite(`${request}/${fav.id}`)" class="btn-link btn-close"><i class="fas fa-times"></i></button>
                    </div>
                    <div v-if="fav.model == 'Property'" class="fav listing">
                        <router-link :to="{ name: 'property.view', params: { slug: fav.data.slug } }">
                            <div v-if="fav.data.thumbnail" class="thumb" :style="{ background: `url(/images/listings/${fav.data.slug}/${fav.data.thumbnail})` }" style="background-size: cover;"></div>
                            <div v-else class="thumb" style="background-size: cover;"></div>
                            <div class="details">
                                <h3 class="txt-single-line">{{ fav.data.name }}</h3>
                                <div class="location">
                                    <span class="spec">{{ fav.data.sub_zone.name }}, </span>
                                    <span class="spec">{{ fav.data.sub_zone.zone.name }}, </span>
                                    <span class="spec">{{ fav.data.sub_zone.zone.county.name }}</span>
                                </div>
                                <p class="timestamp">Added {{ fav.data.time_ago }}</p>
                                <div class="info-rating-grp">
                                    <p class="rating">Rating: {{ fav.data.rating }}/5</p>
                                    <ComponentRatingStars :rating="fav.data.rating" />
                                </div>
                            </div>
                        </router-link>
                        <button @click="deleteFavourite(`${request}/${fav.id}`)" class="btn-link btn-close"><i class="fas fa-times"></i></button>
                    </div>
                    <div v-if="fav.model == 'Article'" class="fav topic">
                        <router-link :to="{ name: 'article.view', params: { slug: fav.data.slug } }">
                            <h3 class="title-main txt-single-line">{{ fav.data.title}}</h3>
                            <p class="text-main txt-six-line">{{ fav.data.preview }}</p>
                        </router-link>
                        <button @click="deleteFavourite(`${request}/${fav.id}`)" class="btn-link btn-close"><i class="fas fa-times"></i></button>
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
import { ref, onBeforeMount, watch } from 'vue'
import favouritesMaster from '../../composables/favourites'
import ComponentRatingStars from '../Misc/RatingStars.vue'
import pagination from '../../composables/pagination'

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

const { deleteFavourite } = favouritesMaster()
let request = `/api/favourites`

onBeforeMount(() => {
    getPaginationDataWithRequest(current_page.value, 'favourites', request)
})

watch(search_global, (current, previous) => {
    // To show instant results during search, uncomment the line below
    // getPaginationData(1, 'properties')
})
</script>