<table>
    <thead>
        <tr>
            <th>Tabla Facturas</th>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th>ID Factura</th>
            <th>Factura Electronica</th>
            <th>Fecha de factura</th>
            <th>Cliente</th>
            <th>Valor total</th>
            <th>Debe</th>
            <th>Pagado</th>
            <th>Fecha limite</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($facturas as $factura)
        <tr>
            <td>{{$factura->id_factura_cliente}}</td>
            <td>{{$factura->factura_electronica === null ? "Sin factura": $factura->factura_electronica}}</td>
            <td>{{$factura->fecha_factura}}</td>
            <td>{{$factura->nombre_cliente}}</td>
            <td>${{$factura->valor_total === null? 0:number_format($factura->valor_total,0,',','.')}}</td>
            <td>${{$factura->debe === null? 0 :number_format($factura->debe,0,',','.')}}</td>
            <td>${{$factura->pagado === null? 0 :number_format($factura->pagado,0,',','.')}}</td>
            <td>{{$factura->fecha_limite_pago === null? "Sin fecha":$factura->fecha_limite_pago}}</td>
            <td>{{$factura->created_at}}</td>
            <td>{{$factura->updated_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Tabla Pagos</th>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Factura</th>
            <th>Nit/Cedula cliente</th>
            <th>Nombre cliente</th>
            <th>Fecha Pago</th>
            <th>Monto</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pagos as $pago)
        <tr>
            <td>{{$pago->id_pago_factura}}</td>
            <td>{{$pago->id_factura_cliente}}</td>
            <td>{{$pago->nit_cedula}}</td>
            <td>{{$pago->nombre_cliente}}</td>
            <td>{{$pago->fecha_pago}}</td>
            <td>{{$pago->monto}}</td>
            <td>{{$pago->created_at}}</td>
            <td>{{$pago->updated_at}}</td>
        </tr>
        @endforeach

    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Tabla Productos de facturas</th>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>ID Factura</th>
            <th>Fecha de solicitud</th>
            <th>Fecha de entrega</th>
            <th>Referencia</th>
            <th>Producto</th>
            <th>Cantidad orden</th>
            <th>Estado de pedido</th>
            <th>Cantidad elaborada</th>
            <th>Cantidad entregada</th>
            <th>Descuento o recargo</th>
            <th>Aplica iva</th>
            <th>Valor unidad</th>
            <th>Valor total</th>
            <th>Fecha de registro</th>
            <th>Fecha actualizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($facturasProductos as $producto)
            <tr>
                <td>{{$producto->id_salida_venta}}</td>
                <td>{{$producto->id_factura_cliente}}</td>
                <td>{{$producto->fecha_solicitud}}</td>
                <td>{{$producto->fecha_entrega}}</td>
                <td>{{$producto->referencia}}</td>
                <td>{{$producto->nombre_producto}}</td>
                <td>{{$producto->cantidad_orden}}</td>
                <td>{{$producto->estado_pedido}}</td>
                <td>{{$producto->cantidad_elaborada}}</td>
                <td>{{$producto->cantidad_entregada}}</td>
                <td>{{$producto->descuento_o_recargo}}%</td>
                <td>{{$producto->aplica_iva}}</td>
                <td>${{number_format($producto->valor_unidad,0,',','.')}}</td>
                <td>${{number_format($producto->valor_total,0,',','.')}}</td>
                <td>{{$producto->created_at}}</td>
                <td>{{$producto->updated_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>