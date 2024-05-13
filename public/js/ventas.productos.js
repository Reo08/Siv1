document.addEventListener('submit', e=> {
    if(e.target.matches('.form_delete_producto_venta')){
        let confirmacion = confirm('¿Está seguro que desea eliminar este producto?')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})