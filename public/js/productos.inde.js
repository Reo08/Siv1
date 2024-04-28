document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar este producto?\nSe eliminarán todas las existencias relacionados a ese producto.')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})