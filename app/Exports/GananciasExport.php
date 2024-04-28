<?php

namespace App\Exports;

use App\Models\Ganancias;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GananciasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('inicio.gananciasExport', [
            'ganancias' => Ganancias::leftjoin('salidas_ventas','ganancias.id_salida_venta','=','salidas_ventas.id_salida_venta')->select('ganancias.*','salidas_ventas.*')->get()
        ]);
    }
}
