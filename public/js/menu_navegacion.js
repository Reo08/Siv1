const d = document

// .desactive
const $items = d.querySelectorAll('.nav-item')
const $contItems = d.querySelectorAll('.nav-item-cont')
const $navSpans = d.querySelectorAll('.nav-span')
d.addEventListener('click', e=> {
    if(e.target.matches('.nav-item')){
        e.target.querySelector('.nav-span').classList.toggle('desactive')
        e.target.nextElementSibling.classList.toggle('desactive')

    }
})