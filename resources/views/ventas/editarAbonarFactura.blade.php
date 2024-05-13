@extends('plantilla.plantilla')

@section('titulo', 'Ventas')
@section('links')
    <link rel="stylesheet" href="/css/editarAbonarFactura.css">
@endsection

@section('contenido')
    <section class="sec-crear-entrada">
        <a href="{{route('ventas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_editarCantidad" action="{{route('ventas.updateAbonarFactura',$id_factura->id_factura_cliente)}}" method="POST">
                @csrf
                @method('put')
                <legend>Pago factura N°{{$id_factura->id_factura_cliente}} de {{$cliente->nombre_cliente}}</legend>
                <label for="">Debe: ${{$id_factura->debe === null ? 0 :$id_factura->debe}}</label>
                <label for="">Fecha de pago</label>
                <input type="date" name="fecha_pago" required>
                @error('fecha_pago')
                    <small>*{{$message}}</small>
                @enderror
                <label for="pagado">Cantidad</label>
                <input type="number" name="pagado" id="pagado" required value="{{old('pagado')}}">
                @error('pagado')
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