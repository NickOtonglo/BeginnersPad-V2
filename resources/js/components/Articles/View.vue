<template>
    <section>
        <div class="container">
            <h1><u>{{ article.title }}</u></h1>
            <br>
            <template v-if="article.thumbnail">
                <img :src="'/images/articles/' + article.slug + '/' + article.thumbnail" :alt="article.thumbnail">
            </template>
            <template v-else>
                <img src="/images/static/thumb_default.jpg" alt="">
            </template>
            <br>
            <div class="info-name">
                <div class="info-actions">
                    <div><i class="fas fa-share-alt" id="modalTrigger"></i></div>
                    <div @click="saveFavourite(`/api/favourites`, article, 'Article')"><i class="fas fa-heart" :class="{ active: article.favourite }"></i></div>
                </div>
            </div>
            <h3 v-if="article.author">by {{ article.author }}</h3>
            <p>Published on: {{ article.timestamp }}</p>
            <template v-if="user.username === article.author">
                <router-link class="btn btn-primary"
                    :to="{ name: 'article.edit', params: { slug: article.slug } }">Update</router-link>
                <button @click.prevent="deleteArticle(request)" :disabled="isLoading" type="submit"
                    class="btn-danger">
                    <div v-show="isLoading" class="lds-dual-ring"></div>
                    <span v-if="isLoading">Processing...</span>
                    <span v-else>Delete article</span>
                </button>
                <br><br>
            </template>
        </div>
        <div class="categories-grp" v-if="tags.length">
            <div class="container">
                <template v-for="tag in tags">
                    <div class="category">
                        <router-link :to="{ name: 'tag.articles', params: { name: tag.name } }" class="btn">
                            {{ tag.name }}
                        </router-link>
                        <!-- <a class="btn">
                            {{ tag.name }}
                        </a> -->
                    </div>
                </template>
            </div>
        </div>
        <div class="container">
            <br>
            <div id="content" v-html="article.content"></div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount, onBeforeUpdate, ref } from 'vue';
import articlesMaster from '../../composables/articles';
import tagsMaster from '../../composables/tags'
import favouriteMaster from '../../composables/favourites';
import userMaster from '../../composables/users';

const { deleteArticle, getArticle, article, route } = articlesMaster()
const { tags, getArticleTags } = tagsMaster()
const { saveFavourite } = favouriteMaster()
const { getUserData, user } = userMaster()

let request = `/api/articles/${route.params.slug}`

// function initialiseFunctions() {
//     return new Promise((resolve, reject) => {
//         getArticleData(rt, route.params.slug)
//         getArticleAuthor(rt, route.params.slug)
//         getArticleTags(rt, route.params.slug)

//         const error = false

//         if (!error) {
//             resolve()
//         } else {
//             reject('Error: Something went wrong.')
//         }
//     })
// }

onBeforeMount(() => {
    // initialiseFunctions().then(isLoading.value = false)
    getArticle(request)
    getArticleTags(`${request}/tags`)
    getUserData()
})
onBeforeUpdate(() => {
    document.title = article.value.title+' | '+localStorage.getItem('title')
})
</script>

<style scoped>
img {
    width: 100%;
    height: auto;
    max-width: 1920px;
}
.info-actions {
    justify-content: flex-start;
}
.info-actions i {
    padding: 0;
    margin: 0;
}
.info-actions i:first-child {
    margin-right: 10px;
}
.info-actions i:last-child {
    margin-left: 10px;
}
.info-actions .active {
    color: var(--color-primary)
}
</style>
