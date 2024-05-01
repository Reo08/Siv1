const d = document

// .desactive
const $items = d.querySelectorAll('.nav-item')
const $contItems = d.querySelectorAll('.nav-item-cont')
const $navSpans = d.querySelectorAll('.nav-span')
const $btnScroll = d.querySelector('.btn_scroll')
d.addEventListener('click', e=> {
    if(e.target.matches('.nav-item')){
        e.target.querySelector('.nav-span').classList.toggle('desactive')
        e.target.nextElementSibling.classList.toggle('desactive')
    }

    // boton scroll
    if(e.target.matches('.btn_scroll')){
        window.scroll(0,0)
    }
})


d.addEventListener('submit', e=> {
    if(e.target.matches('.form_reset')){
        let confirmar = confirm("¿Esta segur@ que desa borrar todos los datos?");

        if(!confirmar){
            e.preventDefault();
        }
    }

})

// boton scroll
window.addEventListener('scroll', e=>{
    if(d.documentElement.scrollTop >300){
        $btnScroll.classList.remove('active');
    }else {
        $btnScroll.classList.add('active');
    }
})
