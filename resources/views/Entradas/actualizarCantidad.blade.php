@extends('plantilla.plantilla')

@section('titulo', 'Entradas')
@section('links')
    <link rel="stylesheet" href="/css/entradasActualizarCantidad.css">
@endsection

@section('contenido')
    <section class="sec-crear-entrada">
        <a href="{{route('entradas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_editarCantidad" action="{{route('entradas.update.cantidad', $entradas->id_entrada)}}" method="POST">
                @csrf
                @method('put')
                <legend>Actualizar cantidad de {{$entradas->nombre_producto}}</legend>
                <select name="sec_operacion" id="sec_operacion" required>
                    <option value="">Seleccione una accion</option>
                    <option value="1">Sumar</option>
                    <option value="0">Restar</option>
                </select>
                @error('sec_adicion')
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
    
@endsection