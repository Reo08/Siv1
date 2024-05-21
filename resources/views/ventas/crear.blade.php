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
                <select name="selec_cliente" class="selec_cliente" required>
                    <option value="">Seleccione cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{$cliente->nit_cedula}}">{{$cliente->nombre_cliente}}</option>
                @endforeach
                </select>
                <label for="">¿Factura electronica?</label>
                <div class="cont_radio_imput">
                    <label for="no_factura" class="label_no_factura"><input type="radio" name="factura_electronica" value="no" id="no_factura" checked>No</label>
                    <label for="si_factura" class="label_si_factura"><input type="radio" name="factura_electronica" value="si" id="si_factura">Si</label>
                </div>
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
    <script src="/js/ventas.crear.js"></script>
@endsection