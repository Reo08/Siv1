
document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar este proveedor?\nSe eliminarán todos los productos y existencias relacionados a ese proveedor.')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})

const $filas = document.querySelectorAll(".tr")
const $nombres = document.querySelectorAll(".nombre")
document.addEventListener('keyup', e=> {
    if(e.target.matches(".buscar_nombre")){
        let valor = e.target.value.toLowerCase()
        let i = 0;
        $nombres.forEach(el => {
            if(el.textContent.toLowerCase().includes(valor)){
                // $filas[i].style.visibilo = "block";
                $filas[i].classList.remove("addFiltrar")
                i++
            }else {
                $filas[i].classList.add("addFiltrar")
                // $filas[i].style.display = "none";
                i++
            }
        })

    }
})