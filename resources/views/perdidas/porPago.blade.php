@extends('plantilla.plantilla')

@section('titulo', 'Perdidas')
@section('links')
    <link rel="stylesheet" href="/css/perdidasPorPago.css">
@endsection

@section('contenido')
<section class="sec-perdidas">
    <a href="{{route('perdidas.index')}}" class="btn-atras">Atras</a>
    <h2>Perdidas por falta de pago</h2>
    <div class="cont-perdidas">
        <a href="{{route('perdidas.porPagoCreate')}}">Agregar factura</a>
        @if (Auth::user()->rol === "administrador")
            <a class="btn-exportar" href="{{route('perdidas.exportPorDago')}}">Exportar</a>            
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
                    <col class="octavaColumna">
                    <col class="novenaColumna">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID factura</th>
                        <th>Fecha de factura</th>
                        <th>Cliente</th>
                        <th>Valor total</th>
                        <th>Debe</th>
                        <th>Pagado</th>
                        <th>Fecha limite</th>
                        @if (Auth::user()->rol === "administrador")
                        <th>Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perdidasFacturas as $factura)
                        <tr class="tr">
                            <td class="td-menos">{{$factura->id_salida_perdida_credito}}</td>
                            <td class="td-menos">{{$factura->id_factura_cliente}}</td>
                            <td>{{$factura->fecha_factura}}</td>
                            <td class="td-texto-center">{{$factura->nombre_cliente}}</td>
                            <td>${{number_format($factura->valor_total,0,',','.')}}</td>
                            <td>${{number_format($factura->debe,0,',','.')}}</td>
                            <td>${{number_format($factura->pagado,0,',','.')}}</td>
                            <td>{{$factura->fecha_limite_pago}}</td>
                            @if (Auth::user()->rol === "administrador")
                            <td class="td-menos"><form class="form_eliminar" action="{{route('perdidas.porPagoDestroy', $factura->id_salida_perdida_credito)}}" method="POST"> @csrf @method('delete')<button class="btn-eliminar-tabla"><img src="/img/basura.png" alt="basura"></button></form></td>
                            @endif
                        </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
        </div>
        {{$perdidasFacturas->links()}}
    </div>
</section>
@if (session('alert'))
    <script>
        alert("{{session('alert')}}")
    </script>
@endif
@endsection

@section('scripts')
    <script src="/js/perdidas.porPago.js"></script>
@endsection