<?php

namespace App\Http\Controllers;

use App\Exports\GananciasExport;
use App\Exports\ImportesExport;
use App\Models\Clientes;
use App\Models\Entradas;
use App\Models\FacturasClientes;
use App\Models\Ganancias;
use App\Models\Importes;
use App\Models\Perdidas;
use App\Models\PerdidasCredito;
use App\Models\Productos;
use App\Models\Proveedor;
use App\Models\SalidasVentas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class InicioController extends Controller
{
    public function index() {
        $cantidadProveedores = count(Proveedor::all());
        $cantidadProductos = count(Productos::all());
        $cantidadClientes = count(Clientes::all());
        $cantidadFacturas = count(FacturasClientes::all());
        $facturas = FacturasClientes::all();
        $entradas = Entradas::all();
        $productosFactura = SalidasVentas::all();
        $importes = Importes::all();
        $perdidasPorDano = Perdidas::all();
        $perdidasPorPago = PerdidasCredito::all();
        $productoCompleto = SalidasVentas::leftjoin('facturas_clientes','salidas_ventas.id_factura_cliente','=','facturas_clientes.id_factura_cliente')
        ->select('facturas_clientes.*','salidas_ventas.*')->get();



        $totalCantidadEntradas = 0;
        $totalCantidadVentas = 0;
        $totalImporteVendido = 0;
        $totalImportePagado = 0;
        $totalSaldos = 0;
        $totalPerdidasPorDano = 0;
        $totalPerdidasPorPago = 0;
        $cantidadE = 0;
        $cantidadV = 0;


        foreach ($entradas as $entrada) {
            $totalCantidadEntradas += $entrada->cantidad_entrada;
        }
        foreach ($productosFactura as $producto) {
            $totalCantidadVentas += $producto->cantidad_entregada;
            if($producto->aplica_iva === "si"){

            }else {

            }
        }
        foreach($facturas as $factura){
            $totalImporteVendido += $factura->valor_total;
            $totalSaldos += $factura->debe;
        }
        foreach ($importes as $importe) {
            $cantidadE = $importe->cantidad_importe * $importe->costo_inversion;
            $totalImportePagado += $cantidadE;
        }

        foreach ($perdidasPorDano as $perdida){
            $totalPerdidasPorDano += $perdida->total_perdida;
        }
        foreach($perdidasPorPago as $perdida){
            $totalPerdidasPorPago += $perdida->total_debe;
        }

        $totalGanancias = $totalImporteVendido - $totalSaldos;

        return view('inicio.inde', compact('cantidadProveedores', 'cantidadProductos','cantidadClientes','cantidadFacturas',
        'totalCantidadEntradas','totalCantidadVentas','totalImporteVendido','totalImportePagado','totalSaldos',
        'totalGanancias','totalPerdidasPorDano','totalPerdidasPorPago'));
    }

    public function exportImportes(){
        if(Auth::user()->rol === "administrador"){
            return Excel::download(new ImportesExport, 'importes.xlsx');
        }
        return redirect()->route('inicio.index');
    }
    public function exportGanancias(){
        if(Auth::user()->rol === "administrador"){
            return Excel::download(new GananciasExport, 'ganancias.xlsx');
        }
        return redirect()->route('inicio.index');
    }
}
