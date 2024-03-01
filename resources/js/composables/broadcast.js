import axios from "axios";
import { inject } from "vue";
import { useRouter } from "vue-router";

export default function broadcastMaster() {
    const swal = inject('$swal')
    const router = useRouter()

    const broadcastChats = (request) => {
        window.Echo.private(`chats.${request}`)
            .listen('MessageSent', (e) => {
                swal.fire({
                    icon: 'info',
                    title: 'New message',
                    text: 'You have a new message.',
                    showCancelButton: true,
                    confirmButtonColor: 'rgb(13, 180, 138)',
                    // cancelButtonColor: 'rgb(238, 14, 14)',
                    confirmButtonText: 'Messages',
                    cancelButtonText: 'Close',
                }).then((result) => {
                    if (result.isConfirmed) {
                        router.push({ name: 'chats.index' })
                    }
                })
            });
    }

    const broadcastNotifications = (request) => {
        window.Echo.private(`notifications.${request}`)
            .listen('NotificationSent', (e) => {
                axios.get('/api/notifications')
                    .then(response => {
                        // console.log(response.data.data[0])
                        swal.fire({
                            icon: 'info',
                            title: response.data.data[0].title,
                            text: response.data.data[0].body,
                            showCancelButton: true,
                            confirmButtonColor: 'rgb(13, 180, 138)',
                            // cancelButtonColor: 'rgb(238, 14, 14)',
                            confirmButtonText: 'Open',
                            cancelButtonText: 'Close',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (response.data.data[0].model == 'Chat') {
                                    router.push({ name: 'chat.view', params: { id: response.data.data[0].model_id } })
                                }
                            }
                        })
                    })
                    .catch(error => console.log(error))
            })
    }

    return {
        broadcastChats, 
        broadcastNotifications, 
    }
}