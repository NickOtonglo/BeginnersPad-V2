import { ref } from "vue";
import { useRoute } from "vue-router";

export default function getArticle() {
    const isLoading = ref(false)
    const article = ref({
        title: '',
        slug: route.params.slug,
        thumbnail: '',
        content: '',
        timestamp: '',
        author: {},
    })
    const route = useRoute()

    if (isLoading.value) return
    isLoading.value = true

    const getArticleData = (route, slug) => {
        axios.get(route+'/'+slug)
        .then(response => article.value = response.data.data)
        .catch(error => console.log(error))
        .finally(isLoading.value = false)
    }

    return { getArticleData, isLoading, article }
}