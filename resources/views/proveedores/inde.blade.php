@extends('plantilla.plantilla')

@section('titulo', 'Proveedores')
@section('links')
    <link rel="stylesheet" href="/css/proveedores.css">
@endsection

@section('contenido')
<section class="sec-proveedores">
    <h2>Lista de proveedores</h2>
    <div class="cont-proveedores">
        <a href="{{route('proveedores.create')}}">Agregar Proveedor</a>
        <a class="btn-exportar" href="{{route('proveedores.export')}}">Exportar</a>
        <input type="text" name="buscar_nombre" class="buscar_nombre" placeholder="Buscar por nombre">
        <div class="cont-tabla-proveedores">
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
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                    <tr class="tr">
                        <td class="td-menos">{{$proveedor->id_proveedor}}</td>
                        <td class="td-texto-center nombre">{{$proveedor->nombre_proveedor}}</td>
                        <td class="td-texto-center">{{$proveedor->correo_proveedor}}</td>
                        <td class="td-texto-center">{{$proveedor->telefono_proveedor}}</td>
                        <td class="td-texto-center">{{$proveedor->direccion_proveedor}}</td>
                        <td><a href="{{route('proveedores.edit', $proveedor->id_proveedor)}}" class="btn-editar-tabla">Editar</a></td>
                        <td><form class="form_eliminar" action="{{route('proveedores.destroy',$proveedor->id_proveedor)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla">Eliminar</button></form></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$proveedores->links()}}
    </div>
</section>
@if (session('alert'))
    <script>
        alert("{{session('alert')}}")
    </script>
@endif
@endsection

@section('scripts')
    <script src="/js/proveedores.inde.js"></script>
@endsection