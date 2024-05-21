const $btnCerrarMenu = d.querySelector('.btn-cerrar-menu')
const $menu = d.querySelector('.sec-nav')
let i = 0;

const menuActivo = ()=> {
    d.body.classList.remove('body')
    i = 1;
}

const menuDesactivo = ()=> {
    d.body.classList.add('body')
    i = 0;
}
d.addEventListener("click", e => {
    if(e.target.matches('.cont-menu') || e.target.matches('.cont-menu *')){
        if(window.innerWidth > 500 ){
            if(i === 0){
                menuActivo()
            }else{
                menuDesactivo()
            }
            
        }else {
            $menu.classList.toggle('activeMenu')
        }
    }
    if(e.target === $btnCerrarMenu){
        $menu.classList.remove('activeMenu')
    }
})

d.addEventListener('DOMContentLoaded', e=> {
    if(localStorage.getItem('activeMenu') === null){localStorage.setItem('activeMenu','desactive')}
    if(localStorage.getItem('activeMenu') ==='active'){menuActivo()}
    if(localStorage.getItem('activeMenu') ==='desactive'){menuDesactivo()}
})