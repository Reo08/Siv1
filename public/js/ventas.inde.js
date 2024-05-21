document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar esta factura?\nLa cantidad de productos que hay en la factura no regresaran a las existencias.')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})

const $filas = document.querySelectorAll(".tr")
const $nombres = document.querySelectorAll(".nombre")
document.addEventListener('change', e=> {
    if(e.target.matches(".buscar_factura_cliente")){

        let j = 0;
        $nombres.forEach(el  => {
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


// Programacion de la fecha limite
const $debeAll = document.querySelectorAll(".debe");
let $fecha_limite = document.querySelectorAll(".fecha_limite");
let fecha_actual =  new Date();
let iterador = 0;

$fecha_limite.forEach(el  => {
    let debe = $debeAll[iterador].textContent.replace('$','');

    if(parseInt(debe) > 0){
        if(el.textContent.toLowerCase() === "sin fecha"){

        }else {
            let fecha_limite = new Date(el.textContent);
    
            fecha_limite.setHours(0,0,0,0)
            fecha_actual.setHours(0,0,0,0)
    
            let diferenciaTiempo = fecha_limite - fecha_actual;
            let diferenciaDias = Math.ceil(diferenciaTiempo / (1000*60*60*24));
            

            if(diferenciaDias < 4 && diferenciaDias >= 0){
                console.log(`Se pone amarillo`);
                el.parentElement.classList.add("proximo_fecha_limite");
            }else if(diferenciaDias < 0) {
                el.parentElement.classList.remove("proximo_fecha_limite");
                el.parentElement.classList.add("fecha_vencida");
            }
        }
    }else if(parseInt(debe) === 0){
        el.parentElement.classList.remove("proximo_fecha_limite");
        el.parentElement.classList.remove("fecha_vencida");
    }
    
    iterador++


})