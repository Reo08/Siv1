

document.addEventListener('DOMContentLoaded', e=> {
    const $selectCategoria = document.querySelector(".select_categoria");
    const $selectProducto = document.querySelector(".select_producto");
    // const $selectProveedor = document.querySelector(".select_proveedor");
    const $frag = document.createDocumentFragment();
    // const $frag2 = document.createDocumentFragment();

    $selectCategoria.addEventListener("change", e=> {
        let valorSelectCategoria = e.target.value;
        if(valorSelectCategoria){
            $selectProducto.innerHTML = '<option value="">Seleccione un producto</option>';
            fetch(`/productos-por-categoria/${valorSelectCategoria}`)
            .then(response => response.ok? response.json(): Promise.reject(response))
            .then(dato => {
                let $array = Array.from(dato);
                $array.forEach(el => {
                    let $option = document.createElement("option");
                    $option.value = el.id_producto;
                    $option.innerHTML = el.nombre_producto;
                    $frag.appendChild($option);
                })
                // $selectProducto.innerHTML = $frag.innerHTML;
                $selectProducto.appendChild($frag);
            })
            .catch(error => console.log(error));
        }else {
            $selectProducto.innerHTML = '<option value="">Seleccione un producto</option>';
        }

    })

    // $selectProducto.addEventListener("change", e=> {
    //     let valorSelectProducto = e.target.value;
    //     if(valorSelectProducto){
    //         $selectProveedor.innerHTML = '<option value="">Seleccione un proveedor</option>';
    //         fetch(`/proveedores-select/${e.target.value}`)
    //         .then(response => response.ok? response.json(): Promise.reject(response))
    //         .then(dato => {
    //             console.log(dato);
    //             let $array = Array.from(dato);
    //             $array.forEach(el => {
    //                 let $option = document.createElement("option");
    //                 $option.value = el.id_proveedor;
    //                 $option.innerHTML = el.nombre_proveedor;
    //                 $frag2.appendChild($option);
    //             })
    //             // $selectProducto.innerHTML = $frag.innerHTML;
    //             $selectProveedor.appendChild($frag2);
    //         })
    //         .catch(error => console.log(error));
    //     }else {
    //         $selectProveedor.innerHTML = '<option value="">Seleccione un proveedor</option>';
    //     }
    // }) 
});