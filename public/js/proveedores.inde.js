



document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar este proveedor?\nSe eliminarán todos los productos y existencias relacionados a ese proveedor.')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})
