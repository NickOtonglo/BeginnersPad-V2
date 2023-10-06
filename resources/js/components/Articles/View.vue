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
            <h3 v-if="article.author">by {{ article.author.name }}</h3>
            <p>Published on: {{ article.timestamp }}</p>
            <template v-if="isAuthor()">
                <router-link class="btn btn-primary"
                    :to="{ name: 'article.edit', params: { slug: article.slug } }">Update</router-link>
                <button @click.prevent="deleteArticle(rt, article.slug)" :disabled="isLoading" type="submit"
                    class="btn-danger">
                    <div v-show="isLoading" class="lds-dual-ring"></div>
                    <span v-if="isLoading">Processing...</span>
                    <span v-else>Delete article</span>
                </button>
                <br><br>
            </template>
        </div>
        <div class="categories-grp">
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
import getArticle from '../../composables/getArticle';
import { onBeforeMount, ref } from 'vue';
import favouriteMaster from '../../composables/favourites';
import userMaster from '../../composables/users';

const {
    getArticleAuthor,
    getArticleData,
    getArticleTags,
    deleteArticle,
    isLoggedIn,
    isLoading,
    isAuthor,
    article,
    route,
    tags,
} = getArticle()
const { saveFavourite } = favouriteMaster()
const { getUserData, user } = userMaster()

const rt = '/api/articles'

function initialiseFunctions() {
    return new Promise((resolve, reject) => {
        getArticleData(rt, route.params.slug)
        getArticleAuthor(rt, route.params.slug)
        getArticleTags(rt, route.params.slug)

        const error = false

        if (!error) {
            resolve()
        } else {
            reject('Error: Something went wrong.')
        }
    })
}

onBeforeMount(() => {
    initialiseFunctions().then(isLoading.value = false)
    getUserData()
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
</style>
