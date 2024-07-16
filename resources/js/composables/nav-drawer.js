import checkAuth from '../composables/checkAuth';

export default function navDrawerMaster() {
    const userAuth = checkAuth()
    let body = document.body;

    const openDrawer = () => {
        if (userAuth.isAuthenticated.value) {
            navDrawer.classList.remove('closed');
            body.classList.add('unfocused');
            pageFiller.classList.add('filler');
        }
    }

    const closeDrawer = () => {
        if (userAuth.isAuthenticated.value) {
            navDrawer.classList.add('closed');
            body.classList.remove('unfocused');
            pageFiller.classList.remove('filler');
        }
    }

    return {
        openDrawer, 
        closeDrawer
    }
}