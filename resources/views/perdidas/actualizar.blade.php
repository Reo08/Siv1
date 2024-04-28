@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/perdidasCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-venta">
        <a href="{{route('perdidas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form action="">
                <legend>Actualizar pérdida</legend>
                <select name="sec-categoria" id="sec-categoria">
                    <option value="">Seleccione una categoria</option>
                </select>
                <select name="sec-producto" id="sec-producto">
                    <option value="">Seleccione un producto</option>
                </select>
                <select name="sec-proveedor" id="sec-porveedor">
                    <option value="">Seleccione un proveedor</option>
                </select>
                <input type="date" name="nombre_producto" id="nombre_proveedor" required>
                <label for="precio_compra">Precio de compra</label>
                <input type="number" name="precio_compra" id="precio_compra" required>
                <label for="cantidad_perdida">Cantidad</label>
                <input type="number" name="cantidad_perdida" id="cantidad_perdida" required>
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('perdidas.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    
@endsection