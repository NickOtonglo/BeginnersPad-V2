export default function navBarMaster() {
    let body = document.body;

    const toggleMenu = () => {
        if(navMenu.classList.contains('open')){
            navMenu.classList.remove('open');
        } else if(navMenu.classList.contains('authed')){
            navDrawer.classList.remove('closed');
            body.classList.add('unfocused');
            pageFiller.classList.add('filler');
        } else {
            navMenu.classList.add('open');
        }
    }

    return {
        toggleMenu,
    }
}