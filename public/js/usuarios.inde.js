document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar este usuario?\nSe eliminarán todas existencias, ventas y pérdidas que hayan sido manipulados por este usuario.')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})

const $filas = document.querySelectorAll(".tr")
const $nombres = document.querySelectorAll(".nombre")
const $correos = document.querySelectorAll(".correo")
document.addEventListener('keyup', e=> {
    if(e.target.matches(".buscar_nombre")){
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
    if(e.target.matches(".buscar_correo")){
        let valor = e.target.value.toLowerCase()
        let j = 0;
        $correos.forEach(el => {
            if(el.textContent.toLowerCase().includes(valor)){
                $filas[j].classList.remove("addFiltrar")
                j++
            }else {
                $filas[j].classList.add("addFiltrar")

                j++
            }
        })
    }
})