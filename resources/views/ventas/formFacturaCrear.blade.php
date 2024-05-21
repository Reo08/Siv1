@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/ventasFormFacturaCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-entrada">
        <a href="{{route('ventas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_aggExistencia" action="{{route('ventas.storeDescargarFactura',$id_factura->id_factura_cliente)}}" method="POST">
                @csrf
                <legend>Datos de factura</legend>
                <label for="razon_social">Razón social</label>
                <input type="text" name="razon_social" id="razon_social" required>
                @error('razon_social')
                    <small>*{{$message}}</small>
                @enderror
                <label for="nit_cedula">Nit/cedula</label>
                <input type="number" name="nit_cedula" id="nit_cedula" required>
                @error('nombre_producto')
                    <small>*{{$message}}</small>
                @enderror
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" required>
                @error('direccion')
                    <small>*{{$message}}</small>
                @enderror
                <label for="celular">Celular</label>
                <input type="number" name="celular" id="celular" required value="{{old('celular')}}">
                @error('celular')
                    <small>*{{$message}}</small>
                @enderror
                <label for="codigo_ciuu">Codigo CIUU</label>
                <input type="number" name="codigo_ciuu" id="codigo_ciuu" required value="{{old('codigo_ciuu')}}">
                @error('codigo_ciuu')
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
    {{-- <script src="/js/entradas.crear.js"></script> --}}
@endsection