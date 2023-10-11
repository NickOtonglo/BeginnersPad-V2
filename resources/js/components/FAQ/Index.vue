<template>
    <div class="fab-container">
        <button @click="click(addFaqRef)" class="fab btn-primary"><i class="fas fa-plus"></i> Add FAQ</button>
    </div>

    <section class="section-read">
        <div class="container">
            <div class="list">
                <h3 class="section-title">Frequently asked questions</h3>
                <template v-for="item in faqs">
                    <div class="item" @click="getFaq(`${request}/${item.id}`), click(editFaqRef)">
                        <h4>{{ item.question }}</h4>
                        <p>{{ item.answer }}</p>
                    </div>
                </template>
            </div>
        </div>
    </section>
    
    <AddFaqModal ref="addFaqRef" />
    <EditFaqModal ref="editFaqRef" :faq="faq" />
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import faqsMaster from '../../composables/faqs';
import AddFaqModal from '../Modals/AddFAQ.vue'
import EditFaqModal from '../Modals/EditFAQ.vue'

const { faqs, getFaqs, faq, getFaq } = faqsMaster()

const addFaqRef = ref(null)
const editFaqRef = ref(null)
let request = `/api/help/faq`

onBeforeMount(() => {
    getFaqs(request)
})

function click(element) {
    element.openModal();
}

</script>

<style scoped>
.list .item:hover {
    cursor: pointer;
    font-weight: bolder;
}
</style>