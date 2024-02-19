import { inject } from "vue";

export default function broadcastMaster() {
    const swal = inject('$swal')

    const chatsBroadcast = (request) => {
        window.Echo.private(`chats.${request}`)
            .listen('MessageSent', (e) => {
                swal({
                    icon: 'info',
                    title: 'New message',
                    text: 'You have a new message.',
                })
            });
    }

    return {
        chatsBroadcast, 
    };
}