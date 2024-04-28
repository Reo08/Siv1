document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar esta existencia?')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})