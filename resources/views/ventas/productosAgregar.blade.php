@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventasProductosAgregar.css">
@endsection

@section('contenido')
<section class="sec-ventas">
    <a href="{{route('ventas.indexProductos',$id_factura->id_factura_cliente)}}" class="btn-atras">Atras</a>
    <form class="cont-ventas" action="{{route('ventas.storeProducto',$id_factura->id_factura_cliente)}}" method="POST">
        @csrf
        <legend>Agregar producto a factura N°{{$id_factura->id_factura_cliente}} de {{$cliente->nombre_cliente}}</legend>
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
                    <col class="sextaColumna">
                    <col class="septimaColumna">
                    <col class="octavaColumna">
                    <col class="novenaColumna">
                    <col class="decimaColumna">
                </colgroup>
                <thead>
                    <tr>
                        <th>Fecha de solicitud</th>
                        <th>Fecha de entrega</th>
                        <th>Categoria</th>
                        <th>Producto</th>
                        <th>Cantidad orden</th>
                        <th>Estado de pedido</th>
                        <th>Cantidad elaborada</th>
                        <th>Cantidad entregada</th>
                        <th>Descuento o recargo</th>
                        <th>Aplica iva</th>
                        <th>Valor unidad</th>
                        <th>Valor total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr">
                        <td><input type="date" name="fecha_solicitud" id="fecha_solicitud" required></td>
                        <td><input type="date" name="fecha_entrega" id="fecha_entrega" required></td>
                        <td>
                            <select name="sec_categoria" class="sec_categoria" required>
                                <option value="">Seleccione categoria</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{$categoria->id_categoria}}">{{$categoria->nombre_categoria}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="sec_existencia" class="sec_existencia" required>
                                <option value="">Seleccione un producto</option>
                            </select>
                        </td>
                        <td><input type="number" name="cantidad_orden" class="n_cantidad cantidad_orden" required></td>
                        <td>
                            <select name="sec_estado_pedido">
                                <option value="">Seleccione estado</option>
                                <option value="entregadas">Entregadas</option>
                                <option value="en fabricacion">En fabricacion</option>
                                <option value="listas">Listas para entregar</option>
                            </select>
                        </td>
                        <td><input type="number" name="cantidad_elaborada"class="n_cantidad" required></td>
                        <td><input type="number" name="cantidad_entregada"class="n_cantidad" required></td>
                        <td>
                            <input type="number" name="n_descuento_recargo" class="n_descuento_recargo" required placeholder="%%%">%
                        </td>
                        <td>
                            <select name="aplica_iva" class="aplica_iva" required>
                                <option value="no">No</option>
                                <option value="si">Si</option>
                            </select>
                        </td>
                        <td>$<input type="number" name="valor_unidad" class="n_cantidad valor_unidad" required disabled></td>
                        <td>$<input type="number" name="valor_total" class="n_cantidad valor_total" required disabled></td>
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