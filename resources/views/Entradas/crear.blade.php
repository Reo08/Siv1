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
                <label for="referencia">N° de referencia</label>
                <input type="text" name="referencia" id="referencia" required>
                @error('referencia')
                    <small>*{{$message}}</small>
                @enderror
                <label for="nombre_producto">Nombre producto</label>
                <input type="text" name="nombre_producto" id="nombre_producto" required>
                @error('nombre_producto')
                    <small>*{{$message}}</small>
                @enderror
                <label for="sec-categoria">Categoria</label>
                <select name="sec_categoria" id="sec-categoria" class="select_categoria" required>
                    <option value="">Seleccione una categoria</option>
                @foreach ($categorias as $categoria)
                    <option value="{{$categoria->id_categoria}}">{{$categoria->nombre_categoria}}</option>
                @endforeach
                </select>
                <label for="descripcion_producto">Descripcion producto</label>
                <input type="text" name="descripcion_producto" id="descripcion_producto" required>
                <label for="fecha_entrada">Fecha de ingreso</label>
                <input type="date" name="fecha_entrada" id="fecha_entrada" required value="{{old('fecha_ingreso')}}">
                @error('fecha_entrada')
                    <small>*{{$message}}</small>
                @enderror
                <label for="costo_inversion">Costo de inversion</label>
                <input type="number" name="costo_inversion" id="costo_inversion" required value="{{old('costo_inversion')}}">
                @error('costo_inversion')
                    <small>*{{$message}}</small>
                @enderror
                <label for="precio_venta_distribuidor">Precio de venta a distribuidor</label>
                <input type="number" name="precio_venta_distribuidor" id="precio_venta_distribuidor" required value="{{old('precio_venta_distribuidor')}}">
                @error('precio_venta_distribuidor')
                    <small>*{{$message}}</small>
                @enderror
                <label for="cantidad_entrada">Cantidad</label>
                <input type="number" name="cantidad_entrada" id="cantidad_entrada" required value="{{old('cantidad_entrada')}}">
                @error('cantidad_entrada')
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
    {{-- <script src="/js/entradas.crear.js"></script> --}}
@endsection