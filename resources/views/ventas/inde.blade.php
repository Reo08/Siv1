@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventas.css">
@endsection

@section('contenido')
<section class="sec-ventas">
    <h2>Lista de ventas (Facturas)</h2>
    <div class="cont-ventas">
        <a href="{{route('ventas.create')}}">Agregar factura</a>
        @if (Auth::user()->rol === "administrador")
        <a class="btn-exportar" href="{{route('ventas.exportFacturas')}}">Exportar</a>
        @endif
        <div class="cont-inputs">
            <select name="buscar_factura_cliente" class="buscar_factura_cliente">
                <option value="">Filtrar por cliente</option>
            @foreach ($clientes as $cliente)
                <option value="{{$cliente->nombre_cliente}}">{{$cliente->nombre_cliente}}</option>
            @endforeach
            </select>
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
                        <th>ID Factura</th>
                        <th>Factura Electronica</th>
                        <th>Fecha de factura</th>
                        <th>Cliente</th>
                        <th>Valor total</th>
                        <th>Debe</th>
                        <th>Pagado</th>
                        <th>Fecha limite</th>
                        <th>Ver contenido</th>
                        <th>Imprimir</th>
                        <th>Abonar/Pagar</th>
                        <th>Ver pagos</th>
                        <th>Modificar fecha limite</th>
                        @if (Auth::user()->rol === "administrador")
                        <th>Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @forelse ($facturas as $factura)
                <tr class="tr">
                    <td class="td-menos">{{$factura->id_factura_cliente}}</td>
                    <td class="td-menos">{{$factura->factura_electronica === null ? "Sin factura": $factura->factura_electronica}}</td>
                    <td class="td-texto-center">{{$factura->fecha_factura}}</td>
                    <td class="td-texto-center nombre">{{$factura->nombre_cliente}}</td>
                    <td class="td-texto-center">${{$factura->valor_total === null? 0:number_format($factura->valor_total,0,',','.')}}</td>
                    <td class="td-texto-center debe">${{$factura->debe === null? 0 :number_format($factura->debe,0,',','.')  }}</td>
                    <td class="td-texto-center">${{$factura->pagado === null? 0 :number_format($factura->pagado,0,',','.') }}</td>
                    <td class="fecha_limite">{{$factura->fecha_limite_pago === null? "Sin fecha":$factura->fecha_limite_pago}}</td>
                    <td><a href="{{route('ventas.indexProductos',$factura->id_factura_cliente)}}" class="btn_ver_contenido"><img src="/img/ojo-rojo.png" alt="ojo"></a></td>
                    <td><a href="{{route('ventas.createDescargarFactura', $factura->id_factura_cliente)}}" class="btn_imprimir"><img src="/img/imprimir.png" alt="imprimir"></a></td>
                    <td><a href="{{route('ventas.editAbonarFactura',$factura->id_factura_cliente)}}" class="btn_abonar"><img src="/img/dolar.png" alt="abonar"></a></td>
                    <td><a href="{{route('ventas.indexPagos', $factura->id_factura_cliente)}}" class="btn_ver_pago"><img src="/img/ojo-rojo.png" alt="ojo"></a></td>
                    <td><a href="{{route('ventas.editFechaFactura', $factura->id_factura_cliente)}}" class="btn_fecha"><img src="/img/fecha-limite.png" alt="fecha"></a></td>
                    @if (Auth::user()->rol === "administrador")
                    <td><form class="form_eliminar" action="{{route('ventas.delete', $factura->id_factura_cliente)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla"><img src="/img/basura.png" alt="basura"></button></form></td>
                    @endif
                </tr>
                @empty
                <tr class="tr"></tr> 
                @endforelse
                </tbody>
            </table>
        </div>
        {{$facturas->links()}}
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