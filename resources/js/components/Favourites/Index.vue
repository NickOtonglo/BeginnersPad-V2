<template>
    <h3 class="section-title">Favourites</h3>

    <!-- Search bar -->
    <section id="search-bar">
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
        <div class="categories-grp">
            <div class="category">
                <button>Listings</button>
            </div>
            <div class="category">
                <button>Listing units</button>
            </div>
            <div class="category">
                <button>Topics</button>
            </div>
        </div>
    </section>

    <section id="sectionBookmarks">
        <div class="container">
            <div class="favourites-grp">
                <template v-for="fav in favourites">
                    <div v-if="fav.model == 'PropertyUnit'" class="fav unit">
                        <router-link :to="{ name: 'unit.view', params: { slug: fav.data.parent_slug, unit_slug: fav.data.slug } }">
                            <div v-if="fav.data.thumbnail" class="thumb" :style="{ background: `url(/images/listings/${property.slug}/${unit.slug}/${unit.thumbnail})` }" style="background-size: cover;"></div>
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
                            <div class="thumb"></div>
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
    </section>
</template>

<script setup>
import { ref, onBeforeMount } from 'vue';
import favouritesMaster from '../../composables/favourites'
import ComponentRatingStars from '../Misc/RatingStars.vue'

const { favourites, getFavourites, deleteFavourite } = favouritesMaster()
let request = `/api/favourites`

onBeforeMount(() => {
    getFavourites(request)
})
</script>