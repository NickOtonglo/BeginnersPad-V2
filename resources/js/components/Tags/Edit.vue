<template>
    <form @submit.prevent="updateTag(tag)" ref="form">
        <div class="form-control">
            <input v-model="tag.name" type="text" name="name" placeholder="Tag name">
            <div v-for="message in validationErrors?.name" class="txt-alert txt-danger">
                <p>{{ message }}</p>
            </div>
        </div>
        <button :disabled="isLoading" type="submit" class="btn-primary btn-medium">
            <div v-show="isLoading" class="lds-dual-ring"></div>
            <span v-if="isLoading">Processing...</span>
            <span v-else>Update tag</span>
        </button>
    </form>
</template>

<script setup>
import tagsMaster from '../../composables/tags';

const {tag, validationErrors, isLoading } = tagsMaster()
</script>