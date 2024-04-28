document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar esta venta?')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})