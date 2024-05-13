@extends('plantilla.plantilla')

@section('titulo', 'Productos')
@section('links')
    <link rel="stylesheet" href="/css/ventasCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-factura">
        <a href="{{route('ventas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_aggFactura" action="{{route('ventas.store')}}" method="POST">
                @csrf
                <legend>Agregar factura</legend>
                <label for="">N° de factura</label>
                <input type="number" name="id_factura" required value="{{old('id_factura')}}">
                <label for="">Fecha de factura</label>
                <input type="date" name="fecha_factura" required value="{{old('fecha_factura')}}">
                <select name="selec_cliente" required>
                    <option value="">Seleccione cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{$cliente->nit_cedula}}">{{$cliente->nombre_cliente}}</option>
                @endforeach
                </select>
                <label for="">Fecha limite de pago</label>
                <input type="date" name="fecha_limite_pago" required value="{{old('fecha_limite_pago')}}">
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('ventas.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    
@endsection