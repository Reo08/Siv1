<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ConfiguracionesController;
use App\Http\Controllers\EntradasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PerdidasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('login');
Route::post('ingresar', [SesionController::class, 'create'])->name('create');

Route::middleware('auth')->group(function(){
    Route::post('cerrarSesion', [SesionController::class, 'destroy'])->name('cerrarSesion');

    Route::controller(InicioController::class)->group(function(){
        Route::get('inicio', 'index')->name('inicio.index');
        
        Route::get('exportar-importes', 'exportImportes')->name('inicio.exportImportes');
        Route::get('exportar-ganancias','exportGanancias')->name('inicio.exportGanancias');
    });

    Route::controller(ClientesController::class)->group(function(){
        Route::get('clientes','index')->name('clientes.index');
        Route::get('clientes/agregar-cliente', 'create')->name('clientes.create');
        Route::post('clientes', 'store')->name('clientes.store');
        Route::get('clientes/{nit}/editar-cliente','edit')->name('clientes.edit');
        Route::put('clientes/{nit}', 'update')->name('clientes.update');
        Route::delete('clientes/{nit}', 'destroy')->name('clientes.destroy');
    });
    
    Route::controller(ProveedoresController::class)->group(function(){
        Route::get('proveedores', 'index')->name('proveedores.index');
        Route::get('proveedores/agregar-proveedor', 'create')->name('proveedores.create');
        Route::post('proveedores', 'store')->name('proveedores.store');
        Route::get('proveedores/{id}/editar-proveedor','edit')->name('proveedores.edit');
        Route::put('proveedores/{id}', 'update')->name('proveedores.update');
        Route::delete('proveedores/{id}', 'destroy')->name('proveedores.destroy');

        Route::get('exportar-proveedores', 'export')->name('proveedores.export');
    });
    
    Route::controller(CategoriasController::class)->group(function(){
        Route::get('categorias', 'index')->name('categorias.index');
        Route::get('categorias/crear-categoria', 'create')->name('categorias.create');
        Route::post('categorias', 'store')->name('categorias.store');
        Route::get('categorias/{id}/actualizar-categoria','edit')->name('categorias.edit');
        Route::put('categorias/{id}', 'update')->name('categorias.update');
        Route::delete('categorias/{id}', 'destroy')->name('categorias.delete');

        Route::get('exportar-categorias', 'export')->name('categorias.export');
    });
    
    Route::controller(ProductosController::class)->group(function(){
        Route::get('productos', 'index')->name('productos.index');
        Route::get('productos/agregar-producto', 'create')->name('productos.create');
        Route::post('productos', 'store')->name('productos.store');
        Route::get('productos/{id}/editar-producto','edit')->name('productos.edit');
        Route::put('productos/{id}', 'update')->name('productos.update');
        Route::delete('productos/{id}', 'destroy')->name('productos.delete');

        Route::get('exportar-productos', 'export')->name('productos.export');
    });
    
    Route::controller(EntradasController::class)->group(function(){
        Route::get('entradas-stock', 'index')->name('entradas.index');
        Route::get('entradas-stock/agregar-existencia', 'create')->name('entradas.create');
    
        Route::get('productos-por-categoria/{id}', 'productosCategoria');// aqui es para enviarle datos a javascript por peticion
        Route::get('proveedores-select/{id}', 'proveedoresSelect');// aqui es para enviarle datos a javascript por peticion
    
        Route::post('entradas-stock', 'store')->name('entradas.store');
        Route::get('entradas-stock/{id}/editar-existencia','edit')->name('entradas.edit');
        Route::put('entradas-stock/{id}', 'update')->name('entradas.update');
        
        Route::get('entradas-stock/{id}/editar-cantidad', 'editCantidad')->name('entradas.edit.cantidad');
        Route::put('entradas-stock/{id}/editar-cantidad', 'updateCantidad')->name('entradas.update.cantidad');
        Route::delete('entradas-stock/{id}', 'destroy')->name('entradas.delete');

        Route::get('exportar-entradas','export')->name('entradas.export');
    });
    
    Route::controller(VentasController::class)->group(function(){
        Route::get('ventas', 'index')->name('ventas.index');
        Route::get('ventas/agregar-venta', 'create')->name('ventas.create');
    
        Route::get('productos-categoria-ventas/{id}', 'productosCategoria'); // aqui es para enviarle datos a javascript por peticion
        Route::get('proveedores-select-ventas/{id}', 'proveedoresSelect');// aqui es para enviarle datos a javascript por peticion
    
        Route::post('ventas', 'store')->name('ventas.store');
        Route::delete('ventas/{id}', 'destroy')->name('ventas.delete');

        Route::get('exportar-ventas', 'export')->name('ventas.export');
    });
    
    Route::controller(PerdidasController::class)->group(function(){
        Route::get('perdidas', 'index')->name('perdidas.index');
        Route::get('perdidas/agregar-perdida', 'create')->name('perdidas.create');
    
        Route::get('productos-categoria-perdidas/{id}', 'productosCategoria'); // aqui es para enviarle datos a javascript por peticion
        Route::get('proveedores-select-perdidas/{id}', 'proveedoresSelect');// aqui es para enviarle datos a javascript por peticion
    
        Route::post('perdidas', 'store')->name('perdidas.store');
        Route::delete('perdidas/{id}', 'destroy')->name('perdidas.delete');

        Route::get('exportar-perdidas', 'export')->name('perdidas.export');
    });
    
    
    Route::controller(UsuariosController::class)->group(function(){
        Route::get('usuarios', 'index')->name('usuarios.index');
        Route::get('usuarios/agregar-usuario', 'create')->name('usuarios.create');
        Route::post('usuarios', 'store')->name('usuarios.store');

        Route::get('usuarios/{identificacion}/editar-usuario', 'edit')->name('usuarios.edit');
        Route::put('usuarios/{identificacion}', 'update')->name('usuarios.update');

        Route::delete('usuarios/{identificacion}', 'destroy')->name('usuarios.delete');

        Route::get('exportar-usuarios','export')->name('usuarios.export');
    });

    // Tengo que empezar a hacer la programacion de las busquedas
    Route::controller(ConfiguracionesController::class)->group(function(){
        Route::get('configuraciones/cambiar-contrasena', 'edit')->name('configuraciones.edit');
        Route::put('configuraciones/{identificacion}', 'update')->name('configuraciones.update');
        Route::get('madeby', 'hello')->name('helloword');
    });

    Route::controller(ResetController::class)->group(function(){
        Route::delete('reset-bd', 'destroy')->name('reset.delete');
    });
    
});
