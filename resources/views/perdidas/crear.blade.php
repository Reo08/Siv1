@extends('plantilla.plantilla')

@section('titulo', 'Perdidas')
@section('links')
    <link rel="stylesheet" href="/css/perdidasCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-venta">
        <a href="{{route('perdidas.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_perdida" action="{{route('perdidas.store')}}" method="POST">
                @csrf
                <legend>Agregar pérdida</legend>
                <label for="sec_categoria">Categoria</label>
                <select name="sec_categoria" id="sec_categoria" class="select_categoria" required>
                    <option value="">Seleccione una categoria</option>
                @foreach ($categorias as $categoria)
                    <option value="{{$categoria->id_categoria}}">{{$categoria->nombre_categoria}}</option>
                @endforeach
                </select>
                @error('sec_categoria')
                    <small>*{{$message}}</small>
                @enderror
                <label for="sec_producto">Producto</label>
                <select name="sec_producto" id="sec_producto" class="select_producto" required>
                    <option value="">Seleccione un producto</option>
                </select>
                @error('sec_producto')
                    <small>*{{$message}}</small>
                @enderror
                <label for="fecha_perdida">Fecha de pérdida</label>
                <input type="date" name="fecha_perdida" id="fecha_perdida" required>
                @error('fecha_perdida')
                    <small>*{{$message}}</small>
                @enderror
                <label for="precio_compra">Precio de compra</label>
                <input type="number" name="precio_compra" class="precio_compra" required>
                @error('precio_compra')
                    <small>*{{$message}}</small>
                @enderror
                <label for="cantidad_perdida">Cantidad</label>
                <input type="number" name="cantidad_perdida" class="cantidad_perdida" required>
                @error('cantidad_perdida')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('perdidas.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/perdidas.crear.js"></script>
@endsection