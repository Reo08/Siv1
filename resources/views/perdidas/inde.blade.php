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
        <div class="cont-inputs">
            <select name="buscar_categoria">
                <option value="">Filtrar por categoria</option>
            </select>
            <input type="text" name="buscar_productos" placeholder="Buscar por producto">
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
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($perdidas as $perdida)
                    <tr class="tr">
                        <td class="td-menos">{{$perdida->id_salida_perdida}}</td>
                        <td class="td-texto-center">{{$perdida->nombre_producto}}</td>
                        <td class="td-texto-center">{{$perdida->nombre_categoria}}</td>
                        <td class="td-texto-center">{{$perdida->cantidad}}</td>
                        <td class="td-texto-center">{{$perdida->precio_compra}}</td>
                        <td class="td-texto-center">Leyder Fabian restrepo Otalora</td>
                        <td>{{$perdida->fecha_perdida}}</td>
                        <td>{{$perdida->created}}</td>
                        <td>{{$perdida->updated}}</td>
                        <td><form class="form_eliminar" action="{{route('perdidas.delete', $perdida->id_salida_perdida)}}" method="POST">@csrf @method('delete') <button class="btn-eliminar-tabla">Eliminar</button></form></td>
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
    <script src="/js/perdidas.inde.js"></script>
@endsection