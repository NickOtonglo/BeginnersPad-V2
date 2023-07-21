<template>
    <div class="container">
        <form @submit.prevent="updateArticle(article, tags)" ref="form">
            <div class="form-group">
                <input v-model="article.title" type="text" name="title" placeholder="Title">
                <div v-for="message in validationErrors?.title" class="txt-alert txt-danger">
                    <p>{{ message }}</p>
                </div>
            </div>
            <div class="form-group">
                <input @change="setThumbnail" type="file" name="thumbnail" ref="thumbnail" id="thumbnail">
                <button class="btn-link"
                    @click="triggerFileInput"
                    type="button">
                    Select thumbnail
                </button>
                <br>
                <img src="" alt="" ref="thumbHolder" id="thumbHolder">
                <div v-for="message in validationErrors?.thumbnail" class="txt-alert txt-danger">
                    <p>{{ message }}</p>
                </div>
            </div>
            <QuillEditor
                v-model="quillContent"
                toolbar="full"
                ref="quillEditor"
                style="min-height: 400px;"
            />
            <div v-for="message in validationErrors?.preview" class="txt-alert txt-danger">
                <p>{{ message }}</p>
            </div>
            <div class="form-group">
                <VueMultiselect
                    v-model="tags"
                    :options="tagsList"
                    :multiple="true"
                    :close-on-select="true"
                    placeholder="Select tag(s)"
                    label="name"
                    track-by="name"
                />
            </div>
            <div v-for="message in validationErrors?.tags" class="txt-alert txt-danger">
                <p>{{ message }}</p>
            </div>
            <br>
            <button type="button" class="btn-primary-outline btn-link">Preview</button>
            <button :disabled="isLoading" type="submit" class="btn-primary">
                <div v-show="isLoading" class="lds-dual-ring"></div>
                <span v-if="isLoading">Processing...</span>
                <span v-else>Update article</span>
            </button>
        </form>
        <div id="content" style="padding: 10px"></div>
    </div>
</template>

<script setup>
import { inject, ref, onMounted, onBeforeUpdate } from 'vue'
import { useRouter, useRoute } from 'vue-router';
import VueMultiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import getArticle from '../../composables/getArticle';

const { getArticleData, route, getArticleTags, article } = getArticle()

const quillContent = ref('')
const router = useRouter()
const validationErrors = ref('')
const isLoading = ref(false)
const swal = inject('$swal')
const tags = ref('')
const tagsList = ref([])
const quillEditor = ref(null)
const thumbnail = ref(null)
const thumbHolder = ref(null)

const rt = '/api/articles'

function getTags() {
    axios.get('/api/tags')
        .then(response => tagsList.value = response.data.data)
        .catch(error => console.log(error))
}

function updateArticle(article, tags) {
    if (isLoading.value) { return }
    isLoading.value = true
    validationErrors.value = ''
    article.content = quillEditor.value.getHTML()
    article.preview = quillEditor.value.getContents().ops[0].insert

    let serialisedPost = new FormData()
    for (let item in article) {
        if (article.hasOwnProperty(item)) {
            serialisedPost.append(item, article[item])
        }
    }

    let tagsFinal = []
    for (let item in tags) {
        if (tags.hasOwnProperty(item)) {
            tagsFinal.push(tags[item].name)
        }
    }
    serialisedPost.append('tags', tagsFinal)
    serialisedPost.append('_method', 'PATCH')

    // console.log(serialisedPost.get('slug'))

    /**
     * Why axios.put() doesn't work (route originally '/api/articles/'+ article.slug):
     * https://stackoverflow.com/questions/65008650/how-to-use-put-method-in-laravel-api-with-file-upload/65009135#65009135
    */
    axios.post('/api/articles/' + article.slug + '/edit', serialisedPost)
        .then(response => {
            router.push({ name: 'article.view', params: { slug: article.slug } })
            swal({
                icon: 'success',
                title: 'Article updated.'
            })
        })
        .catch(error => {
            if (error.response?.data) {
                validationErrors.value = error.response.data.errors
            }
        })
        .finally(() => isLoading.value = false)
}

function triggerFileInput() {
    thumbnail.value.click()
}

function setThumbnail(event) {
    // get image data from <input> and set src in <img>
    var selectedFile = event.target.files[0]
    var reader = new FileReader()

    var holder = thumbHolder.value

    reader.onload = function (event) {
        holder.src = event.target.result
    }

    reader.readAsDataURL(selectedFile)
    article.value.thumbnail = selectedFile
}

onMounted(() => {
    // async-await to set isLoading() to false once the 3 methods have completed
    getArticleData(rt, route.params.slug)
    getTags()
    getArticleTags(rt, route.params.slug)
})

onBeforeUpdate(() => {
    quillEditor.value.setHTML(article.value.content) // or article.value.content
    article.thumbnail = ''
})

</script>

<style scoped>
#thumbnail {
    display: none
}

#thumbHolder {
    max-width: 200px;
}
</style>
