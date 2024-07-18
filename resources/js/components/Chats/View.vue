<template>
    <!-- <h3 class="section-title">Chats</h3> -->
    <div class="container container-chats">
        <div v-if="isLoading">
            <div v-show="isLoading" class="lds-dual-ring"></div>
            <span v-if="isLoading">Loading...</span>
        </div>
        <div v-if="chat && user" class="chat-thread">
            <div v-if="chat.participants.length" class="thread-header">
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
                    <template v-if="chat.participants.length > 2">
                        <template v-for="(item, index) in chat.participants">
                            <span v-if="index === chat.participants.length - 1">@{{item.participant}} </span>
                            <span v-else>@{{item.participant}}, </span>
                        </template>
                    </template>
                    <template v-else>
                        <h2>@{{chat.participants[0].participant}}</h2>
                    </template>
                    <p v-if="chat.subject">{{chat.subject}}</p>
                </div>
            </div>
            <div v-if="chat.messages.length" class="thread-messages" ref="refThread">
                <div class="chats">
                    <template v-for="(item, index) in chat.messages">
                        <div v-if="index == chat.messages.length-1" class="chat">
                            <div class="card card-chat" :class="item.participant.participant == user.username ? 'first-person' : 'third-person'" ref="refLast" id="chatLast">
                                <template v-if="item.participant.participant == user.username">
                                    <h4>Me</h4>
                                </template>
                                <template v-else>
                                    <h4>@{{ item.participant.participant }}</h4>
                                </template>
                                <span v-html="item.body"></span>
                                <p class="timestamp">{{ item.time_ago }}</p>
                            </div>
                        </div>
                        <div v-else class="chat">
                            <div class="card card-chat" :class="item.participant.participant == user.username ? 'first-person' : 'third-person'">
                                <template v-if="item.participant.participant == user.username">
                                    <h4>Me</h4>
                                </template>
                                <template v-else>
                                    <h4>@{{ item.participant.participant }}</h4>
                                </template>
                                <span v-html="item.body"></span>
                                <p class="timestamp">{{ item.time_ago }}</p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    <ChatInput @message-emit="getInput" />
</template>

<script setup>
import axios from 'axios';
import { onBeforeMount, ref, watch, reactive, onBeforeUpdate } from 'vue';
import ChatInput from '../Misc/ChatInput.vue';
import chatsMaster from '../../composables/chats'
import userMaster from '../../composables/users'
import broadcastMaster from '../../composables/broadcast';
import notificationsMaster from '../../composables/notifications';

const {
    isLoading, 
    route, 
    getChat, 
    chat, 
    saveMessage, 
} = chatsMaster()
const { user, getUserData } = userMaster()
const { broadcastChats } = broadcastMaster()
const { deleteNotifications } = notificationsMaster()

const refThread = ref(null)
const refLast = ref(null)

function getInput(input) {
    saveMessage(`/api/chats/${route.params.id}`, input)
}

// function getNotifications() {
//     window.Echo.private(`chats.${route.params.id}`)
//         .listen('MessageSent', (e) => {
//             console.log('xxx');
//             getChat(`/api/chats/${route.params.id}`)
//         });
// }

watch(chat, (newChat, oldChat) => {
    setTimeout(() => {
        const element = document.querySelector("#chatLast");
        element.scrollIntoView({behavior: 'smooth'});
    }, 1000)
})

onBeforeMount(() => {
    getChat(`/api/chats/${route.params.id}`)
    getUserData()
    deleteNotifications(`/api/notifications/chat/${route.params.id}`)
    broadcastChats(route.params.id)
    // window.scroll({top: 0, left: 0, behavior: 'smooth' });
    refThread.scrollTop = refThread.scrollHeight;
})
onBeforeUpdate(() => {
    document.title = route.meta.name+' | '+localStorage.getItem('title')
})
</script>