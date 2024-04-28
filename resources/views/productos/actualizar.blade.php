@extends('plantilla.plantilla')

@section('titulo', 'Productos')
@section('links')
    <link rel="stylesheet" href="/css/productosCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-producto">
        <a href="{{route('productos.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_aggProducto" action="{{route('productos.update', $id->id_producto)}}" method="POST">
                @csrf
                @method('put')
                <legend>Actualizar producto</legend>
                <label for="select_categoria">Categoria</label>
                <select name="select_categoria" id="select_categoria" required>
                    <option value="{{$cat->id_categoria}}">{{$cat->nombre_categoria}}</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{$categoria->id_categoria}}">{{$categoria->nombre_categoria}}</option>
                    @endforeach
                </select>
                @error('select_categoria')
                    <small>*{{$message}}</small>
                @enderror
                <label for="select_proveedor">Proveedor</label>
                <select name="select_proveedor" id="select_proveedor" required>
                    <option value="{{$pro->id_proveedor}}">{{$pro->nombre_proveedor}}</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{$proveedor->id_proveedor}}">{{$proveedor->nombre_proveedor}}</option>
                    @endforeach
                </select>
                @error('select_proveedor')
                    <small>*{{$message}}</small>
                @enderror
                <label for="nombre_categoria">Nombre del producto</label>
                <input type="text" name="nombre_producto" id="nombre_producto" required value="{{old('nombre_producto', $id->nombre_producto)}}">
                @error('nombre_producto')
                    <small>*{{$message}}</small>
                @enderror
                <label for="detalles_producto">Detalles</label>
                <input type="text" name="detalles_producto" id="detalles_producto" required value="{{old('detalles_producto', $id->detalles_producto)}}">
                @error('detalles_producto')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('productos.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    
@endsection