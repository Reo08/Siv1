@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventasProductos.css">
@endsection

@section('contenido')
<section class="sec-ventas">
    <a href="{{route('ventas.index')}}" class="btn-atras">Atras</a>

    <div class="cont-ventas">
        <h2>Factura ID: <strong class="id_factura_cliente">{{$id_factura->id_factura_cliente}}</strong> de {{$cliente->nombre_cliente}}</h2>
        @if ($hayPagos === "no")
        <a href="{{route('ventas.createProducto',$id_factura->id_factura_cliente)}}">Agregar producto</a>
        @endif
        <div class="cont_tabla_dos">
            <table>
                <thead>
                    <tr>
                        <th>Valor compra total</th>
                        <th>Debe</th>
                        <th>Pagado</th>
                        <th>Total entregadas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr">
                        <td>${{$id_factura->valor_total === null ? 0 : number_format($id_factura->valor_total,0,',','.')}}</td>
                        <td>${{$id_factura->debe === null? 0 : number_format($id_factura->debe,0,',','.') }}</td>
                        <td>${{$id_factura->pagado === null? 0 : number_format($id_factura->pagado,0,',','.')}}</td>
                        <td>{{$cantidadTotalEntregadas}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="cont-tabla-ventas">
            <table>
                <colgroup>
                    <col class="primeraColumna">
                    <col class="segundaColumna">
                    <col class="terceraColumna">
                    <col class="cuartaColumna">
                    <col class="quintaColumna">
                    <col class="sextaColumna">
                    <col class="septimaColumna">
                    <col class="octavaColumna">
                    <col class="novenaColumna">
                    <col class="decimaColumna">
                    <col class="onceavaColumna">
                    <col class="doceavaColumna">
                    <col class="treceavaColumna">
                    <col class="catorceavaColumna">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
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
                        <th>Editar</th>
                        @if ($hayPagos === "no")
                        <th>Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($facturaProductos as $producto)
                        <tr class="tr">
                            <td>{{$producto->id_salida_venta}}</td>
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
                            <td><a href="{{route('ventas.editProducto', ["id_factura" =>$id_factura->id_factura_cliente,"id_salida_venta"=>$producto->id_salida_venta])}}" class="btn_editar"><img src="/img/editar.png" alt="editar"></a></td>
                            @if ($hayPagos === "no")
                            <td><form class="form_delete_producto_venta" action="{{route('ventas.deleteProducto', ["id_factura" =>$id_factura->id_factura_cliente,"id_salida_venta"=>$producto->id_salida_venta])}}" method="POST" >@csrf @method('delete')<button class="btn-eliminar-tabla"><img src="/img/basura.png" alt="eliminar"></button></form></td>
                            @endif
                        </tr>
                    @empty
                        <tr class="tr"></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if (session('alert'))
    <script>
        alert("{{session('alert')}}")
    </script>
    @endif
</section>
@endsection

@section('scripts')
    <script src="/js/ventas.productos.js"></script>
@endsection