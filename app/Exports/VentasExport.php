<?php

namespace App\Exports;

use App\Models\SalidasVentas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VentasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('ventas.export',[
            'ventas' => SalidasVentas::leftjoin('productos','salidas_ventas.id_producto','=','productos.id_producto')
            ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
            ->leftjoin('proveedor','productos.id_proveedor','=','proveedor.id_proveedor')
            ->leftjoin('usuarios','salidas_ventas.identificacion','=','usuarios.identificacion')
            ->select('salidas_ventas.*','salidas_ventas.created_at as created','salidas_ventas.updated_at as updated', 'productos.*', 'categorias.*','proveedor.*','usuarios.nombre as nombre_usuario')->distinct()->get()
        ]);
    }
}
