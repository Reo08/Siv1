@extends('plantilla.plantilla')

@section('titulo', 'Entradas')
@section('links')
    <link rel="stylesheet" href="/css/entradas.css">
@endsection

@section('contenido')
<section class="sec-entradas">
    <h2>Lista de existencias</h2>
    <div class="cont-entradas">
        <a href="{{route('entradas.create')}}">Agregar existencia</a>
        <a class="btn-exportar" href="{{route('entradas.export')}}">Exportar</a>
        <div class="cont-inputs">
            <select name="buscar_categoria">
                <option value="">Filtrar por categoria</option>
            </select>
            <input type="text" name="buscar_productos" placeholder="Buscar por producto">
        </div>
        <div class="cont-tabla-entradas">
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
                </colgroup>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>categoria</th>
                        <th>Cantidad</th>
                        <th>Precio de compra / u</th>
                        <th>Precio de venta / u</th>
                        <th>Entrada por</th>
                        <th>Fecha de entrada</th>
                        <th>Fecha de registro</th>
                        <th>Fecha actualizada</th>
                        <th>Agregar</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($entradas as $entrada)
                <tr class="tr">
                    <td class="td-menos">{{$entrada->id_entrada}}</td>
                    <td class="td-texto-center">{{$entrada->nombre_producto}}</td>
                    <td class="td-texto-center">{{$entrada->nombre_categoria}}</td>
                    <td class="td-texto-center">{{$entrada->cantidad_entrada}}</td>
                    <td class="td-texto-center">{{$entrada->precio_compra_entrada}}</td>
                    <td class="td-texto-center">{{$entrada->precio_venta_entrada}}</td>
                    <td class="td-texto-center">{{$entrada->nombre_usuario}}</td>
                    <td>{{$entrada->fecha_entrada}}</td>
                    <td>{{$entrada->created}}</td>
                    <td>{{$entrada->updated}}</td>
                    <td><a href="{{route('entradas.edit.cantidad', $entrada->id_entrada)}}" class="btn-agregar-tabla">Agregar</a></td>
                    <td><a href="{{route('entradas.edit', $entrada->id_entrada)}}" class="btn-editar-tabla">Editar</a></td>
                    <td><form class="form_eliminar" action="{{route('entradas.delete', $entrada->id_entrada)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla">Eliminar</button></form></td>
                </tr>                    
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@if (session('alert'))
    <script>
        alert("{{session('alert')}}")
    </script>
@endif
@endsection

@section('scripts')
<script src="/js/entradas.inde.js"></script>
@endsection