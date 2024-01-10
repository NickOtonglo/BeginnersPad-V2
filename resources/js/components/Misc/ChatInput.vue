<template>
    <div class="container-input">
        <div class="input-fixed-bottom">
            <div class="input-grp">
                <form @submit.prevent="$emit('messageEmit', message)">
                    <div v-for="message in validationErrors?.answer" class="txt-alert txt-danger">
                        <li>{{ message }}</li>
                    </div>
                    <div id="w-input-container" @click="setFocus">
                        <div class="w-input-text-group">
                            <div @input="message.body = refInput?.innerHTML" ref="refInput" id="w-input-text" contenteditable></div>
                            <div class="w-placeholder">Message</div>
                        </div>
                    </div>
                    <div :hidden="true" class="input-real-hidden">
                        <input v-model="message.body" type="text" name="message">
                    </div>
                    <button :hidden="true" :disabled="isLoading" ref="refSubmit" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Save</span>
                    </button>
                </form>
                <div @click="refSubmit.click" class="btn-icon-round">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import chatsMaster from '../../composables/chats';

const {
    message, 
    validationErrors, 
} = chatsMaster()

const input = ref('')
const refInput = ref(null)
const refSubmit = ref(null)

// function getInput() {
//     console.log(refInput.value?.innerHTML)
// }
</script>