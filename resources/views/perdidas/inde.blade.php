@extends('plantilla.plantilla')

@section('titulo', 'Perdidas')
@section('links')
    <link rel="stylesheet" href="/css/perdidas.css">
@endsection

@section('contenido')
<section class="sec-perdidas">
    <h2>Lista de pérdidas</h2>
    <div class="cont-perdidas">
        <a href="{{route('perdidas.create')}}">Agregar pérdida</a>
        @if (Auth::user()->rol === "administrador")
        <a class="btn-exportar" href="{{route('perdidas.export')}}">Exportar</a>
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
        <div class="cont-tabla-perdidas">
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
                        <th>Precio de compra / u</th>
                        <th>Registro por</th>
                        <th>fecha de perdida</th>
                        <th>Fecha de registro</th>
                        <th>Fecha actualizada</th>
                        @if (Auth::user()->rol === "administrador")
                        <th>Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @forelse ($perdidas as $perdida)
                    <tr class="tr">
                        <td class="td-menos">{{$perdida->id_salida_perdida}}</td>
                        <td class="td-texto-center nombre">{{$perdida->nombre_producto}}</td>
                        <td class="td-texto-center categoria">{{$perdida->nombre_categoria}}</td>
                        <td class="td-texto-center">{{$perdida->cantidad}}</td>
                        <td class="td-texto-center">{{$perdida->precio_compra}}</td>
                        <td class="td-texto-center">{{$perdida->nombre_usuario}}</td>
                        <td>{{$perdida->fecha_perdida}}</td>
                        <td>{{$perdida->created}}</td>
                        <td>{{$perdida->updated}}</td>
                        @if (Auth::user()->rol === "administrador")
                        <td><form class="form_eliminar" action="{{route('perdidas.delete', $perdida->id_salida_perdida)}}" method="POST">@csrf @method('delete') <button class="btn-eliminar-tabla">Eliminar</button></form></td>
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
    <script src="/js/perdidas.inde.js"></script>
@endsection