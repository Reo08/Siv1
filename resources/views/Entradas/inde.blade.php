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
        @if (Auth::user()->rol === "administrador")
        <a class="btn-exportar" href="{{route('entradas.export')}}">Exportar</a>
        @endif
        <div class="cont-inputs">
            <select name="buscar_categoria" class="buscar_categoria">
                <option value="">Filtrar por categoria</option>
            @foreach ($categorias as $categoria)
                <option value="{{$categoria->nombre_categoria}}">{{$categoria->nombre_categoria}}</option>
            @endforeach
            </select>
            <input type="text" name="buscar_productos" class="buscar_producto" placeholder="Buscar por producto">
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
                        <th>Fecha de ingreso</th>
                        <th>Fecha de registro</th>
                        <th>Fecha actualizada</th>
                        <th>Agregar</th>
                        @if (Auth::user()->rol === "administrador")
                        <th>Editar</th>
                        <th>Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @forelse ($entradas as $entrada)
                <tr class="tr">
                    <td class="td-menos">{{$entrada->id_entrada}}</td>
                    <td class="td-texto-center nombre">{{$entrada->nombre_producto}}</td>
                    <td class="td-texto-center categoria">{{$entrada->nombre_categoria}}</td>
                    <td class="td-texto-center">{{$entrada->cantidad_entrada}}</td>
                    <td class="td-texto-center">{{$entrada->precio_compra_entrada}}</td>
                    <td class="td-texto-center">{{$entrada->precio_venta_entrada}}</td>
                    <td class="td-texto-center">{{$entrada->nombre_usuario}}</td>
                    <td>{{$entrada->fecha_entrada}}</td>
                    <td>{{$entrada->created}}</td>
                    <td>{{$entrada->updated}}</td>
                    <td><a href="{{route('entradas.edit.cantidad', $entrada->id_entrada)}}" class="btn-agregar-tabla">Agregar</a></td>
                    @if (Auth::user()->rol === "administrador")
                    <td><a href="{{route('entradas.edit', $entrada->id_entrada)}}" class="btn-editar-tabla">Editar</a></td>
                    <td><form class="form_eliminar" action="{{route('entradas.delete', $entrada->id_entrada)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla">Eliminar</button></form></td>
                    @endif
                </tr>
                @empty
                <tr class="tr"></tr>                    
                @endforelse
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