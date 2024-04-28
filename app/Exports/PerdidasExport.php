<?php

namespace App\Exports;

use App\Models\SalidasPerdidas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PerdidasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('perdidas.export',[
            'perdidas' => SalidasPerdidas::leftjoin('productos','salidas_perdidas.id_producto','=','productos.id_producto')
            ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
            ->leftjoin('proveedor','productos.id_proveedor','=','proveedor.id_proveedor')
            ->leftjoin('usuarios','salidas_perdidas.identificacion','=','usuarios.identificacion')
            ->select('salidas_perdidas.*','salidas_perdidas.created_at as created','salidas_perdidas.updated_at as updated', 'productos.*', 'categorias.*','proveedor.*','usuarios.nombre as nombre_usuario')->distinct()->get()
        ]);
    }
}
