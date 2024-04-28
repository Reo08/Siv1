@extends('plantilla.plantilla')

@section('titulo','Usuarios')
@section('links')
    <link rel="stylesheet" href="/css/usuariosCrear.css">
@endsection

@section('contenido')
    <section class="sec-crear-usuario">
        <a href="{{route('usuarios.index')}}" class="btn-atras">Atras</a>
        <div class="cont-form">
            <form class="form_crear_usuario" action="{{route('usuarios.store')}}" method="POST">
                @csrf
                <legend>Agregar usuario</legend>
                <label for="rol">Rol</label>
                <select name="rol" id="rol">
                    <option value="">Seleccione una opcion</option>
                    <option value="1">Administrador</option>
                    <option value="0">Empleado</option>
                </select>
                @error('rol')
                    <small>*{{$message}}</small>
                @enderror
                <label for="nombre">Nombre completo</label>
                <input type="text" name="nombre" id="nombre" value="{{old('nombre')}}" required>
                @error('nombre')
                    <small>*{{$message}}</small>
                @enderror
                <label for="identificacion">Identificación</label>
                <input type="text" name="identificacion" id="identificacion" value="{{old('identificacion')}}" required>
                @error('identificacion')
                    <small>*{{$message}}</small>
                @enderror
                <label for="correo">Correo</label>
                <input type="email" name="correo" id="correo" value="{{old('correo')}}" required>
                @error('correo')
                    <small>*{{$message}}</small>
                @enderror
                <label for="">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" required>
                @error('contrasena')
                    <small>*{{$message}}</small>
                @enderror
                <div class="cont-btns">
                    <button>Guardar</button>
                    <a href="{{route('usuarios.index')}}">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    
@endsection