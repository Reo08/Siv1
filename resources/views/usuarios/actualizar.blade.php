@extends('plantilla.plantilla')

@section('titulo','Usuarios')
@section('links')
    <link rel="stylesheet" href="/css/usuariosCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-usuario">
        <a href="{{route('usuarios.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_crear_usuario" action="{{route('usuarios.update', $usuario->id_usuario)}}" method="POST">
                @csrf
                @method('put')
                <legend>Actualizar usuario de {{$usuario->nombre}}</legend>
                <label for="rol">Rol</label>
                <select name="rol" id="rol">
                    <option value="{{$usuario->rol === "administrador" ? "1": "0"}}">{{$usuario->rol}}</option>
                    <option value="1">Administrador</option>
                    <option value="0">Empleado</option>
                </select>
                @error('rol')
                    <small>*{{$message}}</small>
                @enderror
                <label for="nombre">Nombre completo</label>
                <input type="text" name="nombre" id="nombre" value="{{old('nombre',$usuario->nombre)}}" required>
                @error('nombre')
                    <small>*{{$message}}</small>
                @enderror
                <label for="correo">Correo</label>
                <input type="email" name="correo" id="correo" value="{{old('correo',$usuario->correo)}}" required>
                @error('correo')
                    <small>*{{$message}}</small>
                @enderror
                <label for="contrasena1">Nueva contraseña</label>
                <input type="password" name="contrasena1" id="contrasena1">
                <label for="contrasena2">Confirmar contraseña</label>
                <input type="password" name="contrasena2" id="contrasena2">
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('usuarios.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/usuarios.actualizar.js"></script>
@endsection