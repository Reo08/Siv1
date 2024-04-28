const $btnCerrarMenu = d.querySelector('.btn-cerrar-menu')
const $menu = d.querySelector('.sec-nav')
d.addEventListener("click", e => {
    if(e.target.matches('.cont-menu') || e.target.matches('.cont-menu *')){
        if(window.innerWidth > 500 ){
            d.body.classList.toggle('body')
        }else {
            $menu.classList.toggle('activeMenu')
        }
    }
    if(e.target === $btnCerrarMenu){
        $menu.classList.remove('activeMenu')
    }
})