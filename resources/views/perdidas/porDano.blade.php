@extends('plantilla.plantilla')

@section('titulo', 'Perdidas')
@section('links')
    <link rel="stylesheet" href="/css/perdidasPorDano.css">
@endsection

@section('contenido')
<section class="sec-perdidas">
    <a href="{{route('perdidas.index')}}" class="btn-atras">Atras</a>
    <h2>Perdidas por daño o devolución</h2>
    <div class="cont-perdidas">
        @if (Auth::user()->rol === "administrador")
            <a class="btn-exportar" href="{{route('perdidas.exportPorDano')}}">Exportar</a>            
        @endif
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
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID existencia</th>
                        <th>Referencia</th>
                        <th>Nombre producto</th>
                        <th>Categoria</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Costo inversion</th>
                        <th>Editar cantidad</th>
                        @if (Auth::user()->rol === "administrador")
                        <th>Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @forelse ($perdidas as $perdida)
                    <tr class="tr">
                        <td class="td-menos">{{$perdida->id_salida_perdida}}</td>
                        <td class="td-menos">{{$perdida->id_entrada}}</td>
                        <td class="td-menos">{{$perdida->referencia}}</td>
                        <td class="td-texto-center">{{$perdida->nombre_producto}}</td>
                        <td class="td-texto-center">{{$perdida->categoria}}</td>
                        <td class="td-texto-center">{{$perdida->descripcion}}</td>
                        <td class="td-menos">{{$perdida->cantidad}}</td>
                        <td>${{number_format($perdida->costo_inversion,0,',','.')}}</td>
                        <td class="td-menos"><a href="{{route('perdidas.porDanoEditar', $perdida->id_salida_perdida)}}" class="btn_editar"><img src="/img/editar.png" alt="editar"></a></td>
                        @if (Auth::user()->rol === "administrador")
                        <td class="td-menos"><form class="form_eliminar" action="{{route('perdidas.porDanoDelete', $perdida->id_salida_perdida)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla"><img src="/img/basura.png" alt="basura"></button></form></td>
                        @endif
                    </tr>
                @empty
                    <tr class="tr"></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{$perdidas->links()}}
    </div>
</section>
@if (session('alert'))
    <script>
        alert("{{session('alert')}}")
    </script>
@endif
@endsection

@section('scripts')
    <script src="/js/perdidas.porDano.js"></script>
@endsection