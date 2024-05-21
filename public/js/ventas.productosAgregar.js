
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
    let $id_factura = document.querySelector(".id_factura");
    let hay_factura;
    let retencionUnidad = 0;
    let unaVez = true;
    let vuSinIva;
    let vuSinIva2;
    let cantidadTotal=0;

    // Este fetch trae la factura
    fetch(`/pedir-factura-electronica/${$id_factura.textContent}`)
    .then(res => res.ok ? res.json() : Promise.reject(res))
    .then(dato => {
        hay_factura = dato;
    })
    .catch(err => console.log(err))

    document.addEventListener("change", e=> {
        // select categoria
        if(e.target.matches(".sec_categoria")){
            unaVez = true;
            $selectExistencia.innerHTML = `<option value="">Seleccione un producto</option>`
            $inputValorUnidad.value = null;
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
            unaVez = true;
            let valorSelectExistencia = e.target.value;
            if(valorSelectExistencia){
                $inputCantidadOrden.value = null;
                document.querySelector(".n_descuento_recargo").value = null;
                $inputValorTotal.value = null;
                fetch(`/productos-existencia-ventas/${valorSelectExistencia}`)
                .then(response => response.ok? response.json(): Promise.reject(response))
                .then(dato => {
                    $inputValorUnidad.value = dato.precio_venta_distribuidor;
                    vu = dato.precio_venta_distribuidor;
                    vuSinIva = dato.precio_venta_distribuidor;
                    vuSinIva2 = dato.precio_venta_distribuidor;
                })
                .catch(error => console.log(error));
            }else {
                $inputCantidadOrden.value = null;
                $inputValorUnidad.value = null;
                document.querySelector(".n_descuento_recargo").value = null;
            }
        }

        //input descuento
        if(e.target.matches(".n_descuento_recargo")){
            unaVez = true;
            //NOTA: el decuento o el recargo se hace en el precio sin iva y sin restar la retencion
            $inputCantidadOrden.value = null;
            if(e.target.value > 0){
                //RECARGO +
                let recargoVU = (vu * e.target.value)/100;
                let recargoVUSinIva = (vuSinIva2 * e.target.value)/100;
                vuSinIva = vuSinIva2 + recargoVUSinIva;
                $inputValorUnidad.value = vu + recargoVU;
            }else if(e.target.value < 0){
                //DESCUENTO -
                let descuentoVU = (vu * Math.abs(e.target.value))/100;
                let descuentoVUSinIva = (vuSinIva2 * Math.abs(e.target.value))/100;
                vuSinIva = vuSinIva2 - descuentoVUSinIva;
                $inputValorUnidad.value = vu - descuentoVU;
            }else {
                //Si deja el 0
                $inputValorUnidad.value = vu;
                vuSinIva = vuSinIva2;
            }

        }

        //input cantidad orden
        if(e.target === $inputCantidadOrden){
            if(e.target.value){

                if(hay_factura === "no"){
                    cantidadTotal = parseInt(e.target.value);
                    vt= $inputValorUnidad.value * e.target.value
                    $inputValorTotal.value = vt;
                }else {
                    // Si hay factura electronica
                    if(unaVez){
                        retencionUnidad = ($inputValorUnidad.value * 2.5) / 100;
                        $inputValorUnidad.value -= retencionUnidad;
                        vuSinIva-= retencionUnidad;
                        unaVez = false;
                    }


                    cantidadTotal = parseInt(e.target.value);
                    vt= $inputValorUnidad.value * e.target.value
                    $inputValorTotal.value = vt;
                }
            }
        }

        //select iva
        if(e.target === $selectIva){
            let valorSelectIva = e.target.value;
        
            if(valorSelectIva === "si"){
                document.querySelector(".n_descuento_recargo").disabled = true;
                $inputCantidadOrden.disabled = true;
                vpu = $inputValorUnidad.value
                vpt = $inputValorTotal.value
                let iva = (vpu * 19)/100;

                $inputValorUnidad.value  = parseInt($inputValorUnidad.value) + iva;

                iva = (vpt * 19)/100;

                $inputValorTotal.value = parseInt($inputValorTotal.value) + iva;

            }else if(valorSelectIva === "no"){
                document.querySelector(".n_descuento_recargo").disabled = false;
                $inputCantidadOrden.disabled = false;

                let iva = (vpu * 19)/100;
                $inputValorUnidad.value = $inputValorUnidad.value - iva;

                iva = (vpt * 19)/100;
                $inputValorTotal.value = $inputValorTotal.value - iva;

            }
        }
    })

    $form.addEventListener("submit", async e=> {
        const datos = {
            retencion: retencionUnidad,
            precioVentaSinIva: vuSinIva,
            cantidad: cantidadTotal
        }
        $inputCantidadOrden.disabled = false;
        $inputValorUnidad.disabled = false;
        $inputValorTotal.disabled = false;
        document.querySelector(".n_descuento_recargo").disabled = false;
        try {
            const res = await fetch(`/enviar-retencion/${$id_factura.textContent}`,{
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(datos)
            })
            
            let json = await res.json();
            if(!res.ok) throw {status: res.status, statusText: res.statusText}
        } catch (error) {
            console.log(error);
        }
    })

});