import axios from "axios";
import { ref } from "vue";

export default function notificationsMaster() {
    const isLoading = ref(false)
    const notifications = ref({})
    const badges = ref({})

    const getNotifications = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => {
                notifications.value = response.data.data
            })
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const getBadges = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.get(request)
            .then(response => badges.value = response.data)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const deleteNotifications = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.delete(request)
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    const setNotificationToRead = (request) => {
        if (isLoading.value) return
        isLoading.value = true

        axios.patch(request)
            .then()
            .catch(error => console.log(error))
            .finally(isLoading.value = false)
    }

    return {
        isLoading, 
        badges, 
        notifications, 
        getNotifications, 
        getBadges, 
        deleteNotifications, 
        setNotificationToRead, 
    }
}