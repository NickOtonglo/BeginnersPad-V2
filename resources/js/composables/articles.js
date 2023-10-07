import axios from "axios";
import { ref, inject } from "vue";
import { useRoute, useRouter } from "vue-router";

export default function articlesMaster() {
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref('')
    const swal = inject('$swal')
    const articles = ref({})
    const article = ref({
        title: '',
        slug: route.params.slug,
        thumbnail: '',
        content: '',
        timestamp: '',
        author: {},
    })

    const getArticles = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {
                articles.value = response.data.data
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getArticle = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => article.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    // const getArticleAuthor = (rt, slug) => {
    //     axios.get(rt+'/'+slug+'/author')
    //         .then(response => article.value.author = response.data.author)
    //         .catch(error => {
    //             console.log(error)
    //             article.value.author = 'Loading...'
    //         })
    // }

    // const getArticleTags = (rt, slug) => {
    //     axios.get(rt+'/'+slug+'/tags')
    //         .then(response => tags.value = response.data.data)
    //         .catch(error => console.log(error))
    // }

    const createArticle = (request, data) => {
        if (isLoading.value) { return }
        isLoading.value = true
        validationErrors.value = ''
        
        data[0].content = data[2]
        data[0].preview = data[3]
        let serialisedPost = new FormData()
    
        let tagsFinal = []
        for (let item in data[1]) {
            if (data[1].hasOwnProperty(item)) {
                tagsFinal.push(data[1][item].name)
            }
        }
        serialisedPost.append('tags', tagsFinal)
    
        for (let item in data[0]) {
            if (data[0].hasOwnProperty(item)) {
                serialisedPost.append(item, data[0][item])
            }
        }

        axios.post(request, serialisedPost)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Article published.',
                    didClose: () => {
                        router.go(-1)
                    }
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                } else {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occured. Please try again.',
                    })
                }
            })
            .finally(() => isLoading.value = false)
    }

    function updateArticle(request, data) {
        if (isLoading.value) { return }
        isLoading.value = true
        validationErrors.value = ''
        
        data[0].content = data[2]
        data[0].preview = data[3]
        let serialisedPost = new FormData()
    
        let tagsFinal = []
        for (let item in data[1]) {
            if (data[1].hasOwnProperty(item)) {
                tagsFinal.push(data[1][item].name)
            }
        }
        serialisedPost.append('tags', tagsFinal)
    
        for (let item in data[0]) {
            if (data[0].hasOwnProperty(item)) {
                serialisedPost.append(item, data[0][item])
            }
        }
        
        serialisedPost.append('_method', 'PATCH')
    
        /**
         * Why axios.put() doesn't work (route originally '/api/articles/'+ article.slug):
         * https://stackoverflow.com/questions/65008650/how-to-use-put-method-in-laravel-api-with-file-upload/65009135#65009135
        */
        axios.post(request, serialisedPost)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Article updated.',
                    didClose: () => {
                        router.go(-1)
                    }
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                } else {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occured. Please try again.',
                    })
                }
            })
            .finally(() => isLoading.value = false)
    }

    const deleteArticle = (request) => {
        if (isLoading.value) { return }

        swal.fire({
            title: 'Are you sure?',
            text: "This article will be deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
                axios.delete(request)
                    .then(response => {
                        swal({
                            icon: 'success',
                            title: 'Article deleted.',
                            didClose: () => {
                                router.go(-1)
                            }
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


    return {
        validationErrors,
        deleteArticle,
        updateArticle,
        createArticle,
        getArticles,
        getArticle,
        articles,
        article,
        router,
        route,
    }
}
