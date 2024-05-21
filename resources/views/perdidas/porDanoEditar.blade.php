@extends('plantilla.plantilla')

@section('titulo', 'Entradas')
@section('links')
    <link rel="stylesheet" href="/css/perdidasPorDanoEditar.css">
@endsection

@section('contenido')
    <section class="sec-crear-entrada">
        <a href="{{route('perdidas.porDano')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_editarCantidad" action="{{route('perdidas.porDanoupdate',$id_perdida->id_salida_perdida)}}" method="POST">
                @csrf
                @method('put')
                <legend>Actualizar pérdida de {{$producto->nombre_producto}}</legend>
                <select name="sec_operacion" id="sec_operacion" required>
                    <option value="">Seleccione una accion</option>
                    <option value="1">Sumar</option>
                    <option value="0">Restar</option>
                </select>
                @error('sec_adicion')
                    <small>*{{$message}}</small>
                @enderror
                <label for="cantidad_perdida">Cantidad</label>
                <input type="number" name="cantidad_perdida" id="cantidad_perdida" required value="{{old('cantidad_entrada')}}">
                @error('cantidad_entrada')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('perdidas.porDano')}}">Cancelar</a>
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