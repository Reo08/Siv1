@extends('plantilla.plantilla')

@section('titulo', 'Entradas')
@section('links')
    <link rel="stylesheet" href="/css/perdidasPorPagoCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-entrada">
        <a href="{{route('perdidas.porDano')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_editarCantidad" action="{{route('perdidas.porPagoStore')}}" method="POST">
                @csrf
                <legend>Agregar perdida por falta de pago</legend>
                <label for="cantidad_perdida">Ingrese ID de la factura</label>
                <input type="number" name="id_factura" id="id_factura" required value="{{old('id_factura')}}">
                @error('cantidad_entrada')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('perdidas.porPago')}}">Cancelar</a>
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