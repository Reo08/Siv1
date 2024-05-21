<?php

namespace App\Exports;

use App\Models\Entradas;
use App\Models\Importes;
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
        $importes = Importes::leftjoin('productos','importes_pagados.referencia','=','productos.referencia')
        ->select('importes_pagados.*','productos.referencia as referencia_producto','productos.nombre_producto')->get();
        return view('entradas.export',[
            'entradas' => Entradas::leftjoin('productos','entradas.referencia','=','productos.referencia')
            ->leftjoin('categorias','productos.id_categoria','=','categorias.id_categoria')
            ->leftjoin('usuarios','entradas.id_usuario','=','usuarios.id_usuario')
            ->select('entradas.*', 'productos.*', 'categorias.*','usuarios.nombre as nombre_usuario')->distinct()->get(),
            'importes' => $importes
        ]);
    }
}
