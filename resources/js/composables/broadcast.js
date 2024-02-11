export default function broadcastMaster() {
    const chatsBroadcast = (request) => {
        window.Echo.private(`chats.${request}`)
            .listen('MessageSent', (e) => {
                console.log('xxx');
            });
    }

    return {
        chatsBroadcast, 
    };
}