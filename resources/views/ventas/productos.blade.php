@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventasProductos.css">
@endsection

@section('contenido')
<section class="sec-ventas">
    <a href="{{route('ventas.index')}}" class="btn-atras">Atras</a>
    <h2>Factura ID:{{$id_factura->id_factura_cliente}} de {{$cliente->nombre_cliente}}</h2>
    <div class="cont-ventas">
        <a href="{{route('ventas.createProducto',$id_factura->id_factura_cliente)}}">Agregar producto</a>
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
                        @if (Auth::user()->rol === "administrador")
                        <th>Editar</th>
                        @if ($hayPagos === "no")
                        <th>Eliminar</th>
                        @endif
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
                            <td>${{$producto->valor_unidad}}</td>
                            <td>${{$producto->valor_total}}</td>
                            <td><a href="{{route('ventas.editProducto', ["id_factura" =>$id_factura->id_factura_cliente,"id_salida_venta"=>$producto->id_salida_venta])}}"><img src="/img/editar.png" alt="editar"></a></td>
                            @if ($hayPagos === "no")
                            <td><form class="form_delete_producto_venta" action="{{route('ventas.deleteProducto', ["id_factura" =>$id_factura->id_factura_cliente,"id_salida_venta"=>$producto->id_salida_venta])}}" method="POST" >@csrf @method('delete')<button><img src="/img/basura.png" alt="eliminar"></button></form></td>
                            @endif
                        </tr>
                    @empty
                        <tr class="tr"></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="cont_tabla_dos">
            <table>
                <thead>
                    <tr>
                        <th>Valor compra total</th>
                        <th>Debe</th>
                        <th>Pagado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr">
                        <td>${{$id_factura->valor_total === null ? 0 : $id_factura->valor_total}}</td>
                        <td>${{$id_factura->debe === null? 0 : $id_factura->debe }}</td>
                        <td>${{$id_factura->pagado === null? 0 : $id_factura->pagado}}</td>
                    </tr>
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