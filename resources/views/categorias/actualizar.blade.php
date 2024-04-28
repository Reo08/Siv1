@extends('plantilla.plantilla')

@section('titulo', 'Categorias')
@section('links')
    <link rel="stylesheet" href="/css/categoriasCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-categoria">
        <a href="{{route('categorias.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_categoria" action="{{route('categorias.update', $id)}}" method="POST">
                @csrf
                @method('put')
                <legend>Actualizar Categoria</legend>
                <label for="nombre_categoria">Nombre de categoria</label>
                <input type="text" name="nombre_categoria" id="nombre_categoria" value="{{old('nombre_categoria', $id->nombre_categoria)}}" >
                @error('nombre_categoria')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('categorias.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    
@endsection