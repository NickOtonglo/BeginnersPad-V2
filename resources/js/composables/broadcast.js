import axios from "axios";
import { inject } from "vue";
import { useRouter } from "vue-router";

export default function broadcastMaster() {
    const swal = inject('$swal')
    const router = useRouter()

    // in case listener isn't working, run in console: "./vendor/bin/sail artisan queue:work"

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
                        let data = response.data.data[0]
                        // console.log(response.data.data.length)
                        // console.log(response.data.data[response.data.data.length - 1])
                        if (!data.dest) {
                            swal.fire({
                                icon: 'info',
                                title: data.title,
                                text: data.body,
                                showCancelButton: true,
                                confirmButtonColor: 'rgb(13, 180, 138)',
                                // cancelButtonColor: 'rgb(238, 14, 14)',
                                confirmButtonText: 'View all notifications',
                                cancelButtonText: 'Close',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    router.push({ name: 'user.notifications' })
                                }
                            })
                        } else { 
                            swal.fire({
                                icon: 'info',
                                title: data.title,
                                text: data.body,
                                showCancelButton: true,
                                confirmButtonColor: 'rgb(13, 180, 138)',
                                // cancelButtonColor: 'rgb(238, 14, 14)',
                                confirmButtonText: 'Open',
                                cancelButtonText: 'Close',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if (data.dest == 'chat.view') {
                                        router.push({ name: 'chat.view', params: { id: data.dest_link } })
                                    }
                                    if (data.dest == 'property.view') {
                                        router.push({ name: 'property.view', params: { slug: data.dest_link } })
                                    }
                                    if (data.dest == 'ticket.view') {
                                        router.push({ name: 'ticket.view', params: { id: data.dest_link } })
                                    }
                                    if (data.dest == 'transactions.mine') {
                                        router.push({ name: 'transactions.mine', params: { id: data.dest_link } })
                                    }
                                }
                            })
                        }
                    })
                    .catch(error => console.log(error))
            })
    }

    return {
        broadcastChats, 
        broadcastNotifications, 
    }
}