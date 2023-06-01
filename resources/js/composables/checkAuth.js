import { ref } from "vue"

export default function checkAuth() {
    const isAuthenticated = ref(localStorage.getItem('authenticated'))
    const token = ref(localStorage.getItem('authToken'))

    return { isAuthenticated, token }
}