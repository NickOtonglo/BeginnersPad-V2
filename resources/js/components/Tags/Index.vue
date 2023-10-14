<template>
    <div class="container">
        <form @submit.prevent="storeTags(`/api/tags`, tag)" ref="form">
            <div class="form-group">
                <label for="name">New tag(s)</label>
                <input v-model="tag.name" type="text" name="name" placeholder="Tag name(s) (use 'comma' separator for multiple tags)">
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
                <tr class="single-column" v-for="item in tagsList">
                    <td>{{ item.name }}</td>
                    <td><a href="#" @click="getTag(item.name), click(childComponentRef)">Edit</a></td>
                    <td><a id="linkDelete" href="#" @click.prevent="deleteTag(item.name)">Delete</a></td>
                </tr>
            </table>
            <template v-if="tagsList && !tagsList.length">
                <p style="text-align: center;">-no tags-</p>
            </template>
        </div>
    </section>

    <UpdateForm ref="childComponentRef" :tag="tag"/>
</template>

<script setup>
import { onMounted, ref, onBeforeUnmount, onBeforeMount } from 'vue';
import UpdateForm from '../Modals/EditTag.vue'
import tagsMaster from '../../composables/tags'
import operateModal from '../../composables/modal'

const { getTag, getTagsList, storeTags, deleteTag, tag, tagsList, validationErrors, isLoading } = tagsMaster()
const childComponentRef = ref(null);

onMounted(() => {
    getTagsList(`api/tags`)
})

function click(element) {
    element.openModal();
}

</script>

<style scoped>
#linkDelete {
    color: var(--color-danger);
}
</style>
