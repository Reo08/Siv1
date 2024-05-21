@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventasProductosEditar.css">
@endsection

@section('contenido')
<section class="sec-ventas">
    <a href="{{route('ventas.indexProductos',$id_factura->id_factura_cliente)}}" class="btn-atras">Atras</a>
    <form class="cont-ventas" action="{{route('ventas.updateProducto',["id_factura" => $id_factura->id_factura_cliente,"id_salida_venta"=>$id_salida_venta->id_salida_venta])}}" method="POST">
        @csrf
        @method('put')
        <legend>Actualizar producto de factura N°{{$id_factura->id_factura_cliente}} de {{$cliente->nombre_cliente}}</legend>
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li> ⚠ {{$error}}</li>
                    @endforeach
                </ul>
            @endif
        <div class="cont-tabla-ventas">
            <table>
                <colgroup>
                    <col class="primeraColumna">
                    <col class="segundaColumna">
                    <col class="terceraColumna">
                    <col class="cuartaColumna">
                    <col class="quintaColumna">
                </colgroup>
                <thead>
                    <tr>
                        <th>Referencia</th>
                        <th>Precio de venta distribuidor</th>
                        <th>Fecha de solicitud</th>
                        <th>Fecha de entrega</th>
                        <th>Estado de pedido</th>
                        <th>Cantidad elaborada</th>
                        <th>Cantidad entregada</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr">
                        <td>{{$entradaProducto->referencia}}</td>
                        <td>${{$entradaProducto->precio_venta_distribuidor}}</td>
                        <td><input type="date" name="fecha_solicitud" id="fecha_solicitud" required value="{{old('fecha_solicitud',$id_salida_venta->fecha_solicitud)}}"></td>
                        <td><input type="date" name="fecha_entrega" id="fecha_entrega" required value="{{old('fecha_entrega', $id_salida_venta->fecha_entrega)}}"></td>
                        <td>
                            <select name="sec_estado_pedido">
                                <option value="{{$id_salida_venta->estado_pedido}}">{{$id_salida_venta->estado_pedido}}</option>
                                @if ($id_salida_venta->estado_pedido === "En fabricacion")
                                    <option value="Entregadas">Entregadas</option>
                                    <option value="Listas para entregar">Listas para entregar</option>
                                @elseif ($id_salida_venta->estado_pedido === "Entregadas")
                                    <option value="En fabricacion">En fabricación</option>
                                    <option value="Listas para entregar">Listas para entregar</option>
                                @else 
                                    <option value="Entregadas">Entregadas</option>
                                    <option value="En fabricacion">En fabricación</option>
                                @endif
                            </select>
                        </td>
                        <td><input type="number" name="cantidad_elaborada"class="n_cantidad" required value="{{old('cantidad_elaborada', $id_salida_venta->cantidad_elaborada)}}"></td>
                        <td><input type="number" name="cantidad_entregada"class="n_cantidad" required value="{{old('cantidad_entregada',$id_salida_venta->cantidad_entregada)}}"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="cont-btns">
            <button>Guardar</button>
            <a href="{{route('ventas.indexProductos',$id_factura->id_factura_cliente)}}">Cancelar</a>
        </div>
    </form>
    @if (session('alert'))
    <script>
        alert("{{session('alert')}}")
    </script>
    @endif
</section>
@endsection

@section('scripts')
<script src="/js/ventas.productosAgregar.js"></script>
@endsection