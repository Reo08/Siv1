@extends('plantilla.plantilla')

@section('titulo', 'Inicio')
@section('links')
    <link rel="stylesheet" href="/css/inicio.css">
@endsection
    
@section('contenido')
    <section class="sec-inicio">
        <a href="{{route('clientes.index')}}" title="Cantidad de clientes">Clientes <span>{{$cantidadClientes}}</span></a>
        <a href="{{route('proveedores.index')}}" title="Cantidad de proveedores">Proveedores <span>{{$cantidadProveedores}}</span></a>
        <a href="{{route('entradas.index')}}" title="Cantidad de productos">Productos <span>{{$cantidadProductos}}</span></a>
        <a href="{{route('ventas.index')}}" title="Cantidad de facturas">Facturas <span>{{$cantidadFacturas}}</span></a>
        <a href="{{route('entradas.index')}}" title="Total de la cantidad de productos">Existencia actual <span>{{$totalCantidadEntradas}}</span></a>
        <a href="{{route('ventas.index')}}" title="Total de la cantidad de productos entregados al cliente">Existencia vendida <span>{{$totalCantidadVentas}}</span></a>
        <a href="{{route('ventas.index')}}" title="Cantidad total de dinero de las facturas">Importe vendido <span>${{number_format($totalImporteVendido, 0, ',', '.')}}</span></a>
        <a href="" title="Cantidad total de dinero invertido en los productos">Importe pagado <span>${{number_format($totalImportePagado,0,',','.')}}</span></a>
        <a href="" title="Cantidad total de dinero que falta por cobrar">Total saldos <span>${{number_format($totalSaldos,0,',','.')}}</span></a>
        <a href="{{route('ventas.index')}}" title="Ganancia de importeVendido menos importePagado">Pérdidas por pago <span>${{number_format($totalPerdidasPorPago,0,',','.')}}</span></a>
        <a href="{{route('perdidas.index')}}" title="Total de perdidas">Pérdidas por daño<span>${{number_format($totalPerdidasPorDano,0,',','.')}}</span></a>
        <a href="" title="Importe vendido menos total saldos">Ganancias <span>${{number_format($totalGanancias,0,',','.')}}</span></a>
    </section>
@endsection

@section('scripts')

@endsection
