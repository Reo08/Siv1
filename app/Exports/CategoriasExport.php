<?php

namespace App\Exports;

use App\Models\Categorias;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CategoriasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('categorias.export', [
            'categorias' => Categorias::all()
        ]);
    }
}
