document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar esta pérdida por daño o devolución?')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})