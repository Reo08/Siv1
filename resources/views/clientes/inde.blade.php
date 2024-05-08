@extends('plantilla.plantilla')

@section('titulo', 'Clientes')
@section('links')
    <link rel="stylesheet" href="/css/clientes.css">
@endsection
    
@section('contenido')
    
    <section class="sec-clientes">
        <h2>Clientes</h2>
        <div class="cont-clientes">
            <a href="{{route('clientes.create')}}">Agregar cliente</a>
            @if (Auth::user()->rol === "administrador")
            <a class="btn-exportar" href="">Exportar</a>
            @endif
            <input type="text" name="buscar_cliente" class="buscar_cliente" placeholder="Buscar por nombre">
            <div class="cont-tabla-categorias">
                <table>
                    <colgroup>
                        <col class="primeraColumna">
                        <col class="segundaColumna">
                        <col class="terceraColumna">
                        <col class="cuartaColumna">
                        <col class="quintaColumna">
                        <col class="sextaColumna">
                        <col class="septimaColumna">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Nit/Cedula</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            @if (Auth::user()->rol === "administrador")
                            <th>Estado de cuenta</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($clientes as $cliente)
                        <tr class="tr">
                            <td class="td-texto-center">{{$cliente->nit_cedula}}</td>
                            <td class="td-texto-center">{{$cliente->nombre_cliente}}</td>
                            <td class="td-texto-center">{{$cliente->correo}}</td>
                            <td class="td-texto-center">{{$cliente->telefono}}</td>
                            <td><a href="" class="btn-ver-estado">Ver</a></td>
                            <td><a href="{{route('clientes.edit', $cliente->nit_cedula)}}" class="btn-editar-tabla">Editar</a></td>
                            <td><form class="form_eliminar" action="{{route('clientes.destroy',$cliente->nit_cedula)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla">Eliminar</button></form></td>
                        </tr>
                    @empty
                        <tr class="tr"></tr>
                    @endforelse
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