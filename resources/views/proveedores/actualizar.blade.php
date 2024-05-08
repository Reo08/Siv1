@extends('plantilla.plantilla')

@section('titulo', 'Proveedores')
@section('links')
    <link rel="stylesheet" href="/css/proveedoresCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-proveedor">
        <a href="{{route('proveedores.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_proveedor" action="{{route('proveedores.update', $id->nit_proveedor)}}" method="POST">
                @csrf
                @method('put')
                <legend>Actualizar Proveedor</legend>
                <label for="">Nit</label>
                <input type="text" name="nit_proveedor" id="nit_proveedor" value="{{old('nit_proveedor', $id->nit_proveedor)}}">
                @error('nit_proveedor')
                    <small>*{{$message}}</small>
                @enderror
                <label for="nombre_proveedor">Nombre proveedor</label>
                <input type="text" name="nombre_proveedor" id="nombre_proveedor" required value="{{old('nombre_proveedor',$id->nombre_proveedor)}}">
                @error('nombre_proveedor')
                    <small>*{{$message}}</small>
                @enderror
                <label for="correo_proveedor">Correo electronico</label>
                <input type="email" name="correo_proveedor" id="correo_proveedor" required value="{{old('correo_proveedor', $id->correo_proveedor)}}">
                @error('correo_proveedor')
                    <small>*{{$message}}</small>
                @enderror
                <label for="telefono_proveedor">Telefono</label>
                <input type="number" name="telefono_proveedor" id="telefono_proveedor" required value="{{old('telefono_proveedor', $id->telefono)}}">
                @error('telefono_proveedor')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('proveedores.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    
@endsection