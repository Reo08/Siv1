<?php

namespace App\Exports;

use App\Models\Entradas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EntradasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('entradas.export',[
            'entradas' => Entradas::leftjoin('productos','entradas.id_producto','=','productos.id_producto')
            ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
            ->leftjoin('usuarios','entradas.identificacion','=','usuarios.identificacion')
            ->select('entradas.*','entradas.created_at as created','entradas.updated_at as updated', 'productos.*', 'categorias.*','usuarios.nombre as nombre_usuario')->distinct()->get()
        ]);
    }
}
