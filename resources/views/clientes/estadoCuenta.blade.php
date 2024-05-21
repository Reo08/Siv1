@extends('plantilla.plantilla')

@section('titulo', 'Clientes')
@section('links')
    <link rel="stylesheet" href="/css/clientesEstadoCuenta.css">
@endsection

@section('contenido')
<section class="sec-ventas">
    <a href="{{route('clientes.index')}}" class="btn-atras">Atras</a>

    <div class="cont-ventas">
        <h2>Estado de cuenta {{$nit->nombre_cliente}}</h2>
        <div class="cont_tabla_dos">
            <table>
                <thead>
                    <tr>
                        <th>Vr. total</th>
                        <th>Retención total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr">
                        <td>${{number_format($vrTotal,0,',','.')}}</td>
                        <td>${{number_format($retencionTotal,0,',','.')}}</td>
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
                    <col class="quintaColumna">
                    <col class="sextaColumna">
                </colgroup>
                <thead>
                    <tr>
                        <th>ID Factura</th>
                        <th>Fecha factura</th>
                        <th>FV</th>
                        <th>Valor total</th>
                        <th>Retención</th>
                        <th>Valor a pagar</th>
                        <th>Ver contenido factura</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($facturas as $factura)
                        <tr class="tr">
                            <td class="td-menos">{{$factura->id_factura_cliente}}</td>
                            <td class="td-texto-center">{{$factura->fecha_factura}}</td>
                            <td class="td-texto-center">{{$factura->factura_electronica === null ? "Sin factura" : $factura->factura_electronica}}</td>
                            <td class="td-texto-center">${{$factura->valor_total_sin_iva ===null ? 0 : number_format($factura->valor_total_sin_iva,0,',','.')}}</td>
                            <td class="td-texto-center">${{$factura->porcentaje_retencion === null ? 0 :number_format($factura->porcentaje_retencion,0,',','.') }}</td>
                            <td class="td-texto-center">${{number_format($factura->valor_total_sin_iva - $factura->porcentaje_retencion,0,',','.')}}</td>
                            <td class="td-menos"><a href="{{route('ventas.indexProductos',$factura->id_factura_cliente)}}" class="btn_ver_contenido"><img src="/img/ojo-rojo.png" alt="ojo"></a></td>
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