@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventas.css">
@endsection

@section('contenido')
<section class="sec-ventas">
    <h2>Lista de ventas</h2>
    <div class="cont-ventas">
        <a href="{{route('ventas.create')}}">Agregar venta</a>
        <div class="cont-inputs">
            <select name="buscar_categoria">
                <option value="">Filtrar por categoria</option>
            </select>
            <input type="text" name="buscar_productos" placeholder="Buscar por producto">
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
                </colgroup>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>categoria</th>
                        <th>Cantidad</th>
                        <th>Precio de venta / u</th>
                        <th>Venta por</th>
                        <th>Fecha de venta</th>
                        <th>Fecha de registro</th>
                        <th>Fecha actualizada</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($ventas as $venta)
                <tr class="tr">
                    <td class="td-menos">{{$venta->id_salida_venta}}</td>
                    <td class="td-texto-center">{{$venta->nombre_producto}}</td>
                    <td class="td-texto-center">{{$venta->nombre_categoria}}</td>
                    <td class="td-texto-center">{{$venta->cantidad}}</td>
                    <td class="td-texto-center">{{$venta->precio_venta}}</td>
                    <td class="td-texto-center">Poner el nombre del usuario</td>
                    <td>{{$venta->fecha_venta}}</td>
                    <td>{{$venta->created}}</td>
                    <td>{{$venta->updated}}</td>
                    <td><form class="form_eliminar" action="{{route('ventas.delete', $venta->id_salida_venta)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla">Eliminar</button></form></td>
                </tr> 
                @endforeach
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
<script src="/js/ventas.inde.js"></script>
@endsection