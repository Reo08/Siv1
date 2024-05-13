@extends('plantilla.plantilla')

@section('titulo', 'Clientes')
@section('links')
    <link rel="stylesheet" href="/css/entradasCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-entrada">
        <a href="{{route('clientes.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_aggExistencia" action="{{route('clientes.store')}}" method="POST">
                @csrf
                <legend>Agregar cliente</legend>
                <label for="nit_cedula">Nit o cedula</label>
                <input type="number" name="nit_cedula" id="nit_cedula" required value="{{old('nit_cedula')}}">
                @error('nit_cedula')
                    <small>*{{$message}}</small>
                @enderror
                <label for="nombre_cliente">Nombre</label>
                <input type="text" name="nombre_cliente" id="nombre_cliente" required value="{{old('nombre_cliente')}}">
                @error('precio_compra')
                    <small>*{{$message}}</small>
                @enderror
                <label for="correo_cliente">Correo</label>
                <input type="email" name="correo_cliente" id="correo_cliente" required value="{{old('correo_cliente')}}">
                @error('correo_cliente')
                    <small>*{{$message}}</small>
                @enderror
                <label for="telefono">Telefono</label>
                <input type="number" name="telefono" id="telefono" required value="{{old('telefono')}}">
                @error('telefono')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('clientes.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')

@endsection