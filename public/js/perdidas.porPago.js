document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar esta pérdida por falta de pago?')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})
