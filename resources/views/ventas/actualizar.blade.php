@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventasCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-venta">
        <a href="{{route('ventas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form" action="{{route('ventas.update', $ventas->id_salida_venta)}}" method="POST">
                @csrf
                @method('put')
                <legend>Actualizar venta de {{$ventas->nombre_producto}}</legend>
                {{-- <select name="sec_categoria" id="sec_categoria" class="select_categoria" required>
                    <option value="{{$ventas->id_categoria}}">{{$ventas->nombre_categoria}}</option>
                @foreach ($categorias as $categoria)
                    <option value="{{$categoria->id_categoria}}">{{$categoria->nombre_categoria}}</option>
                @endforeach
                </select>
                @error('sec_categoria')
                    <small>*{{$message}}</small>
                @enderror
                <select name="sec_producto" id="sec_producto" class="select_producto" required>
                    <option value="{{$ventas->id_producto}}">{{$ventas->nombre_producto}}</option>
                </select>
                @error('sec_producto')
                    <small>*{{$message}}</small>
                @enderror
                <select name="sec_proveedor" id="sec_porveedor" class="select_proveedor" required>
                    <option value="{{$ventas->id_proveedor}}">{{$ventas->nombre_proveedor}}</option>
                </select>
                @error('sec_proveedor')
                    <small>*{{$message}}</small>
                @enderror --}}
                <input type="hidden" name="id_producto" value="{{old('id_producto', $ventas->id_producto)}}">
                <input type="date" name="fecha_venta" id="fecha_venta" value="{{old('fecha_venta', $ventas->fecha_venta)}}" required>
                @error('fecha_venta')
                    <small>*{{$message}}</small>
                @enderror
                <label for="precio_venta">Precio de venta</label>
                <input type="number" name="precio_venta" class="precio_venta" value="{{old('precio_venta', $ventas->precio_venta)}}" required>
                @error('precio_venta')
                    <small>*{{$message}}</small>
                @enderror
                <label for="cantidad_venta">Cantidad</label>
                <input type="number" name="cantidad_venta" class="cantidad_venta" value="{{old('cantidad_venta', $ventas->cantidad)}}" required>
                @error('cantidad_venta')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('ventas.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/ventas.crear.js"></script>
@endsection