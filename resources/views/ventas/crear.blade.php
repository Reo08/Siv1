@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventasCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-venta">
        <a href="{{route('ventas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_venta" action="{{route('ventas.store')}}" method="POST">
                @csrf
                <legend>Agregar venta</legend>
                <label for="sec_categoria">Categoria</label>
                <select name="sec_categoria" id="sec_categoria" class="select_categoria" required>
                    <option value="">Seleccione una categoria</option>
                @foreach ($categorias as $categoria)
                    <option value="{{$categoria->id_categoria}}">{{$categoria->nombre_categoria}}</option>
                @endforeach
                </select>
                @error('sec_categoria')
                    <small>*{{$message}}</small>
                @enderror
                <label for="sec_producto">Producto</label>
                <select name="sec_producto" id="sec_producto" class="select_producto" required>
                    <option value="">Seleccione un producto</option>
                </select>
                @error('sec_producto')
                    <small>*{{$message}}</small>
                @enderror
                <label for="fecha_venta">Fecha de venta</label>
                <input type="date" name="fecha_venta" id="fecha_venta" required>
                @error('fecha_venta')
                    <small>*{{$message}}</small>
                @enderror
                <label for="precio_venta">Precio de venta</label>
                <input type="number" name="precio_venta"  class="precio_venta" required>
                @error('precio_venta')
                    <small>*{{$message}}</small>
                @enderror
                <label for="cantidad_venta">Cantidad</label>
                <input type="number" name="cantidad_venta" class="cantidad_venta" required>
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