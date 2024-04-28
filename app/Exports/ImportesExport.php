<?php

namespace App\Exports;

use App\Models\Importes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ImportesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('inicio.importeExport',[
            'importes' => Importes::leftjoin('productos', 'importes_pagados.id_producto','=','productos.id_producto')->select('importes_pagados.*', 'importes_pagados.created_at as created', 'importes_pagados.updated_at as updated', 'productos.*')->get()
        ]);
    }
}
