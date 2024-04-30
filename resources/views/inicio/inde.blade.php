@extends('plantilla.plantilla')

@section('titulo', 'Inicio')
@section('links')
    <link rel="stylesheet" href="/css/inicio.css">
@endsection
    
@section('contenido')
    <section class="sec-inicio">
        <a href="{{route('proveedores.index')}}" title="Cantidad de proveedores">Proveedores <span>{{$cantidadProveedores}}</span></a>
        <a href="{{route('productos.index')}}" title="Cantidad de productos">Productos <span>{{$cantidadProductos}}</span></a>
        <a href="{{route('entradas.index')}}" title="Total de la cantidad de productos">Existencia actual <span>{{$totalCantidadEntradas}}</span></a>
        <a href="{{route('ventas.index')}}" title="Total de la cantidad de productos vendidos">Existencia vendida <span>{{$totalCantidadVentas}}</span></a>
        <a href="{{route('ventas.index')}}" title="Cantidad total de dinero recibido por el precio de venta al publico de los productos">Importe vendido <span>${{$totalImporteVendido}}</span></a>
        <a class="importe_pagado" href="{{route('inicio.exportImportes')}}" title="Cantidad total de dinero invertido en los productos">Importe pagado <span>${{$totalImportePagado}}</span></a>
        <a href="{{route('ventas.index')}}" title="Ganancia de importeVendido menos importePagado">Total ventas <span>${{$totalVentas}}</span></a>
        <a class="ganancias" href="{{route('inicio.exportGanancias')}}" title="Ganancias totales, descontando las perdidas">Total ganancias <span>${{$totalGanancias}}</span></a>
        <a href="{{route('perdidas.index')}}" title="Total de perdidas">Total pérdidas <span>${{$totalPerdidas}}</span></a>
    </section>
@endsection

@section('scripts')

@endsection
