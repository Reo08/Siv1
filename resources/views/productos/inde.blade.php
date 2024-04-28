@extends('plantilla.plantilla')

@section('titulo', 'Productos')
@section('links')
    <link rel="stylesheet" href="/css/productos.css">
@endsection

@section('contenido')
<section class="sec-productos">
    <h2>Lista de productos</h2>
    <div class="cont-productos">
        <a href="{{route('productos.create')}}">Nuevo Producto</a>
        <a class="btn-exportar" href="{{route('productos.export')}}">Exportar</a>
        <div class="cont-inputs">
            <select name="buscar_categoria">
                <option value="">Filtrar por categoria</option>
            </select>
            <input type="text" name="buscar_productos" placeholder="Buscar por nombre">
        </div>
        <div class="cont-tabla-productos">
            <table>
                <colgroup>
                    <col class="primeraColumna">
                    <col class="segundaColumna">
                    <col class="terceraColumna">
                    <col class="cuartaColumna">
                    <col class="quintaColumna">
                    <col class="sextaColumna">
                    <col class="septimaColumna">
                </colgroup>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Proveedor</th>
                        <th>Detalles</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                    <tr class="tr">
                        <td>{{$producto->id_producto}}</td>
                        <td class="td-texto-center">{{$producto->nombre_producto}}</td>
                        <td class="td-texto-center">{{$producto->categoria}}</td>
                        <td class="td-texto-center">{{$producto->nombre_proveedor}}</td>
                        <td class="td-texto-center">{{$producto->detalles_producto}}</td>
                        <td><a href="{{route('productos.edit', $producto->id_producto)}}" class="btn-editar-tabla">Editar</a></td>
                        <td><form class="form_eliminar" action="{{route('productos.delete',$producto->id_producto)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla">Eliminar</button></form></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$productos->links()}}
    </div>
</section>
@if (session('alert'))
    <script>
        alert("{{session('alert')}}")
    </script>
@endif
@endsection

@section('scripts')
<script src="/js/productos.inde.js"></script>
@endsection