@extends('plantilla.plantilla')

@section('titulo', 'Clientes')
@section('links')
    <link rel="stylesheet" href="/css/categorias.css">
@endsection
    
@section('contenido')
    
    <section class="sec-categorias">
        <h2>Clientes</h2>
        <div class="cont-categorias">
            <a href="">Nueva categoria</a>
            @if (Auth::user()->rol === "administrador")
            <a class="btn-exportar" href="">Exportar</a>
            @endif
            <input type="text" name="buscar_categorias" class="buscar_categoria" placeholder="Buscar por nombre">
            <div class="cont-tabla-categorias">
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
                            <th>Nit/Cedula</th>
                            <th>Correo</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            @if (Auth::user()->rol === "administrador")
                            <th>Editar</th>
                            <th>Eliminar</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

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