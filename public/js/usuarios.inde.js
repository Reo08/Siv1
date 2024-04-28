document.addEventListener('submit', e=> {
    if(e.target.matches('.form_eliminar')){
        let confirmacion = confirm('¿Está seguro que desea eliminar este usuario?\nSe eliminarán todas existencias, ventas y pérdidas que hayan sido manipulados por este usuario.')

        if(!confirmacion){
            e.preventDefault();
        }
    }
})