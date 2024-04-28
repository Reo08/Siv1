<?php

namespace App\Http\Controllers;

use App\Models\Entradas;
use App\Models\Ganancias;
use App\Models\Importes;
use App\Models\Productos;
use App\Models\Proveedor;
use App\Models\SalidasVentas;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index() {
        $cantidadProveedores = count(Proveedor::all());
        $cantidadProductos = count(Productos::all());
        $entradas = Entradas::all();
        $ventas = SalidasVentas::all();
        $importes = Importes::all();
        $ganancias = Ganancias::all();

        $totalCantidadEntradas = 0;
        $totalCantidadVentas = 0;
        $totalImporteVendido = 0;
        $totalImportePagado = 0;
        $totalGanancias = 0;
        $cantidadE = 0;
        $cantidadV = 0;


        foreach ($entradas as $entrada) {
            $totalCantidadEntradas += $entrada->cantidad_entrada;
        }
        foreach ($ventas as $venta) {
            $totalCantidadVentas += $venta->cantidad;
            $cantidadV = $venta->cantidad * $venta->precio_venta; 
            $totalImporteVendido += $cantidadV;
        }
        foreach ($importes as $importe) {
            $cantidadE = $importe->cantidad_importe * $importe->precio_compra;
            $totalImportePagado += $cantidadE;
        }
        foreach ($ganancias as $ganancia){
            $totalGanancias += $ganancia->total_ganancia;
        }

        $totalVentas = $totalImporteVendido - $totalImportePagado;

        // Falta calcular el total ganancias y el total perdidas

        return view('inicio.inde', compact('cantidadProveedores', 'cantidadProductos', 'totalCantidadEntradas','totalCantidadVentas','totalImporteVendido','totalImportePagado','totalVentas','totalGanancias'));
    }
}
