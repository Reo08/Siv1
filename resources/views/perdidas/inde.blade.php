@extends('plantilla.plantilla')

@section('titulo', 'Perdidas')
@section('links')
    <link rel="stylesheet" href="/css/perdidas.css">
@endsection

@section('contenido')
<section class="sec-perdidas">
    <h2>Lista de pérdidas</h2>
    <div class="cont-perdidas">
       <ul>
            <li><a href="{{route('perdidas.porDano')}}">Perdidas por daño o devolución</a></li>
            <li><a href="{{route('perdidas.porPago')}}">Perdidas por falta de pago</a></li>
       </ul>
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