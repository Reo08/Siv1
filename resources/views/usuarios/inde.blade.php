@extends('plantilla.plantilla')

@section('titulo', 'Usuarios')
@section('links')
    <link rel="stylesheet" href="/css/usuarios.css">
@endsection

@section('contenido')
<section class="sec-usuarios">
    <h2>Usuarios</h2>
    <div class="cont-usuarios">
        <a href="{{route('usuarios.create')}}">Agregar usuario</a>
        <div class="cont-inputs">
            <input type="text" name="buscar_nombre" placeholder="Buscar por nombre">
            <input type="text" name="buscar_correo" placeholder="Buscar por correo">
        </div>
        <div class="cont-tabla-usuarios">
            <table>
                <colgroup>
                    <col class="primeraColumna">
                    <col class="segundaColumna">
                    <col class="terceraColumna">
                    <col class="cuartaColumna">
                    <col class="quintaColumna">
                    <col class="sextaColumna">
                </colgroup>
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($usuarios as $usuario)
                    <tr class="tr">
                        <td class="td-texto-center">{{$usuario->identificacion}}</td>
                        <td class="td-texto-center">{{$usuario->nombre}}</td>
                        <td class="td-texto-center">{{$usuario->correo}}</td>
                        <td class="td-texto-center">{{$usuario->rol}}</td>
                        <td><a href="{{route('usuarios.edit',$usuario->identificacion)}}" class="btn-editar-tabla">Editar</a></td>
                        <td><form class="form_eliminar" action="{{route('usuarios.delete', $usuario->identificacion)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla">Eliminar</button></form></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$usuarios->links()}}
    </div>
</section>
@if (session('alert'))
    <script>
        alert("{{session('alert')}}")
    </script>
@endif
@endsection

@section('scripts')
    <script src="/js/usuarios.inde.js"></script>
@endsection