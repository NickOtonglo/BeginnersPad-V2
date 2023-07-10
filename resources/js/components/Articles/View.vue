<template>
    <section>
        <div class="container">
            <h1>{{ article.title }}</h1>
            <img src="/images/static/thumb_default.jpg">
            <br>
            <h3>by Author</h3>
            <p>Published on: 00-00-0000 00:00:00</p>
            <!-- <template v-if="isAuthor()">
                <router-link class="btn btn-primary"
                    :to="{ name: 'article.edit', params: { slug: article.slug } }">Update</router-link>
                <button @click.prevent="deleteArticle(article.slug)" :disabled="isLoading" type="submit"
                    class="btn-danger">
                    <div v-show="isLoading" class="lds-dual-ring"></div>
                    <span v-if="isLoading">Processing...</span>
                    <span v-else>Delete article</span>
                </button>
                <br><br>
            </template> -->
        </div>
        <div class="categories-grp">
            <div class="category">
                <button>Tag 1</button>
            </div>
            <div class="category">
                <button>Tag 2</button>
            </div>
            <div class="category">
                <button>Tag 3</button>
            </div>
        </div>
        <div class="container">
            <br>
            <div id="content" v-html="article.content"></div>
        </div>
    </section>
</template>

<script setup>
import getArticle from '../../composables/viewArticle';
import { onBeforeMount } from 'vue';

const { getArticleData, isLoading, article } = getArticle()

onBeforeMount(() => {
    getArticleData('/api/articles')
})
</script>

<style scoped>
img {
    width: 100%;
    max-width: 1920px;
}
</style>