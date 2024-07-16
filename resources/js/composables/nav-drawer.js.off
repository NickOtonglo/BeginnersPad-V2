import checkAuth from '../composables/checkAuth';

export default function operateNavDrawer() {
    const userAuth = checkAuth()

    let body = document.body;

    if (userAuth.isAuthenticated.value) {
        if(document.querySelector('#navDrawerOpen')) {
            let navDrawerOpen = document.querySelector('#navDrawerOpen');
        }
        if(document.querySelector('#navDrawerClose')) {
            let navDrawerClose = document.querySelector('#navDrawerClose');
        }
        if(document.querySelector('#navDrawer')) {
            let navDrawer = document.querySelector('#navDrawer');
        }
        // if (document.querySelector('#pageFiller')){
        //     pageFiller = document.querySelector('#pageFiller');
        // }

        navDrawerOpen.onclick = function(){
            navDrawer.classList.remove('closed');
            body.classList.add('unfocused');
            pageFiller.classList.add('filler');
        };
        
        navDrawerClose.onclick = function(){
            navDrawer.classList.add('closed');
            body.classList.remove('unfocused');
            pageFiller.classList.remove('filler');
        }

        pageFiller.onclick = function(){
            navDrawer.classList.add('closed');
            body.classList.remove('unfocused');
            pageFiller.classList.remove('filler');
        }
    }
}