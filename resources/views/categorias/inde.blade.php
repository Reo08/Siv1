@extends('plantilla.plantilla')

@section('titulo', 'Categorias')
@section('links')
    <link rel="stylesheet" href="/css/categorias.css">
@endsection
    
@section('contenido')
    
    <section class="sec-categorias">
        <h2>Lista de categorias</h2>
        <div class="cont-categorias">
            <a href="{{route('categorias.create')}}">Nueva categoria</a>
            @if (Auth::user()->rol === "administrador")
            <a class="btn-exportar" href="{{route('categorias.export')}}">Exportar</a>
            @endif
            <input type="text" name="buscar_categorias" class="buscar_categoria" placeholder="Buscar por nombre">
            <div class="cont-tabla-categorias">
                <table>
                    <colgroup>
                        <col class="primeraColumna">
                        <col class="segundaColumna">
                        <col class="terceraColumna">
                        <col class="cuartaColumna">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            @if (Auth::user()->rol === "administrador")
                            <th>Editar</th>
                            <th>Eliminar</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categorias as $categoria)
                        <tr class="tr">
                            <td>{{$categoria->id_categoria}}</td>
                            <td class="td-texto-center nombre">{{$categoria->nombre_categoria}}</td>
                            @if (Auth::user()->rol === "administrador")
                            <td><a href="{{route('categorias.edit', $categoria->id_categoria)}}" class="btn-editar-tabla">Editar</a></td>
                            <td><form class="form_eliminar" action="{{route('categorias.delete', $categoria->id_categoria)}}" method="POST">@csrf @method('delete')<button class="btn-eliminar-tabla">Eliminar</button></form></td>
                            @endif
                        </tr>
                        @empty
                        <tr class="tr">
                            
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{$categorias->links()}}
        </div>
    </section>
@if (session('alert'))
    <script>
        alert("{{session('alert')}}")
    </script>
@endif

@endsection

@section('scripts')
<script src="/js/categorias.inde.js"></script>
@endsection