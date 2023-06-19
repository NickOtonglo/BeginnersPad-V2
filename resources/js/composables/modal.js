export default function operateModal(argModal) {
    let body = document.body, modal, pageFiller, navDrawer

    modal = argModal
    body = document.body
    pageFiller = document.querySelector('#pageFiller')
    navDrawer = document.querySelector('#navDrawer')

    if(modal.classList.contains('open')){
        modal.classList.remove('open');
        body.classList.remove('unfocused');
        pageFiller.classList.remove('filler');
    } else {
        modal.classList.add('open');
        body.classList.add('unfocused');
        pageFiller.classList.add('filler');
    }

    pageFiller.onclick = function(){
        modal.classList.remove('open');
        navDrawer.classList.add('closed')
        body.classList.remove('unfocused');
        pageFiller.classList.remove('filler');
    }
}