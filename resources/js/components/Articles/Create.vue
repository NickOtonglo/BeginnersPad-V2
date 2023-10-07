<template>
        <div class="container">
            <form @submit.prevent="createArticle(request, [article, tags, quillEditor.getHTML(), quillEditor.getContents().ops[0].insert])" ref="form">
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
                        @search-change="getTagsList"
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
                    <span v-else>Publish article</span>
                </button>
            </form>
            <div id="content" style="padding: 10px"></div>
        </div>
</template>

<script setup>
import { inject, ref, onMounted } from 'vue'
import VueMultiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import articlesMaster from '../../composables/articles';
import tagsMaster from '../../composables/tags'

const { getArticle, createArticle, route, article, validationErrors } = articlesMaster()
const { tagsList, tags, getTagsList } = tagsMaster()

const quillContent = ref('')
const quillEditor = ref(null)
const thumbnail = ref(null)
const thumbHolder = ref(null)

const request = `/api/articles`
// const tags = ref([])

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
    getArticle(request)
    getTagsList(`/api/tags`)
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