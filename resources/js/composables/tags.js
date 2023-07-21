import { ref, inject } from "vue";
import { useRoute, useRouter } from "vue-router"

export default function tagsMaster() {
    const tags = ref ({})
    const tagsList = ref([])
    const route = useRoute()
    const router = useRouter()
    const isLoading = ref(false)
    const validationErrors = ref({})
    const swal = inject('$swal')
    const tag = ref({})
    
    const getTagsList = () => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get('/api/tags')
            .then(response => tagsList.value = response.data.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const storeTags = (tags) => {
        if (isLoading.value) { return }
        isLoading.value = true
        validationErrors.value = ''

        axios.post('api/tags', tags)
            .then(response => {
                // swal({
                //     icon: 'success',
                //     title: 'Tag added.'
                // })
                router.go(0)
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const getTag = (name) => {
        axios.get('/api/tags/' + name)
            .then(response => tag.value = response.data.data)
            .catch(error => console.log(error))
    }

    const updateTag = (tag) => {
        if (isLoading.value) { return }
        isLoading.value = true
        validationErrors.value = ''

        axios.patch('/api/tags/' + tag.name, tag)
            .then(response => {
                router.push({ name: 'tags.index' })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const deleteTag = (tag) => {
        if (isLoading.value) { return }
        // isLoading.value = true

        swal.fire({
            title: 'Are you sure?',
            text: "This tag will be removed. However, all articles and listings linked to it will not be affected beyond its removal.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(207, 95, 50)',
            cancelButtonColor: 'rgb(238, 14, 14)',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                isLoading.value = true
                axios.delete('/api/tags/' + tag)
                    .then(response => {
                        router.push({ name: 'tags.index' })
                        // swal({
                        //     icon: 'success',
                        //     title: 'Tag deleted.'
                        // })
                        router.go(0)

                    })
                    .catch(error => {
                        console.log(error)
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
        getTagsList,
        updateTag,
        deleteTag,
        storeTags,
        tagsList,
        getTag,
        route,
        tags,
        tag,
    }
}