<?php

namespace App\Exports;

use App\Models\FacturasClientes;
use App\Models\PagosFacturas;
use App\Models\SalidasVentas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FacturasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $facturas = FacturasClientes::leftjoin('clientes', 'facturas_clientes.nit_cedula','=','clientes.nit_cedula')
        ->select('facturas_clientes.*','clientes.*')->distinct()->get();
        $pagos = PagosFacturas::leftjoin('clientes','pagos_facturas.nit_cedula','=','clientes.nit_cedula')
        ->select('pagos_facturas.*','clientes.nombre_cliente')->distinct()->get();
        $productosFacturas =  SalidasVentas::leftjoin('entradas','salidas_ventas.id_entrada','=','entradas.id_entrada')
        ->leftjoin('productos','entradas.referencia','=','productos.referencia')
        ->select('salidas_ventas.*','productos.nombre_producto', 'productos.referencia')->distinct()->get();

        return view('ventas.facturasExport',[
            "facturas" => $facturas,
            "pagos" => $pagos,
            "facturasProductos" => $productosFacturas
        ]);   
    }
}
