@extends('plantilla.plantilla')

@section('titulo', 'Categorias')
@section('links')
    <link rel="stylesheet" href="/css/configuracionesEdit.css">
@endsection

@section('contenido')
    <section class="sec-crear-categoria">
        <div class="cont-form">
            <form class="form_contrasena" action="{{route('configuraciones.update', Auth::user()->id_usuario)}}" method="POST">
                @csrf
                @method('put')
                <legend>Cambiar contraseña</legend>
                <label for="contrasena_nueva1">Contraseña nueva</label>
                <input type="password" name="contrasena_nueva1" id="contrasena_nueva1" required>
                @error('contrasena_nueva1')
                    <small>*{{$message}}</small>
                @enderror
                <label for="contrasena_nueva2">Confirmar contraseña</label>
                <input type="password" name="contrasena_nueva2" id="contrasena_nueva2" required>
                @error('contrasena_nueva2')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('inicio.index')}}">Cancelar</a>
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
    <script src="/js/configuraciones.edit.js"></script>
@endsection