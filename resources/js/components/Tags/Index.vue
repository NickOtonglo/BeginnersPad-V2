<template>
    <div class="container">
        <form @submit.prevent="storeTags(tags)" ref="form">
            <!-- <div class="form-group">
                <VueMultiselect
                    v-model="tags"
                    :options="tagsList"
                    :multiple="true"
                    :close-on-select="true"
                    placeholder="Select tag"
                    label="name"
                    track-by="name"
                />
            </div> -->
            <div class="form-group">
                <label for="name">New tag(s)</label>
                <input v-model="tags.name" id="name" type="text" name="name" placeholder="Tag name(s) (use 'comma' separator for multiple tags)">
                <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                    <p>{{ message }}</p>
                </div>
            </div>
            <button :disabled="isLoading" type="submit" class="btn-primary">
                <div v-show="isLoading" class="lds-dual-ring"></div>
                <span v-if="isLoading">Processing...</span>
                <span v-else>Save tag(s)</span>
            </button>
        </form>
    </div>
    <br>
    <section id="sectionTable">
        <div class="container">
            <table>
                <tr class="single-column">
                    <th>List of tags</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr class="single-column" v-for="tag in tagsList">
                    <td>{{ tag.name }}</td>
                    <td><a href="#" @click="click(tag.name)">Edit</a></td>
                    <td><a id="linkDelete" href="#" @click.prevent="deleteTag(tag.name)">Delete</a></td>
                </tr>
            </table>
            <template v-if="!tagsList.length">
                <p style="text-align: center;">-no tags-</p>
            </template>
        </div>
    </section>

    <UpdateForm ref="childComponentRef"/>
</template>

<script setup>
import { onMounted, ref, onBeforeUnmount, onBeforeMount } from 'vue';
import UpdateForm from '../Modals/EditTag.vue'
import tagsMaster from '../../composables/tags'
import operateModal from '../../composables/modal'

const { getTagsList, storeTags, deleteTag, tags, tagsList, validationErrors, isLoading } = tagsMaster()
const childComponentRef = ref(null);

function click(item) {
    localStorage.setItem('tagName', item)
    childComponentRef.value.openModal();
}

onBeforeMount(() => {
    localStorage.removeItem('tagName')
})

onMounted(() => {
    getTagsList()
    operateModal(document.querySelector('#modal'))
})

onBeforeUnmount(() => {
    localStorage.removeItem('tagName')
})

</script>

<style scoped>
#linkDelete {
    color: var(--color-danger);
}
</style>
