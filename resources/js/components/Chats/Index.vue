<template>
    <section>
        <h3 class="section-title">Chats</h3>
        <div class="container">
            <div>
                <div v-for="chat in chats" class="chats-list">
                    <router-link :to="{ name: 'chat.view', params: { id: chat.id } }" class="chat-item">
                        <template v-if="chat.participants.length > 2">
                            <div class="img">
                                <img src="/images/static/avatar.png" alt="">
                            </div>
                        </template>
                        <template v-else>
                            <div v-if="chat.participants[0].avatar" class="img">
                                <img :src="`/images/user/avatar/${chat.participants[0].participant}/${chat.participants[0].avatar}`" alt="">
                            </div>
                            <div v-else class="img">
                                <img src="/images/static/avatar.png" alt="">
                            </div>
                        </template> 
                        <div class="text">
                            <p class="time">{{chat.messages[chat.messages.length - 1].time_ago}}</p>
                            <template v-if="chat.participants.length > 2">
                                <template v-for="(item, index) in chat.participants">
                                    <span v-if="index === chat.participants.length - 1" class="user">@{{item.participant}} </span>
                                    <span v-else class="user">@{{item.participant}}, </span>
                                </template>
                            </template>
                            <template v-else>
                                <h3>@{{chat.participants[0].participant}}</h3>
                            </template>
                            <p class="txt-triple-line">{{chat.messages[chat.messages.length - 1].body}}</p>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onBeforeMount } from 'vue';
import chatsMaster from '../../composables/chats';

const {
    isLoading, 
    chats, 
    getChats, 
} = chatsMaster()

let request = `/api/chats`

onBeforeMount(() => {
    getChats(request)
})
</script>