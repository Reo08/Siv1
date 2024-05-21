@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventasVerPagos.css">
@endsection

@section('contenido')
<section class="sec-ventas">
    <a href="{{route('ventas.index')}}" class="btn-atras">Atras</a>

    <div class="cont-ventas">
        <h2> Pagos factura ID: <strong class="id_factura_cliente">{{$id_factura->id_factura_cliente}}</strong> de {{$cliente->nombre_cliente}}</h2>
        <div class="cont_tabla_dos">
            <table>
                <thead>
                    <tr>
                        <th>Valor total</th>
                        <th>Debe</th>
                        <th>Pagado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr">
                        <td>${{number_format($id_factura->valor_total,0,',','.')}}</td>
                        <td>${{number_format($id_factura->debe,0,',','.')}}</td>
                        <td>${{$id_factura->pagado === null ? 0 : number_format($id_factura->pagado,0,',','.')}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="cont-tabla-ventas">
            <table>
                <colgroup>
                    <col class="primeraColumna">
                    <col class="segundaColumna">
                    <col class="terceraColumna">
                    <col class="cuartaColumna">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha de pago</th>
                        <th>Monto</th>
                        @if (Auth::user()->rol === "administrador")
                        <th>Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pagos as $pago)
                        <tr class="tr">
                            <td class="td-menos">{{$pago->id_pago_factura}}</td>
                            <td class="td-texto-center">{{$pago->fecha_pago}}</td>
                            <td class="td-texto-center">${{number_format($pago->monto,0,',','.')}}</td>
                            <td class="td-menos"><form class="form_delete_producto_venta" action="{{route('ventas.detelePagos',$pago->id_pago_factura)}}" method="POST" >@csrf @method('delete')<button class="btn-eliminar-tabla"><img src="/img/basura.png" alt="eliminar"></button></form></td>
                        </tr>
                    @empty
                        <tr class="tr"></tr>
                    @endforelse
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

@endsection