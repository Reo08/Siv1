<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem de inventarios - @yield('titulo')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Kannada:wght@100..800&display=swap" rel="stylesheet">
    @yield('links')
    <link rel="stylesheet" href="/css/plantilla.css">
    @vite("resources/css/app.css")
</head>
<body class="body">
    <section class="sec-nav">
        <div class="info-perfil">
            <h3>{{Auth::user()->nombre}}</h3>
            <p>{{Auth::user()->correo}}</p>
        </div>
        <div class="nav">
            <a href="{{route('inicio.index')}}" class="{{request()->routeIs('inicio.*')?'active': ''}}"><img src="/img/icono_inicio.png" alt="icono_inicio"> Inicio</a>
            <div class="nav-item {{ request()->routeIs('proveedores.*', 'categorias.*', 'productos.*') ? 'active' : '' }} "><img src="/img/icono_gestion-de-productos.png" alt=""> Gestion de productos <span class="{{ request()->routeIs('proveedores.*', 'categorias.*', 'productos.*') ? '' : 'desactive' }} nav-span" ><</span></div>
            <div class="nav-item-cont {{ request()->routeIs('proveedores.*', 'categorias.*', 'productos.*') ? '' : 'desactive' }}" >
                <a href="{{route('proveedores.index')}}" class="{{request()->routeIs('proveedores.*')?'active': ''}}">Proveedores</a>
                <a href="{{route('categorias.index')}}"class="{{request()->routeIs('categorias.*')?'active':''}}">Categorias</a>
                <a href="{{route('productos.index')}}"class="{{request()->routeIs('productos.*')?'active':''}}">Productos</a>
            </div>
            <div class="nav-item {{ request()->routeIs('entradas.*', 'ventas.*', 'perdidas.*') ? 'active' : '' }}" ><img src="/img/icono_gestion-de-existencias.png" alt=""> Gestion de existencias <span class="{{ request()->routeIs('entradas.*', 'ventas.*', 'perdidas.*') ? '' : 'desactive' }} nav-span" ><</span></div>
            <div class="nav-item-cont {{ request()->routeIs('entradas.*', 'ventas.*', 'perdidas.*') ? '' : 'desactive' }}" >
                <a href="{{route('entradas.index')}}" class="{{request()->routeIs('entradas.*')?'active': ''}}">Entradas</a>
                <a href="{{route('ventas.index')}}" class="{{request()->routeIs('ventas.*')?'active': ''}}">Ventas</a>
                <a href="{{route('perdidas.index')}}" class="{{request()->routeIs('perdidas.*')?'active': ''}}">Pérdidas</a>
            </div>
            @if (Auth::user()->rol === "administrador")
            <div class="nav-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" ><img src="/img/icono_gestion-de-usuarios.png" alt=""> Gestion de usuarios <span class="{{ request()->routeIs('usuarios.*') ? '' : 'desactive' }} nav-span" ><</span></div>
            <div class="nav-item-cont {{ request()->routeIs('usuarios.*') ? '' : 'desactive' }}" >
                <a href="{{route('usuarios.index')}}" class="{{request()->routeIs('usuarios.*')?'active': ''}}">usuarios</a>
            </div> 
            @endif
            <div class="nav-item {{ request()->routeIs('configuraciones.*') ? 'active' : '' }}" ><img src="/img/icono_configurar.png" alt=""> Configuraciones <span class="{{ request()->routeIs('configuraciones.*') ? '' : 'desactive' }} nav-span" ><</span></div>
            <div class="nav-item-cont {{ request()->routeIs('configuraciones.*') ? '' : 'desactive' }}" >
                <a href="{{route('configuraciones.edit')}}" class="{{request()->routeIs('configuraciones.*')?'active': ''}}">Cambiar contraseña</a>
            </div>
        </div>
        <button class="btn-cerrar-menu">x</button>
    </section>
    <header>
        <div class="cont-menu">
            <img src="/img/menu.png" alt="menu">
        </div>
        <div class="cont-logo">
            <img src="" alt="Logo">
        </div>
        <form class="form_cerrar_sesion" action="{{route('cerrarSesion')}}" method="POST">@csrf <button><img src="/img/salida.png" alt="salida"></button></form>
    </header>
    <main>
        @yield('contenido')
    </main>
    @yield('scripts')
    <script src="/js/menu_navegacion.js"></script>
    <script src="/js/menu_hamburguesa.js"></script>
</body>
</html>