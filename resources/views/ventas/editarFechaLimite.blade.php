@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/editarAbonarFactura.css">
@endsection

@section('contenido')
    <section class="sec-crear-entrada">
        <a href="{{route('ventas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_editarCantidad" action="{{route('ventas.updateFechaFactura',$id_factura->id_factura_cliente)}}" method="POST">
                @csrf
                @method('put')
                <legend>Modificar fecha limite de {{$cliente->nombre_cliente}}</legend>
                <label for="">Debe: ${{$id_factura->debe === null ? 0 :$id_factura->debe}}</label>
                <label for="fecha_limite_pago">Fecha limite de pago</label>
                <input type="date" name="fecha_limite_pago" required value="{{old('fecha_limite_pago',$id_factura->fecha_limite_pago)}}">
                @error('fecha_pago')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('ventas.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
    @if (session('alert'))
        <script>
            alert("{{session('alert')}}")
        </script>
    @endif
@endsection

@section('scripts')
    
@endsection