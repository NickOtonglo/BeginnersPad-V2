<template>
    <section class="section-help">
        <div class="container">
            <!-- FAQs and Topics -->
            <div class="help-links">
                <div class="help-faqs">
                    <h3 class="section-title">Frequently asked questions</h3>
                    <template v-if="faqs.length">
                        <template v-if="faqs" v-for="(item, index) in faqs">
                            <div v-if="index <= 2" class="link-item">
                                <h4>{{ item.question }}</h4>
                                <p class="txt-triple-line">{{ item.answer }}</p>
                                <router-link :to="{ name: 'help.faq' }">See more <i class="fas fa-chevron-right"></i></router-link>
                            </div>
                        </template>
                        <div class="section-more">
                            <router-link :to="{ name: 'help.faq' }">View all FAQs <i class="fas fa-chevron-right"></i></router-link>
                        </div>
                    </template>
                    <template v-else>
                        <p style="text-align: center;">-no FAQs-</p>
                    </template>
                </div>
                <div class="help-topics">
                    <h3 class="section-title">Help articles</h3>
                    <template v-if="articles.length">
                        <template v-if="articles" v-for="(item, index) in articles">
                            <div v-if="index <= 2" class="link-item">
                                <h4>{{ item.title }}</h4>
                                <p class="txt-triple-line">{{ item.preview }}</p>
                                <router-link :to="{ name: 'article.view', params: { slug: item.slug } }">See more <i class="fas fa-chevron-right"></i></router-link>
                            </div>
                        </template>
                        <div class="section-more">
                            <router-link :to="{ name: 'tag.articles', params: { 'name': 'help' } }">View all Help articles <i class="fas fa-chevron-right"></i></router-link>
                        </div>
                    </template>
                    <template v-else>
                        <p style="text-align: center;">-no articles-</p>
                    </template>
                </div>
            </div>
            <!-- Form -->
            <div v-if="user.role == 'Lister' || user.role == 'Beginner' || user.role == 'Unset' || !user.username" class="help-form">
                <h3 class="section-title">Contact representative</h3>
                <form @submit.prevent="createTicket(ticketRequest, ticket)">
                    <div v-if="!user.username" class="form-group">
                        <label for="email">Email address*</label>
                        <input v-model="ticket.email" type="email" name="Email address" id="email">
                        <div v-for="message in validationErrors?.email" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="topic">Help category*</label>
                        <select v-model="ticket.topic" name="topic" id="topic">
                            <option value="" disabled>--select category--</option>
                            <template v-for="item in topics">
                                <option :value="item.category">{{ item.category }}</option>
                            </template>
                        </select>
                        <div v-for="message in validationErrors?.topic" class="txt-alert txt-danger">
                            <li>{{ message }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Text (describe problem in detail)*</label>
                        <textarea v-model="ticket.description" type="text" name="description" rows="10"></textarea>
                        <div v-for="message in validationErrors?.description" class="txt-alert txt-danger">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                    <button :disabled="isLoading" class="btn-submit" type="submit">
                        <div v-show="isLoading" class="lds-dual-ring"></div>
                        <span v-if="isLoading">Loading...</span>
                        <span v-else>Submit</span>
                    </button>
                </form>
                <div v-if="user.username" class="section-more">
                    <router-link :to="{ name: 'tickets.list' }">View my tickets <i class="fas fa-chevron-right"></i></router-link>
                </div>
            </div>
            <div v-if="user.role == 'Admin' || user.role == 'Super Admin' || user.role == 'System Admin'" class="help-form">
                <h3 class="section-title">Manage tickets</h3>
                <div class="section-more">
                    <router-link :to="{ name: 'tickets.list' }">Manage tickets <i class="fas fa-chevron-right"></i></router-link>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount } from 'vue'
import faqMaster from '../../composables/faqs'
import articlesMaster from '../../composables/articles'
import userMaster from '../../composables/users'
import ticketsMaster from '../../composables/tickets'

const { faqs, getFaqs } = faqMaster()
const { articles, getArticles } = articlesMaster()
const { user, getUserData } = userMaster()
const { topics, getTopics, ticket, createTicket, validationErrors } = ticketsMaster()

let ticketRequest = `/api/help/tickets`

onBeforeMount(() => {
    getFaqs(`/api/help/faq`)
    getArticles(`/api/tags/help/articles`)
    getTopics(`/api/help/topics`)
    getUserData()
})

</script>