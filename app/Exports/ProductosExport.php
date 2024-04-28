<?php

namespace App\Exports;

use App\Models\Productos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductosExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('productos.export',[
            'productos' => Productos::leftjoin('categorias', 'productos.id_categoria', '=', 'categorias.id_categoria')
            ->leftjoin('proveedor', 'productos.id_proveedor', '=', 'proveedor.id_proveedor')
            ->select('productos.*', 'categorias.nombre_categoria as categoria', 'proveedor.nombre_proveedor as nombre_proveedor')->get()
        ]);
    }
}
