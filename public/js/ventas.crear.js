
document.addEventListener('DOMContentLoaded', e=> {
    const $selectCategoria = document.querySelector(".select_categoria");
    const $selectProducto = document.querySelector(".select_producto");
    const $inputPrecioVenta = document.querySelector(".precio_venta");
    const $inputCantidadVenta = document.querySelector(".cantidad_venta");
    const $frag = document.createDocumentFragment();
    const $frag2 = document.createDocumentFragment();

    $selectCategoria.addEventListener("change", e=> {
        let valorSelectCategoria = e.target.value;
        if(valorSelectCategoria){
            $selectProducto.innerHTML = '<option value="">Seleccione un producto</option>';
            fetch(`/productos-categoria-ventas/${valorSelectCategoria}`)
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

    $selectProducto.addEventListener("change", e=> {
        let valorSelectProducto = e.target.value;
        if(valorSelectProducto){


            fetch(`/proveedores-select-ventas/${e.target.value}`)
            .then(response => response.ok? response.json(): Promise.reject(response))
            .then(dato => {
                let $array = Array.from(dato[0]);
                $inputPrecioVenta.value = dato[1];
                $inputCantidadVenta.value = dato[2];
                // $selectProducto.innerHTML = $frag.innerHTML;
            })
            .catch(error => console.log(error));
        }
    }) 
});