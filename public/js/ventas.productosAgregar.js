
document.addEventListener('DOMContentLoaded', e=> {
    const $selectExistencia = document.querySelector(".sec_existencia");
    const $selectIva = document.querySelector(".aplica_iva")
    const $inputValorUnidad = document.querySelector(".valor_unidad");
    const $form = document.querySelector(".cont-ventas");
    const $frag = document.createDocumentFragment();
    let vu;
    const $inputValorTotal = document.querySelector(".valor_total");
    let vt;
    const $inputCantidadOrden = document.querySelector(".cantidad_orden");
    let vpu;
    let vpt;


    document.addEventListener("change", e=> {
        // select categoria
        if(e.target.matches(".sec_categoria")){
            $selectExistencia.innerHTML = `<option value="">Seleccione un producto</option>`
            if(e.target.value){
                
                fetch(`/categorias-select-ventas/${e.target.value}`)
                .then(res => res.ok ? res.json(): Promise.reject(res))
                .then(dato => {
                    dato.forEach(el => {
                        if(el.cantidad_entrada > 0){
                            const $option = document.createElement('option');
                            $option.value = el.id_entrada;
                            $option.innerHTML = `Existencia ${el.id_entrada} ${el.nombre_producto}`;
                            $frag.appendChild($option);
                        }
                    });
                    $selectExistencia.appendChild($frag)
                })
                .catch(err => console.log(err))
            }else {
                $selectExistencia.innerHTML = `<option value="">Seleccione un producto</option>`
            }
        }
        // select existencia
        if(e.target === $selectExistencia){
            let valorSelectExistencia = e.target.value;
            if(valorSelectExistencia){
                $inputCantidadOrden.value = 0;
                document.querySelector(".n_descuento_recargo").value = 0;
                $inputValorTotal.value = null;
                fetch(`/productos-existencia-ventas/${valorSelectExistencia}`)
                .then(response => response.ok? response.json(): Promise.reject(response))
                .then(dato => {
                    $inputValorUnidad.value = dato.precio_venta_distribuidor;
                    vu = dato.precio_venta_distribuidor;
                    

                    // let $array = Array.from(dato);
                    // $array.forEach(el => {
                    //     let $option = document.createElement("option");
                    //     $option.value = el.id_producto;
                    //     $option.innerHTML = el.nombre_producto;
                    //     $frag.appendChild($option);
                    // })
                    // $selectProducto.innerHTML = $frag.innerHTML;
                })
                .catch(error => console.log(error));
            }else {
                $inputCantidadOrden.value = null;
                $inputValorUnidad.value = null;
            }
        }

        //input cantidad orden
        if(e.target === $inputCantidadOrden){
            if(e.target.value){
                vt= vu * e.target.value
                $inputValorTotal.value = vt;
                document.querySelector(".n_descuento_recargo").value = 0;
                $inputValorUnidad.value = vu;
                
            }
        }
        //input descuento
        if(e.target.matches(".n_descuento_recargo")){

            //NOTA: el decuento o el recargo se hace en el precio sin iva
            if(e.target.value > 0){
                //RECARGO +
                let recargoVU = (vu * e.target.value)/100;
                let recargoVT = (vt * e.target.value)/100;
                $inputValorUnidad.value = vu + recargoVU;
                $inputValorTotal.value = vt + recargoVT;

            }else if(e.target.value < 0){
                //DESCUENTO -
                let descuentoVU = (vu * Math.abs(e.target.value))/100;
                let descuentoVT = (vt * Math.abs(e.target.value))/100;
                $inputValorUnidad.value = vu - descuentoVU;
                $inputValorTotal.value = vt - descuentoVT;
                
            }else {
                //SI DEJA EL 0
                $inputValorUnidad.value = vu;
                $inputValorTotal.value = vt;
            }
        }

        //select iva
        if(e.target === $selectIva){
            let valorSelectIva = e.target.value;
        
            if(valorSelectIva === "si"){
                document.querySelector(".n_descuento_recargo").disabled = true;
                document.querySelector(".sec_categoria").disabled = true;
                $inputCantidadOrden.disabled = true;
                $selectExistencia.disabled = true;
                vpu = $inputValorUnidad.value
                vpt = $inputValorTotal.value
                let iva = (vpu * 19)/100;

                $inputValorUnidad.value  = parseInt($inputValorUnidad.value) + iva;

                iva = (vpt * 19)/100;

                $inputValorTotal.value = parseInt($inputValorTotal.value) + iva;

            }else if(valorSelectIva === "no"){
                document.querySelector(".n_descuento_recargo").disabled = false;
                document.querySelector(".sec_categoria").disabled = false;
                $inputCantidadOrden.disabled = false;
                $selectExistencia.disabled = false;

                let iva = (vpu * 19)/100;
                $inputValorUnidad.value = $inputValorUnidad.value - iva;

                iva = (vpt * 19)/100;
                $inputValorTotal.value = $inputValorTotal.value - iva;

            }
        }
    })

    $form.addEventListener("submit", e=> {
        document.querySelector(".n_descuento_recargo").disabled = false;
        $inputCantidadOrden.disabled = false;
        $selectExistencia.disabled = false;
        $inputValorUnidad.disabled = false;
        $inputValorTotal.disabled = false;
    })
});