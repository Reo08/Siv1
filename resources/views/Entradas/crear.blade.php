@extends('plantilla.plantilla')

@section('titulo', 'Entradas')
@section('links')
    <link rel="stylesheet" href="/css/entradasCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-entrada">
        <a href="{{route('entradas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_aggExistencia" action="{{route('entradas.store')}}" method="POST">
                @csrf
                <legend>Agregar existencia</legend>
                <label for="sec-categoria">Categoria</label>
                <select name="sec_categoria" id="sec-categoria" class="select_categoria" required>
                    <option value="">Seleccione una categoria</option>
                @foreach ($categorias as $categoria)
                    <option value="{{$categoria->id_categoria}}">{{$categoria->nombre_categoria}}</option>
                @endforeach
                </select>
                <label for="sec-producto">Producto</label>
                <select name="sec_producto" id="sec-producto" class="select_producto" required>
                    <option value="">Seleccione un producto</option>
                </select>
                <label for="fecha_entrada">Fecha de ingreso</label>
                <input type="date" name="fecha_entrada" id="fecha_entrada" required value="{{old('fecha_ingreso')}}">
                @error('fecha_entrada')
                    <small>*{{$message}}</small>
                @enderror
                <label for="precio_compra">Precio de compra</label>
                <input type="number" name="precio_compra" id="precio_compra" required value="{{old('precio_compra')}}">
                @error('precio_compra')
                    <small>*{{$message}}</small>
                @enderror
                <label for="precio_venta">Precio de venta</label>
                <input type="number" name="precio_venta" id="precio_venta" required value="{{old('precio_venta')}}">
                @error('precio_venta')
                    <small>*{{$message}}</small>
                @enderror
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" required value="{{old('cantidad')}}">
                @error('cantidad')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('entradas.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/entradas.crear.js"></script>
@endsection