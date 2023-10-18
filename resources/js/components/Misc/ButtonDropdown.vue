<template>
    <div class="btn-dropdown-grp">
        <button @click="open = true" @focusout="open = false" class="btn-dropdown" ref="buttonDropRef">Actions <i class="fas fa-chevron-down"></i></button>
        <div :class="{ 'open': open }" class="btn-dropdown-items" ref="listDropRef">
            <template v-for="(item, index) in actionList">
                <div @click="$emit('actionSelected', item.text)" class="item">{{ item.text }}</div>
            </template>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const buttonDropRef = ref(null)
const listDropRef = ref(null)
const open = ref(false)

const props = defineProps({
    actionList: Array,
})

</script>