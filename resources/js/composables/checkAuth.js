import { ref } from "vue"

export default function checkAuth() {
    const isAuthenticated = ref(localStorage.getItem('authenticated'))

    return { isAuthenticated }
}