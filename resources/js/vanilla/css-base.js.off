// Nav menu toggle
let navToggle = document.getElementById('navToggle');
let navMenu = document.getElementById('navMenu');
let body = document.body;
let btnDropGrp1,btn_dropdown_grp,listDropGrp1,pageFiller,modalTrigger,modal,modalHeaderClose,modalFooterClose;

if (document.getElementById('pageFiller')){
    pageFiller = document.getElementById('pageFiller');
}

if (document.getElementById('modalTrigger')){
    modalTrigger = document.getElementById('modalTrigger');
    modal = document.getElementById('modal');
    modalFooterClose = document.getElementById('modalFooterClose');
    modalHeaderClose = document.getElementById('modalHeaderClose');
    pageFiller = document.getElementById('pageFiller');
    modalTrigger.onclick = function(){
        toggleModal();
    }
    pageFiller.onclick = function(){
        closePageFiller();
    }
    modalHeaderClose.onclick = function(){
        toggleModal();
    }
    modalFooterClose.onclick = function(){
        toggleModal();
    }
}

if (document.getElementById('btnDropGrp1')){
    btnDropGrp1 = document.getElementById('btnDropGrp1');
    listDropGrp1 = document.getElementById('listDropGrp1');
    // console.log('exists');
    btnDropGrp1.onclick = function(){
        if(listDropGrp1.classList.contains('open')){
            listDropGrp1.classList.remove('open');
        } else {
            listDropGrp1.classList.add('open');
        }
    }
    
    listDropGrp1.onclick = function(){
        if(listDropGrp1.classList.contains('open')){
            listDropGrp1.classList.remove('open');
        }
    }
} else {
    // console.log('!exists');
}

navToggle.onclick = function(){
    if(navMenu.classList.contains('open')){
        navMenu.classList.remove('open');
    } else if(navMenu.classList.contains('authed')){
        navDrawer.classList.remove('closed');
        body.classList.add('unfocused');
        pageFiller.classList.add('filler');
    } else {
        navMenu.classList.add('open');
    }
};

function toggleModal() {
    if(modal.classList.contains('open')){
        modal.classList.remove('open');
        body.classList.remove('unfocused');
        pageFiller.classList.remove('filler');
    } else {
        modal.classList.add('open');
        body.classList.add('unfocused');
        pageFiller.classList.add('filler');
    }
}

function closePageFiller(){
    if(document.querySelector('#navDrawer') && !document.querySelector('#navDrawer').classList.contains('closed')){
        pageFiller.classList.remove('filler');
        body.classList.remove('unfocused');
        document.querySelector('#navDrawer').classList.add('closed');
    } else if(document.querySelector('#modal') && document.querySelector('#modal').classList.contains('open')){
        modal.classList.remove('open');
        body.classList.remove('unfocused');
        pageFiller.classList.remove('filler');
    }
}