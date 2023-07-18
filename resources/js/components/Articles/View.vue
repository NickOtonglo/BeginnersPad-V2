<template>
    <section>
        <div class="container">
            <h1><u>{{ article.title }}</u></h1>
            <br>
            <img src="/images/static/thumb_default.jpg">
            <br>
            <h3>by {{ article.author.name }}</h3>
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
            <template v-for="tag in tags">
                <div class="category">
                    <!-- <router-link :to="{ name: 'tag.articles', params: { name: tag.name } }" class="btn">
                        {{ tag.name }}
                    </router-link> -->
                    <a class="btn">
                        {{ tag.name }}
                    </a>
                </div>
            </template>
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

const rt = '/api/articles'

onBeforeMount(() => {
    // async-await to set isLoading() to false once the 3 methods have completed
    getArticleData(rt, route.params.slug)
    getArticleAuthor(rt, route.params.slug)
    getArticleTags(rt, route.params.slug)
})
</script>

<style scoped>
img {
    width: 100%;
    max-width: 1920px;
}
</style>
