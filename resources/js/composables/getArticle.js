import axios from "axios";
import { ref, inject, computed } from "vue";
import { useRoute } from "vue-router";

export default function getArticle() {
    const route = useRoute()
    const isLoading = ref(false)
    const article = ref({
        title: '',
        slug: route.params.slug,
        thumbnail: '',
        content: '',
        timestamp: '',
        author: {},
    })
    const tags = {}
    const swal = inject('$swal')

    if (isLoading.value) return
    isLoading.value = true

    const getArticleData = (rt, slug) => {
        axios.get(rt+'/'+slug)
            .then(response => article.value = response.data.data)
            .catch(error => console.log(error))
            // .finally(isLoading.value = false)
    }

    const getArticleAuthor = (rt, slug) => {
        axios.get(rt+'/'+slug+'/author')
            .then(response => article.value.author = response.data.author)
            .catch(error => {
                console.log(error)
                article.value.author = 'Loading...'
            })
    }

    const getArticleTags = (rt, slug) => {
        axios.get(rt+'/'+slug+'/tags')
            .then(response => tags.value = response.data.data)
            .catch(error => console.log(error))
    }

    const deleteArticle = (rt, slug) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This post will be erased from the system.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
                axios.delete(rt+'/'+slug)
                    .then(response => {
                        router.push({ name: 'articles.index' })
                        swal({
                            icon: 'success',
                            title: 'Article deleted.'
                        })
                    })
                    .catch(error => {
                        swal({
                            icon: 'error',
                            title: 'Something went wrong, please try again.'
                        })
                    })
                    .finally(() => isLoading.value = false)
            } else {
                isLoading.value = false
            }
        })
    }

    const isAuthor = () => {
        if (isLoggedIn.value && article.value.author.id == localStorage.getItem.getItem('user')) {
            return true
        }
        return false
    }

    const isLoggedIn = computed(() => {
        return !!window.localStorage.getItem('loggedIn')
    })

    return {
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
    }
}
