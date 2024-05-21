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

        // Ver estado de cuenta
        Route::get('clientes/{nit}/estado-cuenta', 'indexEstadoCuenta')->name('clientes.estadoCuenta');
        
        Route::get('exportar-clientes', 'export')->name('clientes.export');
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
    
    // Route::controller(ProductosController::class)->group(function(){
    //     Route::get('productos', 'index')->name('productos.index');
    //     Route::get('productos/agregar-producto', 'create')->name('productos.create');
    //     Route::post('productos', 'store')->name('productos.store');
    //     Route::get('productos/{id}/editar-producto','edit')->name('productos.edit');
    //     Route::put('productos/{id}', 'update')->name('productos.update');
    //     Route::delete('productos/{id}', 'destroy')->name('productos.delete');

    //     Route::get('exportar-productos', 'export')->name('productos.export');
    // });
    
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
        Route::get('ventas/agregar-venta', 'create')->name('ventas.create');//ir al form para crear la factura
        Route::post('ventas', 'store')->name('ventas.store');//creando factura
        Route::get('ventas-abonar/{id_factura}', 'editAbonarFactura')->name('ventas.editAbonarFactura');//ir al form de abonar a la factura
        Route::put('ventas-abonar/{id_factura}', 'updateAbonarFactura')->name('ventas.updateAbonarFactura');
        Route::get('ventas-ver-pagos/{id_factura}', 'indexPagos')->name('ventas.indexPagos');// Aqui vemos los pagos
        Route::delete('eliminar-pago/{id_pago}','destroyPago')->name('ventas.detelePagos');
        Route::get('ventas-editar-fecha/{id_factura}', 'editFechaFactura')->name('ventas.editFechaFactura');//ir al form de modificar fecha limite de pago
        Route::put('ventas-editar-fecha/{id_factura}', 'updateFechaFactura')->name('ventas.updateFechaFactura');//Modificando la fecha limite de pago

        Route::get('ventas-datos-empresa/{id_factura}','createFacturaPdf')->name('ventas.createDescargarFactura');
        Route::post('ventas-datos-empresa/{id_factura}','storeFacturaPdf')->name('ventas.storeDescargarFactura');
        Route::get('descargar-factura/{id_factura}', 'facturaPdf')->name('ventas.descargarFactura');// Ruta para imprimir la factura

        Route::delete('eliminar-factura/{id_factura}', 'destroy')->name('ventas.delete');//destruir factura

        // productos de factura
        Route::get('ventas-productos/{id_factura}', 'indexProductos')->name('ventas.indexProductos');//index de productos de la factura
        Route::get('ventas-productos-agg/{id_factura}', 'createProducto')->name('ventas.createProducto');//ir al form para agregar producto a factura

        Route::get('categorias-select-ventas/{id}', 'categoriasSelect');// aqui es para enviarle datos a javascript por peticion
        Route::get('productos-existencia-ventas/{id}', 'productosExistencia'); // aqui es para enviarle datos a javascript por peticion
        Route::get('pedir-factura-electronica/{id}', 'pedirFacturaElectronica'); // aqui es para enviarle datos a javascript por peticion
        Route::post('enviar-retencion/{id}', 'enviarRetencion');

        Route::post('ventas-productos-agg/{id_factura}', 'storeProducto')->name('ventas.storeProducto');//Agregando producto a factura
        Route::get('ventas-productos-agg/{id_factura}/{id_salida_venta}', 'editProducto')->name('ventas.editProducto');//ir al form para editar producto de la factura
        Route::put('ventas-productos-agg/{id_factura}/{id_salida_venta}','updateProducto')->name('ventas.updateProducto');//Editando producto de la factura
        Route::delete('eliminar-producto-factura/{id_factura}/{id_salida_venta}', 'destroyProducto')->name('ventas.deleteProducto');//Eliminando el producto de la factura

        Route::get('exportar-ventas', 'exportFacturas')->name('ventas.exportFacturas');
    });
    
    Route::controller(PerdidasController::class)->group(function(){
        Route::get('perdidas-total', 'index')->name('perdidas.index');
        Route::get('perdidas/agregar-perdida', 'create')->name('perdidas.create');
    
        Route::get('productos-categoria-perdidas/{id}', 'productosCategoria'); // aqui es para enviarle datos a javascript por peticion
        Route::get('proveedores-select-perdidas/{id}', 'proveedoresSelect');// aqui es para enviarle datos a javascript por peticion
    



        // Perdias por daño
        Route::get('perdidas-total/por-dano','indexPorDano')->name('perdidas.porDano');
        Route::get('perdidas-total/por-dano/{id_perdida}/editar', 'editPorDano')->name('perdidas.porDanoEditar');
        Route::put('perdidas-total/por-dano/{id_perdida}', 'updatePorDano')->name('perdidas.porDanoupdate');
        Route::delete('perdidas-total/eliminar/{id_perdida}', 'destroyPorDano')->name('perdidas.porDanoDelete');

        // Perdidas por falta de pago
        Route::get('perdidas-total/por-pago','indexPorPago')->name('perdidas.porPago');
        Route::get('perdidas-total/por-pago/agregar', 'createPorPago')->name('perdidas.porPagoCreate');
        Route::post('perdidas-total/por-pago', 'storePorPago')->name('perdidas.porPagoStore');
        Route::delete('eliminar-por-pago/{id_porPago}', 'destroyPorPago')->name('perdidas.porPagoDestroy');

        Route::get('exportar-perdidas', 'exportPorDano')->name('perdidas.exportPorDano');
        Route::get('exportar-perdidas-por-pago', 'exportPorPago')->name('perdidas.exportPorDago');
    });
    
    
    Route::controller(UsuariosController::class)->group(function(){
        Route::get('usuarios', 'index')->name('usuarios.index');
        Route::get('usuarios/agregar-usuario', 'create')->name('usuarios.create');
        Route::post('usuarios', 'store')->name('usuarios.store');

        Route::get('usuarios/{id_usuario}/editar-usuario', 'edit')->name('usuarios.edit');
        Route::put('usuarios/{id_usuario}', 'update')->name('usuarios.update');

        Route::delete('usuarios/{id_usuario}', 'destroy')->name('usuarios.delete');

        Route::get('exportar-usuarios','export')->name('usuarios.export');
    });

    // Tengo que empezar a hacer la programacion de las busquedas
    Route::controller(ConfiguracionesController::class)->group(function(){
        Route::get('configuraciones/cambiar-contrasena', 'edit')->name('configuraciones.edit');
        Route::put('configuraciones/{id_usuario}', 'update')->name('configuraciones.update');
        Route::get('madeby', 'hello')->name('helloword');
    });

    Route::controller(ResetController::class)->group(function(){
        Route::delete('reset-bd', 'destroy')->name('reset.delete');
    });
    
});
