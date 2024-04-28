document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar esta categoria?\nSe eliminarán todos los productos y existencias relacionados a esa categoria.')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})