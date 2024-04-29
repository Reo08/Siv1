document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar este producto?\nSe eliminarán todas las existencias relacionados a ese producto.')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})

const $filas = document.querySelectorAll(".tr")
const $nombres = document.querySelectorAll(".nombre")
document.addEventListener('keyup', e=> {
    if(e.target.matches(".buscar_producto")){
        let valor = e.target.value.toLowerCase()
        let i = 0;
        $nombres.forEach(el => {
            if(el.textContent.toLowerCase().includes(valor)){
                $filas[i].classList.remove("addFiltrar")
                i++
            }else {
                $filas[i].classList.add("addFiltrar")

                i++
            }
        })

    }
})

const $categorias = document.querySelectorAll('.categoria')
document.addEventListener('change', e=> {
    if(e.target.matches(".buscar_categoria")){

        let j = 0;
        $categorias.forEach(el  => {
            if(el.textContent.toLowerCase().includes(e.target.value.toLowerCase())){
                $filas[j].classList.remove("addFiltrar")
                j++
            }else {
                $filas[j].classList.add("addFiltrar")
                j++
            }
        })
    }
})