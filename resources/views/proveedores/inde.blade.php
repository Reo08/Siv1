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
        @if (Auth::user()->rol === "administrador")
            <a class="btn-exportar" href="{{route('proveedores.export')}}">Exportar</a>            
        @endif
        
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
                </colgroup>
                <thead>
                    <tr>
                        <th>Nit</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        @if (Auth::user()->rol === "administrador")
                        <th>Editar</th>
                        <th>Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proveedores as $proveedor)
                    <tr class="tr">
                        <td class="td-menos">{{$proveedor->nit_proveedor}}</td>
                        <td class="td-texto-center nombre">{{$proveedor->nombre_proveedor}}</td>
                        <td class="td-texto-center">{{$proveedor->correo_proveedor}}</td>
                        <td class="td-texto-center">{{$proveedor->telefono}}</td>
                        @if (Auth::user()->rol === "administrador")
                        <td class="td-menos"><a href="{{route('proveedores.edit', $proveedor->nit_proveedor)}}" class="btn-editar-tabla"><img src="/img/editar.png" alt="editar"></a></td>
                        <td class="td-menos"><form class="form_eliminar" action="{{route('proveedores.destroy',$proveedor->nit_proveedor)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla"><img src="/img/basura.png" alt="basura"></button></form></td>
                        @endif
                    </tr>
                    @empty
                    <tr class="tr">
                        
                    </tr>
                    @endforelse
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