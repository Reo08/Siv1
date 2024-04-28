@extends('plantilla.plantilla')

@section('titulo', 'Entradas')
@section('links')
    <link rel="stylesheet" href="/css/entradasCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-entrada">
        <a href="{{route('entradas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_aggExistencia" action="{{route('entradas.update', $entradas->id_entrada)}}" method="POST">
                @csrf
                @method('put')
                <legend>Actualizar existencia de {{$entradas->nombre_producto}}</legend>
                <input type="hidden" name="id_producto" value="{{old('id_producto', $entradas->id_producto)}}">
                <label for="fecha_entrada">Fecha de ingreso</label>
                <input type="date" name="fecha_entrada" id="fecha_entrada" required value="{{old('fecha_entrada', $entradas->fecha_entrada)}}">
                @error('fecha_entrada')
                    <small>*{{$message}}</small>
                @enderror
                <label for="precio_compra">Precio de compra</label>
                <input type="number" name="precio_compra" id="precio_compra" required value="{{old('precio_compra', $entradas->precio_compra_entrada)}}">
                @error('precio_compra')
                    <small>*{{$message}}</small>
                @enderror
                <label for="precio_venta">Precio de venta</label>
                <input type="number" name="precio_venta" id="precio_venta" required value="{{old('precio_venta', $entradas->precio_venta_entrada)}}">
                @error('precio_venta')
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